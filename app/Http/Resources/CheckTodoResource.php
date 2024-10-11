<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CheckTodoResource extends JsonResource
{
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
                'params' => [
                    'id' => $this->id,
                    'todo' => $this->todo,
                    'is_check' => $this->is_check,
                    'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
                    'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s')
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
