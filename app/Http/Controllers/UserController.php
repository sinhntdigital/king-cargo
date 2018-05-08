<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller {
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request) {
        try {
                if($request->wantsJson()) {
                    $user = user::orderBy('created_at', 'DESC')->get();
                    return response()->json(['data' => $user], 200);
                } else {
                    return view('backend.user.index');
                }
            } catch(\Exception $ex) {
                if($request->wantsJson()) return response()->json(['error' => $ex->getMessage()], 200);
                else abort(500);
            }
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create () {
        return view('backend.user.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function store (Request $request) {
       try {
                $input          = $request->all();
                $input['id']    = \Helpers::generateId();
                $input['password'] = \Hash::make($input['password']);
                //                $input['creator_id'] = \Auth::user()->id;
                $employee = User::create($input);
                if(!empty($employee))
                    return response()->json(['success' => __('New employee had been created.')], 200);
                else
                    return response()->json(['error' => 'System error, please contact administrator.'], 200);
            } catch(\Exception $ex) {
                return response()->json(['error' => $ex->getMessage()], 200);
            }
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show ($id) {
     try {
                $user = User::find($id);
                if(empty($user)) return response()->json(['error' => 'Cannot find employee'], 200);
                return response()->json(['success' => $user], 200);
            } catch(\Exception $ex) {
                return response()->json(['error' => $ex->getMessage()], 200);
            }
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit ($id) {

    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update (Request $request, $id) {
         try {
                $employee = User::find($id);
                if(empty($employee)) return response()->json(['error' => 'Cannot find employee'], 200);
                $input = $request->all();
                $employee->update($input);
                return response()->json(['success' => ''], 200);
            } catch (\Exception $ex) {
                return response()->json(['error' => $ex->getMessage()], 200);
            }
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy ($id) {
        //
    }
}
