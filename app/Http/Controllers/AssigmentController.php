<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Tymon\JWTAuth\Facades\JWTAuth;

use App\Models\Assignment;
use App\Models\ExamBundle;

class AssigmentController extends Controller
{
    public function createAssigment(Request $request)
    {
        $assigment = Assignment::create([
            'title' => $request->name,
            'description' => $request->description,
            'start' => $request->start,
            'end' => $request->end,
            // 'created_by' => JWTAuth::user()->id,
            'created_by' => 1,
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

}
