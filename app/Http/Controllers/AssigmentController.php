<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JWTAuth;

use App\Models\Assignment;
use App\Models\ExamBundle;
use App\Models\Exam;

class AssigmentController extends Controller
{
    public function createAssigment(Request $request)
    {
        $assigment = Assignment::create([
            'title' => $request->name,
            'description' => $request->description,
            'start' => $request->start,
            'end' => $request->end,
            'created_by' => JWTAuth::parseToken()->authenticate()->id,
        ]);

        $exams = $request->exams;

        foreach ($exams as $exam) {
            $exam = ExamBundle::create([
                'assignment_id' => $assigment->id,
                'task_bundle_id' => $exam['id'],
                'points' => $exam['points'],
            ]);

        }

        return response()->json($exams);
    }


    public function getAllActiveAssigments()
    {
        $assigments = Assignment::where('start', '<=', now())
            ->where('end', '>=', now())
            ->get()
            ->toArray();
        return response()->json($assigments);
    }

    public function getPastDueAssigments()
    {
        $assigments = Assignment::where('end', '<', now())
            ->get()
            ->toArray();
        return response()->json($assigments);
    }



    public function getAssigmentsInfo($id)
    {
        $assigment = Assignment::find($id);
        $exams = ExamBundle::where('assignment_id', $id)->get()->toArray();

        $student = JWTAuth::parseToken()->authenticate();
        $result = [];
        foreach ($exams as $key => $exam) {
            if ($student->role == 'student') {
                $tmp = Exam::where('user_id', $student->id)->where('exam_bundle_id', $exam["id"])->first();
                if (!empty($tmp)) {
                    $exams[$key]["earned_points"] = $tmp->earned_points;
                } 
            }
        }

        return response()->json([
            'assigment' => $assigment,
            'exams' => $exams,
        ], 200);
    }

}