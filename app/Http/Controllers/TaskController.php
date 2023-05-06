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

    public function getResultFromTask(Request $request, $id)
    {
        $task = Task::find($id);

        $solution = $task->solution;
        $student_solution = $request->input('solution');

        // $solution = "\dfrac{2.000000001s^2+13s+10}{s^3+7s^2+18s+15} ";
        // $student_solution = "\dfrac{2s^2+13s+10}{s^3+7s^2+18s+15}";


        $output = exec('python ' . base_path('app/Helpers/compare.py') . " \"{$solution}\" \"{$student_solution}\"");     

        if($output){
            return response()->json([
                'message' => 'Correct'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Incorrect'
            ], 200);
            
        }

        
    }



}
