<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthAPI extends Controller
{
    /** Default Response User
     * @param $user
     * @return JsonResponse
     */
    public function response($user): JsonResponse
    {
        $token = $user->createToken(str()->random(40))->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    /** Register Method
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:2|confirmed'
        ]);

        $user = User::create([
            'name' => ucwords($request->name),
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return $this->response($user);
    }

    /** Login Method
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $cred = $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:2'
        ]);

        if (! Auth::attempt($cred)) {
            return response()->json([
                'message' => 'Unauthorized.'
            ], 401);
        }

        return $this->response(Auth::user());
    }

    /** Logout Method
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logout.'
        ]);
    }
}
