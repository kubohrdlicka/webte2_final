<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TaskBundle;
use App\Models\Task;

class TaskBundleController extends Controller
{
    public function uploadTask(Request $request)
    {
        $file = $request->file('zipFile');


        $tempPath = $file->store('temp', 'local');

        $zip = new ZipArchive;

        $zip->open(storage_path('app/' . $tempPath));

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);

            if (pathinfo($filename, PATHINFO_EXTENSION) == 'tex') {
                $taskbunle = TaskBundle::create([
                    'name' => $file->getClientOriginalName(),
                    'description' => $request->description,
                ]);
                $id = $taskbunle->id;
                $this->parseTaskBundle("zip://" . storage_path('app/' . $tempPath) . "#" . $filename, $id);
            } else {
                $publicPath = public_path();
                $fileDestination = $publicPath . '/' . basename($filename);
                copy("zip://" . storage_path('app/' . $tempPath) . "#" . $filename, $fileDestination);
            }
        }

        $zip->close();
        Storage::delete($tempPath);

        // $file->move('../../../public/latex', $file->getClientOriginalName());

        return response()->json([
            'message' => 'File uploaded successfully'
        ], 201);
    }

    private function parseTask($file, $id)
    {

        // $latex = file('./blokovka01pr.tex');
        //    var_dump($latex);

        $latex = file($file);

        $content = '';
        $name = '';
        $breaker = false;
        $names = [];
        $assigments = [];
        $solutions = [];


        foreach ($latex as $line) {
            if (strpos($line, '\section*{') !== false) {
                $names[] = $name;
                $name = substr($line, strpos($line, '{') + 1, -2);
            }

            if ($breaker && !(strpos($line, '\end{solution}') !== false || strpos($line, '\end{task} ') !== false)) {
                $content .= $line;
            }

            if (strpos($line, '\begin{task}') !== false) {
                $breaker = true;
                //$content .= $line;
            }


            if (strpos($line, '\end{task} ') !== false) {
                $assigments[] = $content;
                $breaker = false;
                $content = '';
            }

            if (strpos($line, '\begin{solution}') !== false) {
                //            $content .= $line;
                $breaker = true;
            }

            if (strpos($line, '\end{solution}') !== false) {
                $breaker = false;
                $solutions[] = $content;
                $content = '';
            }


        }

        $done = [];

        for ($i = 0; $i < sizeof($solutions); $i++) {
            Task::create([
                'name' => $names[$i],
                'instructions' => $assigments[$i],
                'solution' => $solutions[$i],
                'task_bundle_id' => $id
            ]);
        }



    }
}