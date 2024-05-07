<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search =$request->get('search');

        $query=Task::query();

        if($search){
            $query->where('title','like',"%$search%");
        }

        $tasks=$query->get();

        return response()->json($tasks);
    }

    public function store(TaskStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $task = Task::create($validated);

        return response()->json($task, Response::HTTP_CREATED);
    }
}
