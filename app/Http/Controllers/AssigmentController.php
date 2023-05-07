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
        $exams = ExamBundles::where('assignment_id', $id)->get()->toArray();

        return response()->json([
            'assigment' => $assigment,
            'exams' => $exams,
        ], 200);
    }

}
