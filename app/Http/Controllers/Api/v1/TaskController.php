<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Task;
use Iluminate\Http\Response;
use App\Http\Controllers\Controller;
use Iluminate\Http\RedirectResponse;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return TaskResource::collection(Task::all());
        // $tasks = Task::all()
        // ->orderByDesc('created_at')
        // ->paginate(5);
        // return view('Task.index', compact('tasks'));
        $tasks = Task::orderByDesc('created_at')
                 ->paginate(5);

        return view('Task.index', compact('tasks'));
    }

   
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $task=Task::create([
            'title' => $request->title,
            'description' =>$request->description,
            'completed'=> $request->has('completed') ? true : false
            
        ]);
        return TaskResource::make($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return TaskResource::make($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        
        $task->update($request->validated());
        return TaskResource::make($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->noContent();
    }
}