<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\User;
use App\Models\User as UUser;
use App\Helper\AuthHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request()->validate([
           'email' => 'required|email',
           'password' => 'required|string',
        ]);

        $user = UUser::where('email', $request->email)->first();
        if (!is_null($user)) {
            if ($user->status != "user") {
                if (Hash::check($request->password, $user->password)) {
                    AuthHelper::login($user);

                    if($user->status == "manager"){
                        if (! $token = auth()->attempt($credentials)) {
                            return response()->json([
                                'errors' => [
                                    'email' => [__('auth.failed')]
                                ]
                            ], 401);
                        }

                        return $this->respondWithToken($token);
                    }

                    return response()->json([
                        'role' => $user->status,
                    ]);
                }
            }
        }

        $credentials['status'] = 'user';

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'errors' => [
                    'email' => [__('auth.failed')]
                ]
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json(
            [
                'role' => Auth::user()->status,
                'status'        => 'success',
                'Authorization' => $token,
                'token_type'    => 'bearer',
                'expires_in'    => auth()->factory()->getTTL() * 60,
                'user'          => Auth::user(),
            ]
        );
    }

    public function register(Request $request)
    {

        $user           = new User;
        $user->email    = $request->email;
        $user->name     = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();

        return response(
            [
                'status' => 'success',
                'data'   => $user,
            ],
            200
        );
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return new UserResource(auth()->user());
    }


}
