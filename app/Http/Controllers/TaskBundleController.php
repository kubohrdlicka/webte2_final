<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\TaskBundle;
use App\Models\Task;

use ZipArchive;

class TaskBundleController extends Controller
{

    public function getAllTaskBundles()
    {
        $taskbundles = TaskBundle::all(['id', 'name', 'created_at'])->toArray();
        return response()->json($taskbundles);
    }


    public function uploadTask(Request $request)
    {
        $file = $request->file('file');


        $tempPath = $file->store('temp', 'local');

        $zip = new ZipArchive;

        $zip->open(storage_path('app/' . $tempPath));

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);

            if (pathinfo($filename, PATHINFO_EXTENSION) == 'tex') {
                $taskbunle = TaskBundle::create([
                    'name' => $filename,
                    'category' => '',
                    'description' => "",
                ]);

                $id = $taskbunle->id;
                $this->parseTask("zip://" . storage_path('app/' . $tempPath) . "#" . $filename, $id);
            } else {
                if (
                    pathinfo($filename, PATHINFO_EXTENSION) == 'jpg' || pathinfo($filename, PATHINFO_EXTENSION) == 'png' ||
                    pathinfo($filename, PATHINFO_EXTENSION) == 'jpeg'
                ) {
                    $publicPath = public_path();
                    $fileDestination = $publicPath . '/images/' . basename($filename);
                    copy("zip://" . storage_path('app/' . $tempPath) . "#" . $filename, $fileDestination);
                }
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
        $solution = false;
        $assigments = [];
        $solutions = [];


        foreach ($latex as $line) {
            if (strpos($line, '\section*{') !== false) {
                $names[] = $name;
                $name = substr($line, strpos($line, '{') + 1, -2);
            }

            if (
                $breaker && !(strpos($line, '\end{solution}') !== false || strpos($line, '\end{task} ') !== false ||
                    strpos($line, '\begin{t') !== false || strpos($line, '\end{t') !== false ||
                    strpos($line, '\begin{s') !== false || strpos($line, '\end{s') !== false)
            ) {
                if(!$solution){   
                    if (strpos($line, '\begin{equation*}') !== false) {
                        $line = str_replace('\begin{equation*}', '$$', $line);
                    }
                    
                    if (strpos($line, '\end{equation*}') !== false) {
                        $line = str_replace('\end{equation*}', '$$', $line);
                    }
                }

                if((strpos($line, '\begin{') !== false || strpos($line, '\end{') !== false) && $solution){
                    
                }else{
                    if(strpos($line, "=") !== false && $solution){
                        $tmp = explode("=", $line);
                        $line = $tmp[1];
                    }
                    $content .= $line;
                }
                
            }

            if (strpos($line, '\begin{task}') !== false) {
                $breaker = true;
                //$content .= $line;
            }


            if (strpos($line, '\end{task} ') !== false) {
                // $con = str_replace("\\", "\\\\", $content );
                $assigments[] = $content;
                $breaker = false;
                $content = '';
            }

            if (strpos($line, '\begin{solution}') !== false) {
                //            $content .= $line;
                $solution = true;
                $breaker = true;
            }

            if (strpos($line, '\end{solution}') !== false) {
                $breaker = false;
                $solution = false;
                // $con = str_replace("\"", "\\", $content );
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