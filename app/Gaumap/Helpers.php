<?php
	namespace App\Gaumap;
	use Carbon\Carbon;
	
	/**
	 * Class Helpers
	 */
	class Helpers {
		
		/**
		 * Generate Id for datatable
		 *
		 * @param int $length
		 *
		 * @return string
		 */
		public static function generateId($length = 65) {
			$characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString     = '';
			for($i = 0; $i < $length; $i ++) {
				$randomString .= $characters[ rand(0, $charactersLength - 1) ];
			}
			
			return $randomString;
		}
		
		/**
		 * Format currency
		 *
		 * @param $number
		 *
		 * @return string
		 */
		public static function formatCurrency($number) {
			try {
				if(empty($number) || !is_numeric($number))
					return '0.000000';
				
				return number_format($number, 8);
			} catch(\Exception $ex) {
				return '0.000000';
			}
		}
		
		/**
		 * Format USD
		 *
		 * @param $number
		 *
		 * @return string
		 */
		public static function formatUSD($number) {
			try {
				if(empty($number) || !is_numeric($number))
					return '0.00';
				
				return number_format($number, 2);
			} catch(\Exception $ex) {
				return '0.00';
			}
		}
		
		/**
		 * Format USD
		 *
		 * @param $number
		 *
		 * @return string
		 */
		public static function formatDateTime($dateTime) {
			try {
				return Carbon::createFromFormat('Y-m-d H:i:s', $dateTime)->format('d/m/Y H:i:s');
			} catch(\Exception $ex) {
				return 'Invalid date';
			}
		}
		
		/**
		 * Read time to human time
		 *
		 * @param $thoiGian
		 *
		 * @return string
		 */
		public static function readHumanTime($thoiGian) {
			$seconds = Carbon::now()->diffInSeconds(Carbon::createFromFormat('Y-m-d H:i:s', $thoiGian));
			$minutes = round($seconds / 60);           // value 60 is seconds
			$hours   = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec
			$days    = round($seconds / 86400);          //86400 = 24 * 60 * 60;
			$weeks   = round($seconds / 604800);          // 7*24*60*60;
			$months  = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60
			$years   = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60
			if($seconds <= 60) {
				return "Just Now";
			} elseif($minutes <= 60) {
				if($minutes == 1) {
					return "an minute ago";
				} else {
					return "$minutes minutes ago";
				}
			} elseif($hours <= 24) {
				if($hours == 1) {
					return "an hour ago";
				} else {
					return "$hours hours ago";
				}
			} elseif($days <= 7) {
				if($days == 1) {
					return "yesterday";
				} else {
					return "$days days ago";
				}
			} elseif($weeks <= 4.3) {  //4.3 == 52/12
				if($weeks == 1) {
					return "last week";
				} else {
					return "$weeks weeks ago";
				}
			} elseif($months <= 12) {
				if($months == 1) {
					return "last month";
				} else {
					return "$months months ago";
				}
			} else {
				if($years == 1) {
					return "last year";
				} else {
					return "$years years ago";
				}
			}
		}
		
		/**
		 * Make network tree of user
		 *
		 * @param $rootUser
		 *
		 * @return string
		 */
		public static function makeNetworkTree($user, $level = 0) {
			try {
				$response = "<li>";
				$response .= $user->name;
				if(count($user->childrens) > 0) {
					$response .= "<ul>";
					foreach($user->childrens as $child) {
						$response .= self::makeNetworkTree($child, ++ $level);
					}
					$response .= "</ul>";
				}
				$response .= "</li>";
				
				return $response;
			} catch(\Exception $ex) {
				return '';
			}
		}
		
		/**
		 * Render form for user to confirm trading
		 *
		 * @return string
		 */
		public static function renderConfirmationForm() {
			try {
				$response      = '';
				$user          = \Auth::user();
				$security_mode = $user->security_mode;
				$sendEmail     = $user->email;
				$phoneNumber   = '+84' . $user->phone;
				switch($security_mode) {
					case 'google_2fa':
						$response = "<div class=\"form-group m-form__group row\">
	                                <div class=\"col-4 offset-4\">
	                                    <label for=\"gm-form--security_confỉm--input\">Verify code</label>
	                                    <input type=\"text\" id=\"gm-form--security_confỉm--input\" name=\"security_confirm\" class=\"form-control m-input m-input--air gm-input--text text-center\"/>
	                                    <span class=\"m-form__help\">Open your phone and check your code in Google authenticate code.</span>
	                                    <input type='hidden' name='confirm_mode' value='google_2fa'>
	                                </div>
	                            </div>";
						break;
					case 'email_confirm':
						$code = \Helpers::generateId(16);
						\App\Models\User::sendEmailConfirmCode($code);
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
		                                <select name='secrect_question' class=\"form-control m-input m-input--air\">
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
		                                <input type=\"text\" maxlength=\"255\" id=\"gm-form--security_confỉm--input\" name=\"security_confirm\" class=\"form-control m-input m-input--air gm-input--text\"/>
	                                   <input type='hidden' name='confirm_mode' value='secrect_question'>
		                            </div>";
						break;
					case 'sms_confirm':
						$code = rand(1000, 9999);
						\Auth::user()->update(['email_code' => $code]);
						\App\Models\User::sendSMS($phoneNumber, "Your verification code is $code.");
						$response = "<div class=\"form-group m-form__group row\">
	                                    <label for=\"gm-form--security_confỉm--input\">Verify code</label>
	                                    <input type=\"text\" id=\"gm-form--security_confỉm--input\" name=\"security_confirm\" class=\"form-control m-input m-input--air gm-input--text text-center\"/>
	                                    <span class=\"m-form__help\">An sms had been sent to $phoneNumber with confirmation code.</span>
	                                    <input type='hidden' name='confirm_mode' value='email_confirm'>
		                            </div>";
						break;
					default:
						$response = "<div class=\"form-group m-form__group row\">
	                                    <p class='m--font-danger'>You must set verify mode before do this action. Click <a href='" . route('gmGetViewProfile') . "'>here</a> to set verify mode.</p>
		                            </div>";
						break;
				}
				
				return $response;
			} catch(\Exception $ex) {
				return '';
			}
		}
		
	}