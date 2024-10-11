<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);


        try {
            return [
                'status' => true,
                'message' => 'success',
                'errors' => null,
                'params' => [
                    'id' => $this->resource['id'],
                    'name' => $this->resource['name'],
                    'email' => $this->resource['email'],
                    'token' => $this->resource['token']
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Error processing user data',
                'errors' => $e->getMessage(),
                'params' => null
            ];
        }
    }
}
