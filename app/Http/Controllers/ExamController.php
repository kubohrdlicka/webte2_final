<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;


use App\Models\ExamBundle;
use App\Models\Exam;
use App\Models\User;
use App\Models\Task;

class ExamController extends Controller
{

    public function generateTaskFromExambundle($id)
    {
        $examBundle = ExamBundle::find($id);
        if (!$examBundle) {
            return response(400)->json("Exam bundle not found");
        }
        $exam = Exam::where('exam_bundle_id', $id)->where('user_id', JWTAuth::parseToken()->authenticate()->id)->get();
        if (count($exam) > 0) {
            return response(400)->json("You already have an exam for this assignment");
        }
        if($examBundle->end > date("Y-m-d H:i:s")){
            return response(400)->json("The exam time is over");
        }
        $taskBundle = $examBundle->task_bundle_id;
        $tasks = Task::where('task_bundle_id', $taskBundle)->get()->toArray();
        $task = array_rand($tasks, 1);
        $task = $tasks[$task];
        return response()->json($task["id"]);
    }

    public function getAllPointsFromAssigmentStudent($id)
    {
        $examBundles = ExamBundle::where('assignment_id', $id)->get();
        $points = [];
        $sumpoints = 0;
        foreach ($examBundles as $examBundle) {
            $exam = Exam::where('exam_bundle_id', $examBundle->id)->where('user_id', JWTAuth::parseToken()->authenticate()->id)->get();
            $points[] = ['examBundleId' => $examBundle->id, "points"->$exam->points];
            $sumpoints += $exam->points;
        }
        return response()->json(
            [
                'points' => $points,
                'sumpoints' => $sumpoints
            ]
        );
    }

    public function getPointsFromExambundle($id)
    {
        $studnets = User::where('role', 'student')->get();
        $examBundles = ExamBundle::where('assignment_id', $id)->get();


        $points = [];
        foreach ($studnets as $student) {
            $sumpoints = 0;
            $studentPoints = [];
            $totalpoints = 0;
            foreach ($examBundles as $examBundle) {
                $exam = Exam::where('exam_bundle_id', $examBundle["id"])->where('user_id', $student["id"])->get();
                if(count($exam) > 0){
                    $task = Task::where('id', $exam[0]['task_id'])->get();
                    
                    $studentPoints[] = ['examBundleId' => $examBundle, 'task'=> $task , "student_exam"=>$exam];
                    $sumpoints += $exam[0]["earned_points"];
                }
                $totalpoints += $examBundle->points;
            }
            $points[] = ['student' => $student, 'points' => $studentPoints, 'sumpoints' => $sumpoints, 'totalpoints' => $totalpoints];
        }
        return response()->json($points);
    }


    

}