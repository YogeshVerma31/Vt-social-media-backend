<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chapter;
use App\Models\StudentProgress;
use App\Models\Video;
use Exception;
use Illuminate\Http\Request;

class StudentProgressApiController extends Controller
{
    public function postAddProgress(Request $request)
    {
        try {


            $videoExist = Video::where("id", '=', request()->query('videoId'))->first();
            $courseExist = Category::where("category_id", '=', request()->query('courseId'))->first();

            if (!$courseExist) {
                return response()->json(["status" => 403, "message" => "Success", "data" =>  "Course may be deleted or not found!"], 403);
            }

            $progressExist = StudentProgress::where(['user_id' => $request->userId, 'video_id' => request()->query('videoId'), 'course_id' => request()->query('courseId')])->first();

            if (!$progressExist) {
                if ($videoExist) {
                    $studentProgress = new StudentProgress();
                    $studentProgress->user_id = $request->userId;
                    $studentProgress->video_id = request()->query('videoId');
                    $studentProgress->course_id = request()->query('courseId');
                    $studentProgress->save();
                    return response()->json(["status" => 200, "message" => "Success", "data" =>  'added'], 200);
                } else {
                    return response()->json(["status" => 403, "message" => "Success", "data" =>  "Video may be deleted or not found!"], 403);
                }
            }else{
                return response()->json(["status" => 200, "message" => "already exist   ", "data" =>  'added'], 200);
            }
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function getProgress(Request $request)
    {
        try {
            $category = Category::all();


            foreach ($category as $course) {
                $studentProgress = StudentProgress::where('course_id',$course->category_id)->get()->count();
                $videoByCourse = Video::where('video_course',$course->category_id)->get()->count();

                $data['courseName'] = $course->category_name;
                $data['courseProgress'] = $studentProgress/$videoByCourse *100;
                $result[] = $data;
            }







                return response()->json(["status" => 200, "message" => "success", "data" =>  $result], 200);

        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }


}
