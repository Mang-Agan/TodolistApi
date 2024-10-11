<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodolistRequest;
use App\Http\Requests\UpdateTodoRequest;
use App\Http\Resources\CheckTodoResource;
use App\Http\Resources\TodolistResource;
use Illuminate\Http\Exceptions\HttpResponseException;
use Exception;
use App\Models\Todolist;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\GetAllTodolistResource;

class TodolistController extends Controller
{

    public function getAll(): GetAllTodolistResource
    {
        try {
            $user = Auth::user();
            $todolists = $user->getAllTodolist();
            return new GetAllTodolistResource($todolists);
        } catch (Exception $e) {
            $this->errorHandler($e, "Get All Todo Error");
        }
    }

    public function create(TodolistRequest $request): TodolistResource
    {
        try {
            $data = $request->validated();
            $todolist = new Todolist();
            $todolist->todo = $data['todo'];
            $todolist->user_id = Auth::user()->id;
            $todolist->is_check = 0;
            $todolist->saveOrFail();

            return new TodolistResource($todolist);
        } catch (Exception $e) {
            $this->errorHandler($e, "Create Todo Error");
        }
    }

    public function destroy($id): GetAllTodolistResource
    {
        try {
            $todo = Todolist::where('id', $id)->first();

            if ($todo == null) {
                throw new Exception('Todolist Nof Found', 500);
            }

            $todo->delete();
            $todo->saveOrFail();

            return $this->getAll();
        } catch (Exception $e) {
            $this->errorHandler($e, "Delete Todo Error");
        }
    }

    public function checkTodo($id)
    {
        try {

            $todo = Todolist::where('id', $id)->first();

            if ($todo == null) {
                throw new Exception('Todolist Nof Found', 500);
            }

            $todo->is_check = true;
            $todo->saveOrFail();

            return new CheckTodoResource($todo);
        } catch (Exception $e) {
            $this->errorHandler($e, "Delete Todo Error");
        }
    }

    public function updateTodo(UpdateTodoRequest $request): TodolistResource
    {
        try {
            $todo = Todolist::where('id', $request->id)->first();
            $todo->todo = $request->todo;
            $todo->saveOrFail();

            return new TodolistResource($todo);
        } catch (Exception $e) {
            $this->errorHandler($e, "Delete Todo Error");
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
