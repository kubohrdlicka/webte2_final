<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;

use App\Models\Task;
use App\Models\ExamBundle;

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
        $task = Task::find($request->task_id);
        $exambundle = ExamBundle::find($request->exambundle_id);
        
        $solution = $task->solution;
        $student_solution = $request->input('solution');




        // $solution = "\dfrac{2.000000001s^2+13s+10}{s^3+7s^2+18s+15} ";
        // $student_solution = "\dfrac{2s^2+13s+10}{s^3+7s^2+18s+15}";


        $output = exec('python ' . base_path('app/Helpers/compare.py') . " \"{$solution}\" \"{$student_solution}\"");

        $points = 0;
        if($output == 'True'){
            $points = $exambundle->points;
        }

        $exam = Exam::create([
            'student_solution' => $request->input('solution'),
            'earned_points' => $points,
            'task_id' => $request->task_id,
            'exam_bundle_id' => $request->exambundle_id,
            'student_id' => JWTAuth::parseToken()->authenticate()->id,
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
