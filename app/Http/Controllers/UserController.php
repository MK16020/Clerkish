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
            __('voucherMessages.index'),
            $voucher
        );
    }

    public function show($userID) // return specific record
    {
        $user = User::find($userID);

        if (!$user) {
            return response()->json(['massage' => 'user not found'], 404);
        }
        $user = UserResources::collection($user);
        return response()->json($user, 200);
    }

    public function update(Request $request)
    {
        //
    }

    public function show($ID)
    {
        //
    }

    public function delete($ID)
    {
        //
    }
}
/*

    

   

    public function insert(Request $request) //add new record
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $user =  new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->userSateID = $request->userSateID;
        $user->userTypeID = $request->userTypeID;
        $user->createdBy = auth()->user()->id;

        if (!$user->save()) {
            return response()->json(['massage' => 'cant insert the user', $request], 304);
        }

        return response()->json($user, 201);
    }


    public function update(Request $request) //update specific record
    {
        $user = User::find($request->userID);

        if (!$user) {
            return response()->json(['massage' => 'user not found'], 404);
        }

        $user->userName = $request->userName;
        $user->email = $request->email;
        $user->userSateID = $request->userSateID;
        $user->userSateID = $request->userSateID;

        if (!$user->isDirty()) {
            return response()->json(['massage' => 'nothing to update', $user], 200);
        }

        $user->udpatedBy = auth()->user()->id;

        if (!$user->save()) {
            return response()->json(['massage' => 'cant update the user', $request], 304);
        }

        return response()->json($user, 200);
    }

    public function delete($userID) //delete specific record
    {
        $user = User::find($userID);

        if (!$user) {
            return response()->json(['massage' => 'user not found'], 404);
        }

        if (!$user->delete()) {
            return response()->json(['massage' => 'cant delete the user', $userID], 304);
        }

        return response()->json(['massage' => 'user deleted'], 200);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'

        ]);
        $credentials = $request('email','password');

        if(!User::attempt($credentials)){
            return response()->json(['massage' => 'your password or email not correct'], 401);
        }
        $token = $user->createToken('token-name');

        return response()->json(['token' => $token->plainTextToken ,'massage' => 'successful login'], 200);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['massage' => 'successful logout']);
    }

    public function singup(Request $request)
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
        $user->userSateID = 'notactive';
        $user->userTypeID = 'users';

        if (!$user->save()) {
            return response()->json(['massage' => 'cant insert the user', $request], 304);
        }

        return response()->json($user, 201);
    }

    public function resetPassword(Request $request)
    {

    }

    public function varifyEmail($token)
    {

    }
 */