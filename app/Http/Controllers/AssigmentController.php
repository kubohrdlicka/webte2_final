<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JWTAuth;

use App\Models\Assignment;
use App\Models\ExamBundle;
use App\Models\Exam;
use App\Models\User;

class AssigmentController extends Controller
{

    public function getAllAssigments(){
        $assignments = Assignment::all()->toArray();
        return response()->json($assignments);

    }
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
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->role == 'student') {
            $assigments = Assignment::where('start', '<=', now())
                ->where('end', '>=', now())
                ->get()
                ->toArray();

            $result = [];

            foreach ($assigments as $assigments) {
                $exams = ExamBundle::where('assignment_id', $assigments['id'])->get()->toArray();
                $total_exams = sizeof($exams);
                $taken_exams = 0;
                foreach ($exams as $exam) {
                    $tmp = Exam::where('user_id', $user->id)->where('exam_bundle_id', $exam["id"])->first();
                    if (!empty($tmp)) {
                        $taken_exams++;
                    }
                }
                if ($taken_exams < $total_exams) {
                    $result[] = $assigments;
                }
            }

            return response()->json($result);
        }

        $assigments = Assignment::where('start', '<=', now())
            ->where('end', '>=', now())
            ->get()
            ->toArray();
        return response()->json($assigments);
    }

    public function getDoneAssigments()
    {
        $user = JWTAuth::parseToken()->authenticate();
        if ($user->role == 'student') {
            $assigments = Assignment::all()
                ->toArray();

            $result = [];

            foreach ($assigments as $assigment) {
                $exams = ExamBundle::where('assignment_id', $assigment['id'])->get()->toArray();
                $total_exams = sizeof($exams);
                $taken_exams = 0;
                $points = 0;
                $total_points = 0;
                foreach ($exams as $exam) {
                    $tmp = Exam::where('user_id', $user->id)->where('exam_bundle_id', $exam["id"])->first();
                    if (!empty($tmp)) {
                        $points += $tmp->earned_points;
                        $total_points += $exam['points'];
                        $taken_exams++;
                    }
                }
                if ($taken_exams == $total_exams) {
                    $assigment['points'] = $points;
                    $assigment['total_points'] = $total_points;
                    $result[] = $assigment;
                }
            }

            return response()->json($result);
        }

        return response()->json('this endponint is only for students');
    }


    public function getPastDueAssigments()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $assigments = Assignment::where('end', '<', now())
            ->get()
            ->toArray();

        if ($user->role == 'student') {
            $pastDue = [];
            foreach ($assigments as $asig) {
                $exams = ExamBundle::where('assignment_id', $asig['id'])->get()->toArray();
                $total_exams = sizeof($exams);
                $taken_exams = 0;
                $points = 0;
                $total_points = 0;
                foreach ($exams as $exam) {
                    $tmp = Exam::where('user_id', $user->id)->where('exam_bundle_id', $exam["id"])->first();
                    if (!empty($tmp)) {
                        $points += $tmp->earned_points;
                        $total_points += $exam['points'];
                        $taken_exams++;
                    }
                }
                if ($taken_exams < $total_exams) {
                    $pastDue[] = $asig;
                }
            }
            return response()->json($pastDue);
        }

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

    public function generateCsv()
    {
        $students = User::where('role', 'student')->get()->toArray();
        $exams = Exam::all()->toArray();
        $assigments = Assignment::all()->toArray();

        $total_points = 0;

        foreach ($assigments as $assigment) {
            $examBundles = ExamBundle::where('assignment_id', $assigment['id'])->get()->toArray();
            foreach ($examBundles as $examb) {
                $total_points += $examb['points'];
            }
        }

        $csv = [];
        $headers = ['id', 'name', 'surname', 'email', 'earned_points', 'total_points'];
        $csv[] = $headers;


        foreach ($students as $student) {
            $earned_points = 0;

            foreach ($exams as $exam) {
                if ($exam['user_id'] == $student['id']) {
                    $earned_points += $exam['earned_points'];
                }
            }

            $csv[] = [
                'id' => $student['id'],
                'name' => $student['name'],
                'surname' => $student['surname'],
                'email' => $student['email'],
                'earned_points' => $earned_points,
                'total_points' => $total_points,
            ];
        }
        if(sizeof($csv) > 2){
            usort($csv, function ($a, $b) {
                if ($a['earned_points'] == $b['earned_points']) {
                    return strnatcmp($a['surname'], $b['surname']);
                }
                return ($a['earned_points'] > $b['earned_points']) ? -1 : 1;
            });
        }

        $fileName = 'results.csv';

        $file = fopen('php://temp', 'w+');

        foreach ($csv as $row) {
            fputcsv($file, $row);
        }

        rewind($file);
        $content = stream_get_contents($file);

        fclose($file);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '";',
        ];

        return response($content, 200, $headers);






    }

}