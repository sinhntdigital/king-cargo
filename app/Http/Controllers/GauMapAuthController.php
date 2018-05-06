<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\LoginHistory;
use App\Models\UserTree;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Jenssegers\Agent\Agent;
use ReCaptcha\ReCaptcha;

/**
 * Class GauMapAuthController
 *
 * @package App\Http\Controllers
 */
class GauMapAuthController extends Controller {

    use RedirectsUsers;

    /**
     * Check user credential
     *
     * @param $email
     * @param $password
     *
     * @return bool
     *
     */
    public function checkUserCredential ($email, $password) {
        try {
            $user = User::whereEmail($email)->first();
            if (empty($user))
                return false;

            return \Hash::check($password, $user->password);
        } catch (\Exception $ex) {
            return false;
        }
    }

    /**
     * Route login
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function getLogin () {
        try {
            if (\Auth::check())
                return redirect()->to('/');
            $referId  = '';
            $formName = 'm-login--signin';

            return view('auth.login', compact(['formName', 'referId']));
        } catch (\Exception $ex) {
            abort(500);
        }
    }

    /**
     * Login user via ajax
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin (Request $request) {
        try {
            // If user is logged in
            if (\Auth::check())
                return response()->json(['success' => 'You are logged', 'redirect_url' => route('gmGetLogin')], 200);

            // If empty email or password
            $validator = \Validator::make($request->all(), [
                'email'    => 'required|string|email',
                'password' => 'required|string',
            ]);
            if ($validator->fails())
                return response()->json(['error' => $validator->messages()], 200);

            // Check user
            $user = User::whereEmail($request->email)->first();
            if (empty($user) || !\Hash::check($request->password, $user->password))
                return response()->json(['error' => 'Username or password does not match, please try again.'], 200);

            // Check security
            if (!empty($user->security_mode) && (int)$user->enable_login2fa === 1) {
                $check = $user->checkSecurity($request->secrect_question, $request->security_confirm);
                if ($check['type'] !== 'success')
                    return response()->json([$check['type'] => $check['message']], 200);
            }

            // Check recaptcha
            $input     = $request->only('g-recaptcha-response');
            $recaptcha = new ReCaptcha(env('RECAPTCHA_SECRECT'));
            $resp      = $recaptcha->verify($input['g-recaptcha-response']);
            if (!$resp->isSuccess())
                return response()->json(['robot' => 'Please verify that you are not a robot.'], 200);

            if ($user->status === 'Disable')
                return response()->json(['error' => 'Your account has been deactived. An email had been send to your email address, please follow this email to active your account.'], 200);

            if (\Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
                $request->session()->regenerate();
                User::updateLoginTime($request);

                return response()->json(['success' => 'You are logged', 'redirect_url' => route('gmGetDashboardPage')], 200);
            }

            return response()->json(['error' => 'Email or password does not match, please try again.'], 200);
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage(), 500);
        }
    }

    /**
     * Route register
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getRegister (Request $request) {
        try {
            if (\Auth::check())
                return redirect()->to('/');

            $formName = 'm-login--signup';

            // Check refer ID
            $referId = $request->refer;
            if (!empty($referId)) {
                $user = User::whereName($referId)->first();
                if (!empty($user)) {
                    $referId  = User::whereName($referId)->first()->id;
                    $userName = $user->name;
                } else {
                    $referId  = '';
                    $userName = '';
                }
            }

            return view('auth.login', compact(['formName', 'referId', 'userName']));
        } catch (\Exception $ex) {
            abort(500);
        }
    }

    /**
     * Register new user
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRegister (Request $request) {
        try {
            // Validate request
            $validator = \Validator::make($request->all(), [
                'name'                  => 'required|string|max:255|unique:users',
                'email'                 => 'required|string|email|max:255|unique:users',
                'password'              => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ]);
            if ($validator->fails())
                return response()->json(['invalid' => $validator->messages()], 200);

            // Check google recaptcha
            $input     = $request->only('g-recaptcha-response');
            $recaptcha = new ReCaptcha(env('RECAPTCHA_SECRECT'));
            $resp      = $recaptcha->verify($input['g-recaptcha-response']);
            if (!$resp->isSuccess())
                return response()->json(['error' => 'Please verify that you are not a robot.'], 200);

            // Check presenter code
            $parentId = null;
            $level    = 0;
            if (!empty($request->presenter_code)) {
                $parentUser = User::find($request->presenter_code);
                if (!empty($parentUser)) {
                    $level    = (int)$parentUser->level + 1;
                    $parentId = $request->presenter_code;
                }
            }

            // Check email exists and Create new user
            $checkEmail = User::sendEmailConfirmRegister($request->email, $request->name);
            if ($checkEmail)
                $newUser = User::create([
                                            'id'        => \Helpers::generateId(),
                                            'name'      => $request->name,
                                            'email'     => $request->email,
                                            'password'  => \Hash::make($request->password),
                                            'parent_id' => $parentId,
                                            'level'     => $level,
                                            'status'    => 'Disable',
                                        ]);


            if (!empty($newUser))
                return response()->json(['success' => 'Thank you for signing up. An email had been send to ' . $request->email . '. Please following this email to activate your account.'], 200);
            else
                return response()->json(['success' => 'Cannot create new user, please contact system administrator'], 200);

        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function getConfirmRegister (Request $request) {
        try {
            $name = $request->name;
            $user = User::whereName($name)->first();

            if (empty($user))
                abort(404);

            if ($user->status === 'Enable')
                return redirect()->route('gmGetLogin');

            User::sendEmailWelcomeNewUser($user->email);
            $user->update(['status' => 'Enable']);

            return redirect()->route('gmGetLogin')->with(['confirm_success' => 'Your account had been actived. Please login with your email and password.']);
        } catch (\Exception $ex) {
            dd($ex);
            abort(500);
        }
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function socialLoginRedirect (Request $request) {
        try {
            return \Socialite::driver($request->driver)->redirect();
        } catch (\Exception $ex) {
            abort(500);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function socialLoginCallback (Request $request) {
        try {
            $data = \Socialite::driver($request->driver)->user();

            $userName = explode('@', $data->email)[0];

            // Check if user has already register
            $user = User::whereEmail($data->email)->first();

            if (empty($user)) {
                $checkEmail = User::sendEmailConfirmRegister($data->email, $userName);
                if ($checkEmail) {
                    $user = User::create([
                                             'id'       => \Helpers::generateId(),
                                             'email'    => $data->email,
                                             'name'     => $userName,
                                             'password' => \Hash::make($data->email),
                                             'status'   => 'Disable',
                                         ]);
                    return redirect()->route('gmGetLogin')->with(['confirm_success' => 'Thank you for signing up. An email had been send to your email address. Please following this email to activate your account.']);
                }
            }

            if (\Auth::loginUsingId($user->id, true)) {
                User::updateLoginTime($request);

                return redirect()->route('gmGetDashboardPage');
            } else
                return redirect()->route('gmGetLogin');
        } catch (\Exception $ex) {
            // dd($ex->getMessage());
            abort(500);
        }
    }

    /**
     * Route forget password
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLostPassword () {
        return view('auth.passwords.email');
    }

    /**
     * Process forgot password
     *
     * Note: add this to config/mail.php
     *
     * 'stream' => [
     *    'ssl' => [
     *       'allow_self_signed' => true,
     *       'verify_peer'       => false,
     *       'verify_peer_name'  => false,
     *       ],
     *    ],
     *
     * @param Request $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postLostPassword (Request $request) {
        try {
            // Check request
            $validator = \Validator::make($request->all(), ['email' => 'required|email']);
            if ($validator->fails())
                return response()->json(['invalid' => $validator->messages()], 200);

            // Check google recaptcha
            $input     = $request->only('g-recaptcha-response');
            $recaptcha = new ReCaptcha(env('RECAPTCHA_SECRECT'));
            $resp      = $recaptcha->verify($input['g-recaptcha-response']);
            if (!$resp->isSuccess())
                return response()->json(['error' => 'Please verify that you are not a robot.'], 200);

            // Check email has been store
            $email = $request->email;
            $user  = User::whereEmail($email)->first();
            if (empty($user))
                return response()->json(['error' => 'Sorry, we cannot find this email.', 200]);

            // Generate new password
            $newPassword    = strtoupper(str_random(16));
            $user->password = \Hash::make($newPassword);
            $user->save();

            // Send email with new password to user
            Mail::send('email.reset-password', ['email' => $request->email, 'password' => $newPassword], function ($message) use ($email) {
                $message->from(env('MAIL_USERNAME'), 'Trade Exchange');
                $message->to($email, 'Reset password')->subject('Reset password');
            });

            return response()->json(['success' => true], 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Logout user
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postLogout (Request $request) {
        try {
            \Auth::logout();
            // $request->session()->invalidate();
            if ($request->wantsJson())
                return response()->json(['success' => true], 200);

            return redirect()->route('gmGetLogin');
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex], 500);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getChangePassword () {
        return view('auth.change-password');
    }

    /**
     * Update change user password
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postChangePassword (Request $request) {
        try {
            // Validate request
            $validator = \Validator::make($request->all(), [
                'old_password'          => 'required|string|min:6',
                'password'              => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required|min:6',
            ]);
            if ($validator->fails())
                return response()->json(['invalid' => $validator->messages()], 200);

            // Get user
            $user = \Auth::user();

            // Check old password
            if (!\Hash::check($request->old_password, $user->password))
                return response()->json(['error' => 'Your old password does not match, please try again.'], 200);

            // Update new password
            $user->password = \Hash::make($request->password);
            $user->save();

            return response()->json(['success' => true], 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Get view to edit user profile
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getViewProfile () {
        $user = \Auth::user();

        return view('auth.profile-view', compact('user'));
    }

    /**
     * Update user profile
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function putUpdateProfile (Request $request) {
        try {
            // Validate request
            $validator = \Validator::make($request->all(), [
                'first_name' => 'required|string|max:80',
                'last_name'  => 'required|string|max:80',
                'country'    => 'required|string|max:35',
                'phone'      => 'required|string|max:25',
                'birthday'   => 'required',
            ]);
            if ($validator->fails())
                return response()->json(['invalid' => $validator->messages()], 200);

            $user  = \Auth::user();
            $input = $request->only(['first_name', 'last_name', 'country', 'phone', 'birthday', 'security_mode', 'enable_login2fa', 'receive_newletter']);

            // Check confirmation code
            $security_mode = \Auth::user()->security_mode;
            if ($security_mode !== $input['security_mode']) {
                if (!array_key_exists('security_confirm', $request->all())) {
                    return $this->getConfirmSecurity($request);
                } else {
                    $security_mode = $input['security_mode'];
                    if (!empty($request->confirm_mode)) {
                        if (empty($request->security_confirm))
                            return response()->json(['error' => 'Your security code does not match, please try again'], 200);

                        switch ($security_mode) {
                            case 'google_2fa':
                                if (!User::checkGoogle2Fa($request->security_confirm))
                                    return response()->json(['error' => 'Your security code does not match, please try again'], 200);
                                break;
                            case 'email_confirm':
                                if (!User::checkEmailConfirmCode($request->security_confirm))
                                    return response()->json(['error' => 'Your security code does not match, please try again'], 200);
                                break;
                            case 'sms_confirm':
                                if (!User::checkEmailConfirmCode($request->security_confirm))
                                    return response()->json(['error' => 'Your security code does not match, please try again'], 200);
                                break;
                            case 'secrect_question':
                                $input['secrect_question'] = $request->secrect_question;
                                $input['secrect_answer']   = $request->security_confirm;
                                break;
                            default:
                                if (!\Hash::check($request->security_confirm, $user->password))
                                    return response()->json(['error' => 'Your password does not match, please try again.'], 200);
                                break;
                        }
                    } else {
                        return $this->getConfirmSecurity($request);
                    }
                }
            } else {
                // if user change phone number
                if ($user->phone !== $input['phone'])
                    return $this->getConfirmSecurity($request);
            }


            // Update user info
            $input['birthday']          = Carbon::createFromFormat('d/m/Y', $input['birthday'])->toDateTimeString();
            $input['enable_login2fa']   = array_key_exists('enable_login2fa', $input) ? 1 : 0;
            $input['receive_newletter'] = array_key_exists('receive_newletter', $input) ? 1 : 0;
            $user->update($input);

            return response()->json(['success' => $input], 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Get form for user to confirm security
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getConfirmSecurity (Request $request) {
        try {
            $inputs    = $request->all();
            $sendEmail = \Auth::user()->email;

            $phoneNumber = '+' . Country::find($inputs['country'])->phonecode . $request->phone;
            $response    = '';

            // Get security mode
            $security_mode = \Auth::user()->security_mode;
            if (array_key_exists('security_mode', $inputs))
                $security_mode = $inputs['security_mode'];

            switch ($security_mode) {
                case 'google_2fa':
                    $imageUrl = User::getGoogle2FaImage();
                    $response = "<div class=\"row\">
	                                <div class=\"col-4 offset-4\">
	                                    <img class=\"w-100\" src=\"$imageUrl\" alt=\"Google Authenticate QR Code\">
	                                </div>
	                            </div>
	                            <div class=\"form-group m-form__group row\">
	                                <div class=\"col-4 offset-4\">
	                                    <input type=\"text\" id=\"gm-form--security_confỉm--input\" name=\"security_confirm\" class=\"form-control m-input m-input--air gm-input--text text-center\"/>
	                                    <input type='hidden' name='confirm_mode' value='google_2fa'>
	                                </div>
	                            </div>";
                    break;
                case 'email_confirm':
                    $code = \Helpers::generateId(16);
                    User::sendEmailConfirmCode($code);
                    $response = "<div class=\"form-group m-form__group row\">
	                                    <label for=\"gm-form--security_confỉm--input\">Verify code</label>
	                                    <input type=\"text\" id=\"gm-form--security_confỉm--input\" name=\"security_confirm\" class=\"form-control m-input m-input--air gm-input--text text-center\"/>
	                                    <span class=\"m-form__help\">An email had been sent to $sendEmail with confirmation code.</span>
	                                    <input type='hidden' name='confirm_mode' value='email_confirm'>
		                            </div>";
                    break;
                case 'secrect_question':
                    $response = "<div class=\"form-group m-form__group row\">
		                                <label for=\"gm-form--security_confỉm--input\">Select secrect question</label>
		                                <select name='secrect_question' class=\"form-control m-input m-input--air gm-input--text\">
		                                    <option value=\"In what town or city was your first full time job?\">In what town or city was your first full time job?</option>
		                                    <option value=\"What primary school did you attend?\">What primary school did you attend?</option>
		                                    <option value=\"What was the house number and street name you lived in as a child?\">What was the house number and street name you lived in as a child?</option>
		                                    <option value=\"What are the last 4 digits of your driver's licence number?\">What are the last 4 digits of your driver's licence number?</option>
		                                    <option value=\"What is your spouse or partner's mother's maiden name?\">What is your spouse or partner's mother's maiden name?</option>
		                                    <option value=\"In what town or city did your mother and father meet?\">In what town or city did your mother and father meet?</option>
		                                    <option value=\"What is your pet’s name?\">What is your pet’s name?</option>
		                                    <option value=\"In what year was your father born?\">In what year was your father born?</option>
		                                    <option value=\"What is the first name of the person you first kissed?\">What is the first name of the person you first kissed?</option>
		                                    <option value=\"What is the last name of the teacher who gave you your first failing grade?\">What is the last name of the teacher who gave you your first failing grade?</option>
		                                    <option value=\"PIN code?\">PIN code?</option>
		                                </select>
		                            </div>
											 <div class=\"form-group m-form__group row\">
		                                <label for=\"gm-form--security_confỉm--input\">Your answer</label>
		                                <input type=\"text\" id=\"gm-form--security_confỉm--input\" name=\"security_confirm\" class=\"form-control m-input m-input--air gm-input--text\"/>
	                                   <input type='hidden' name='confirm_mode' value='secrect_question'>
		                            </div>";
                    break;
                case 'sms_confirm':
                    $code = rand(1000, 9999);
                    \Auth::user()->update(['email_code' => $code]);
                    User::sendSMS($phoneNumber, "Your verification code is $code.");
                    $response = "<div class=\"form-group m-form__group row\">
	                                    <label for=\"gm-form--security_confỉm--input\">Verify code</label>
	                                    <input id=\"gm-form--security_confỉm--input\" name=\"security_confirm\" class=\"form-control m-input m-input--air gm-input--text text-center\"/>
	                                    <span class=\"m-form__help\">An sms had been sent to $phoneNumber with confirmation code.</span>
	                                    <input type='hidden' name='confirm_mode' value='email_confirm'>
		                            </div>";
                    break;
                default:
                    $response = "<div class=\"form-group m-form__group row\">
	                                    <label for=\"gm-form--security_confỉm--input\">Your password</label>
	                                    <input type=\"password\" id=\"gm-form--security_confỉm--input\" name=\"security_confirm\" class=\"form-control m-input m-input--air gm-input--text text-center\"/>
	                                    <span class=\"m-form__help\">Confirm your password to remove two factor authenticate.</span>
	                                    <input type='hidden' name='confirm_mode' value='email_confirm'>
		                            </div>";
                    break;
            }

            return response()->json(['confirm_security' => $response], 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    /**
     * Get network tree page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getNetworkTreePage () {
        $user = \Auth::user();

        return view('auth.network-tree', compact('user'));
    }

    /**
     * Get network referral page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getNetworkReferralPage () {
        $user = \Auth::user();

        return view('auth.network-referral', compact('user'));
    }

    /**
     * Get F1 members of user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getNetworkMembersPage () {
        $user = \Auth::user();

        return view('auth.network-member', compact('user'));
    }

    /**
     * Check security for user
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCheckSecurity (Request $request) {
        try {
            // Get email of user

            if (\Auth::check()) {
                $user  = \Auth::user();
                $email = $user->email;
            } else {
                // If empty email or password
                $email    = $request->email;
                $password = $request->password;
                if (empty($email) || empty($password))
                    return response()->json(['error' => 'Username or password does not match, please try again.'], 200);

                // Check user
                $user = User::whereEmail($email)->first();
                if (empty($user) || !\Hash::check($password, $user->password))
                    return response()->json(['error' => 'Username or password does not match, please try again.'], 200);
            }

            $check = $user->checkSecurity($request->question, $request->answer);

            if ($check['type'] === 'success')
                return true;
            else
                return response()->json([$check['type'] => $check['message']], 200);

        } catch (\Exception $ex) {
            return response()->json(['error' => $ex], 500);
        }
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAssignMember (Request $request) {
        try {
            $user = \Auth::user();

            // CHeck if user is not create in user tree table
            $tree = UserTree::whereUserId($user->id)->first();
            if (empty($tree))
                UserTree::create([
                                     'user_id' => $user->id,
                                     'level'   => 0,
                                 ]);

            $userName = $request->user;
            $child    = User::whereName($userName)->first();
            if (empty($child))
                abort(404);

            return view('auth.assign-member', compact(['user', 'child']));
        } catch (\Exception $ex) {
            abort(500);
        }
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function putAssignMember (Request $request) {
        try {
            return response()->json(['success' => true], 200);
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

}
