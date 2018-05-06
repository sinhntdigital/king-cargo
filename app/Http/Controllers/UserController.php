<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller {
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index () {
        //
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
            $input = $request->all();
            $input['id'] = \Helpers::generateId();
            $input['password'] = \Hash::make($input['password']);
            $newUser = User::create($input);
            dd($newUser);
        } catch (\Exception $ex) {
            abort(500);
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
            if(empty($user)) abort(404);
            // Return view
        } catch (\Exception $ex) {
            abort(500);
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
            $user = User::find($id);
            if(empty($user)) abort(404);
            $input = $request->all();
            $user->update($input);
        } catch (\Exception $ex) {
            abort(500);
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
