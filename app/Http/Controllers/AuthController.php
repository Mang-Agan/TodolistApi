<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use Illuminate\Support\Facades\Auth;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthController extends Controller
{
    public function login(LoginRequest $request): LoginResource
    {
        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials, true) == false) {
                throw new Exception('Invalid Credential');
            }

            $token = $request->user()->createToken('API Token', ['*'], Carbon::now()->addMonth(1))->plainTextToken;

            $response = [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
                'email' => $request['email'],
                'token' => $token
            ];
            return new LoginResource($response);
        } catch (Exception $e) {
            $this->errorHandler($e, "Login Error");
        }
    }

    private function errorHandler($e, $message)
    {
        throw new HttpResponseException(response([
            'status' => false,
            'message' => $message,
            'errors' => $e->getMessage(),
            'params' => null
        ], 500));
    }
}
