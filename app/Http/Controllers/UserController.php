<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\RegisterResource;
use Illuminate\Http\Exceptions\HttpResponseException;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(RegisterRequest $request): RegisterResource
    {
        try {
            $data = $request->validated();
            $user = new User($data);
            $user->email = $request->email;
            $user->password = Hash::make($data['password']);
            $user->saveOrFail();
            return new RegisterResource($user);
        } catch (Exception $e) {
            return $this->errorHandler($e);
        }
    }

    private function errorHandler($e)
    {
        $code = in_array($e->getCode(), [400, 401, 403, 404, 429]) ? $e->getCode() : 500;

        throw new HttpResponseException(response([
            'status' => false,
            'message' => $e->getMessage(),
            'errors' => null,
            'params' => null
        ], $code));
    }
}
