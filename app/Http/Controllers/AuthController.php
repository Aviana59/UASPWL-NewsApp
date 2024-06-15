<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $input = $request->all();

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        try {
            if (auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) {
                return response()->json(['status' => true, 'message' => 'success']);
            } else {
                return response()->json(['status' => false, 'message' => 'Username or password is wrong'], 401);
            }
        } catch (Exception $error) {
            return response()->json(['status' => false, 'message' => 'Something went wrong'], 500);
        }
    }
    public function logout(Request $request): JsonResponse
    {
        try {
            auth()->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
            return response()->json(['status' => true, 'message' => 'log out']);
        } catch (Exception $error) {

            return response()->json(['status' => false, 'message' => 'Something went wrong'], 500);
        }
    }
}
