<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserPasswordChangeRequest;
use App\Http\Requests\UserRegisterRequest;

class AuthController extends Controller
{
    static function authAttempt($valid_inputs, $returnUser = true)
    {
        if (Auth::attempt($valid_inputs))
            return [
                true,
                $returnUser
                    ? User::where('username', $valid_inputs['username'])->first()
                    : null
            ];
        else {
            return [false, response()->json([
                'message' => __('messages.login.fail')
            ], 401)];
        }
    }

    public function signup(UserRegisterRequest $request)
    {
        $this->logInfo();

        $valid_inputs = $request->validated();

        $userName = strtolower($valid_inputs['username']);
        $user = User::create([
            'username' => $userName,
            'email' => $userName,
            'password' => Hash::make($valid_inputs['password']),
        ]);

        [$success, $err] = self::authAttempt($valid_inputs, false);
        return $success ? response()->json(['user' => $user]) : $err;
    }

    public function signin(UserLoginRequest $request)
    {
        $this->logInfo();

        $valid_inputs = $request->validated();

        [$success, $err] = self::authAttempt($valid_inputs, false);
        if (!$success) return $err;
    }

    public function signout()
    {
        $this->logInfo();

        auth()->guard('web')->logout();
        return response()->json(['success' => true]);
    }

    public function token(UserLoginRequest $request)
    {
        $this->logInfo();

        $valid_inputs = $request->validated();

        [$success, $user] = self::authAttempt($valid_inputs);
        if (!$success) return $user;

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function user(Request $request)
    {
        $this->logInfo();

        return $request->user();
    }

    // public function sessions(Request $request)
    // {
    //     $this->logInfo();

    //     $sess = Session::where('user_id', $request->user()->id)->get();
    //     return $sess;
    // }

    // public function showSession(Request $request, Session $session)
    // {
    //     $this->logInfo(['session_id' => $session->id]);

    //     if ($request->user()->id !== $session->user_id) return $this->sendError(__('messages.unauthorized'));

    //     return $session;
    // }

    // public function revokeSession(Request $request, Session $session)
    // {
    //     $this->logInfo(['session_id' => $session->id]);

    //     if ($request->user()->id !== $session->user_id) return $this->sendError(__('messages.unauthorized'));

    //     if ($session->delete())
    //         return $this->sendResponse([], __(
    //             'messages.delete.success',
    //             ['model' => __('messages.model.session')]
    //         ));

    //     else return $this->sendError(__(
    //         'messages.delete.fail',
    //         ['model' => __('messages.model.session')]
    //     ));
    // }

    public function changePassword(UserPasswordChangeRequest $request)
    {
        ['password' => $passwd] = $request->validated();

        if ($request->user()->update(['password' => Hash::make($passwd)]))
            return $this->sendResponse([], __(
                'messages.update.success',
                ['model' => __('validation.attributes.password')]
            ));
        else return $this->sendError(__(
            'messages.update.fail',
            ['model' => __('validation.attributes.password')]
        ));
    }
}
