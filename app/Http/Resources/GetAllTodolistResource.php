<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetAllTodolistResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        try {
            return [
                'status' => true,
                'message' => 'success',
                'errors' => null,
                'params' => $this->resource
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Server Error',
                'errors' => $e->getMessage(),
                'params' => null
            ];
        }
    }
}
