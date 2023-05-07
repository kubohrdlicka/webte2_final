<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;

use App\Models\Task;
use App\Models\ExamBundle;
use App\Models\Exam;

class TaskController extends Controller
{
    public function getTaskById($id)
    {
        $task = Task::find($id);
        return response()->json([
            'task' => $task
        ], 200);
    }

    public function getResultFromTask(Request $request)
    {
        $task = Task::find($request->task_id);
        $exambundle = ExamBundle::find($request->exambundle_id);
        
        $solution = trim($task->solution);
        $student_solution = $request->studnet_solution;

        $output = exec('python ' . base_path('app/Helpers/compare.py') . " \"$solution\" \"$student_solution\"");

        $points = 0;
        if($output == 'True'){
            $points = $exambundle->points;
        }

        $exam = Exam::create([
            'studen_solution' => $student_solution,
            'earned_points' => $points,
            'task_id' => $request->task_id,
            'exam_bundle_id' => $request->exambundle_id,
            'user_id' => JWTAuth::parseToken()->authenticate()->id,
        ]);
        


        if($output == "True"){
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
