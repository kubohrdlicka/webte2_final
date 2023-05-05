<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

class TaskController extends Controller
{
    public function getTaskById($id)
    {
        $task = Task::find($id);
        return response()->json([
            'task' => $task
        ], 200);
    }
}
