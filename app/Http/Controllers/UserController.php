<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function index() // return all records
    {
        $users = User::all();
        return parent::getResopnse(
            __('userMessages.index'),
            $user
        );
    }

    public function insert(Request $request) //add new record
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => [
                'required',
                Rule::in(['ADMIN','admin','ACCOUNTENT','accountent','MEMBER','member']),
            ],
            'password' => 'required'
        ]);

        $user =  new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = $request->password;
        $user->createdBy = auth()->user()->id;

        if (!$user->save()) {
            return parent::getResponse(
                __('accountMessages.cannotInsert'), 304);
        }

        return response()->json($user, 201);
    }

    public function update(Request $request) //update specific record
    {
        $user = User::find($request->userID);

        if (!$user) {
            return parent::getResopnse(
                __('userMessages.index'),
               404);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = $request->password;

        if (!$user->isDirty()) {
            return parent::getResponse(
                __('userMessages.noUpdates'),
                 200);
        }

        $user->udpatedBy = auth()->user()->id;

        if (!$user->save()) {
           return parent::getResponse(
                __('accountMessages.cannotUpdate'), 304);
        }

        return response()->json($user, 200);
    }


    public function show($userID)
    {
        $user = User::find($userID);

        if (!$user) {
            return parent::getResponse(
                __('userMessages.notFound'),
                404
            );
        }

        return parent::getResponse(
            __('userMessages.show'),
            200,
            $user
        );
    }

    public function delete($userID) //delete specific record
    {
        $user = User::find($userID);

        if (!$user) {
             return parent::getResponse(
            __('userMessages.notFound'), 404);
        }

        if (!$user->delete()) {
            return parent::getResponse(
                __('userMessages.deleted'), 304, $userID);
        }

         return parent::getResponse(
            __('userMessages.deleted'), 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'

        ]);
        $credentials = $request('email','password');

        if(!User::attempt($credentials)){
            return parent::getResponse(
                __('userMessages.wrongInfo'), 401);
        }
        $token = $user->createToken('token-name');

        return parent::getResponse(['token' => $token->plainTextToken ,__('userMessages.logedIn')], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return parent::getResponse(
            __('userMessages.logedout');
    }

    /*public function singup(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|uniqe:users',
            'password' => 'required'
        ]);

        $user =  new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        if (!$user->save()) {
            return parent::getResponse(
                __('userMessages.notInserted'), 304, $userID);
        }

        return response()->json($user, 201);
    }*/
}