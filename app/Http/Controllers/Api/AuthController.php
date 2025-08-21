<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController as BaseApiController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends BaseApiController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            // Assign default role
            $user->assignRole('user');

            $token = $user->createToken('auth_token')->plainTextToken;

            $loginData = $this->login($request);
            $loginDataArray = json_decode($loginData->getContent(), true);
            return $this->sendResponse($loginDataArray['data'], 'User register successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Registration failed.', ['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        try {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['The provided credentials are incorrect.'],
                ]);
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $data = (object)[];
                $user = Auth::user();
                if ($request->hasSession()) {
                    $request->session()->regenerate();
                } else {
                    $data->token =  $user->createToken($user->name)->plainTextToken;
                }
                return $this->sendResponse($data, 'User login successfully.');
            }
        } catch (\Exception $e) {
            return $this->sendError('Registration failed.', ['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // $token = $user->createToken('auth_token')->plainTextToken;

        // return response()->json([
        //     'user' => $user->load('roles', 'permissions'),
        //     'token' => $token,
        //     'token_type' => 'Bearer',
        // ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
