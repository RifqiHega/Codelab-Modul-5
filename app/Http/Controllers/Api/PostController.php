<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        // Get all tasks
        $tasks = Post::latest()->paginate(5);

        // Return collection of tasks as a resource
        return new PostResource(true, 'List of Tasks', $tasks);
    }

    /**
     * store
     *
     * @param mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'task'      => 'required|string',
            'category'  => 'required|string',
            'date'      => 'required|date',
            'time'      => 'required|date_format:H:i',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create task
        $task = Post::create([
            'task'      => $request->task,
            'category'  => $request->category,
            'date'      => $request->date,
            'time'      => $request->time,
        ]);

        // Return response
        return new PostResource(true, 'Task Successfully Created', $task);
    }

    /**
     * show
     *
     * @param mixed $id
     * @return void
     */
    public function show($id)
    {
        // Find task by ID
        $task = Post::find($id);

        // Check if task exists
        if (!$task) {
            return response()->json(['message' => 'Task Not Found'], 404);
        }

        // Return single task as a resource
        return new PostResource(true, 'Task Details', $task);
    }

    /**
     * update
     *
     * @param mixed $request
     * @param mixed $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        // Define validation rules
        $validator = Validator::make($request->all(), [
            'task'      => 'sometimes|required|string',
            'category'  => 'sometimes|required|string',
            'date'      => 'sometimes|required|date',
            'time'      => 'sometimes|required|date_format:H:i',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Find task by ID
        $task = Post::find($id);

        // Check if task exists
        if (!$task) {
            return response()->json(['message' => 'Task Not Found'], 404);
        }

        // Update task
        $task->update($request->all());

        // Return response
        return new PostResource(true, 'Task Successfully Updated', $task);
    }

    /**
     * destroy
     *
     * @param mixed $id
     * @return void
     */
    public function destroy($id)
    {
        // Find task by ID
        $task = Post::find($id);

        // Check if task exists
        if (!$task) {
            return response()->json(['message' => 'Task Not Found'], 404);
        }

        // Delete task
        $task->delete();

        // Return response
        return new PostResource(true, 'Task Successfully Deleted', null);
    }
}

