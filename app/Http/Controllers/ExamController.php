<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;


use App\Models\ExamBundle;
use App\Models\Exam;
use App\Models\User;

class ExamController extends Controller
{

    public function generateTaskFromExambundle($id)
    {
        $examBundle = ExamBundle::find($id);
        $taskBundle = $examBundle->taskBundle;
        $tasks = $taskBundle->tasks;
        $task = $tasks->random();
        $task->solution = null;
        return response()->json($task->id);
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
            foreach ($examBundles as $examBundle) {
                $exam = Exam::where('exam_bundle_id', $examBundle->id)->where('user_id', $student->id)->get();
                $studentPoints[] = ['examBundleId' => $examBundle->id, "points"->$exam->points];
                $sumpoints += $exam->points;
            }
            $points[] = ['studentId' => $student->id, 'points' => $studentPoints, 'sumpoints' => $sumpoints];
        }
        return response()->json($points);
    }


    

}