<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chapter;
use App\Models\StudentProgress;
use App\Models\SubCategory;
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
            } else {
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
            $result = [];

            foreach ($category as $key=> $course) {
                $subjectData = [];

                $cat_subject = SubCategory::where('category_id', $course->category_id)->get();

                $studentCourseProgress = StudentProgress::where(['course_id' => $course->category_id, 'user_id' => $request->userId])->get();

                $videoCount = 0;
                $videoByCoursCount = Video::where('video_course', $course->category_id)->get()->count();

                foreach ($studentCourseProgress as $video) {
                    $videoExist = Video::where("id", '=', $video->video_id)->first();

                    if ($videoExist) {
                        $videoCount = $videoCount + 1;
                    }
                }

                foreach ($cat_subject as $key1 => $subjects) {
                    $subjectResult = [];
                    $studentProgress = StudentProgress::Join('videos', 'videos.id', '=', 'student_progress.video_id')
                        ->Join('sub_categories', 'sub_categories.id', '=', 'videos.video_subject')
                        ->select('student_progress.id')
                        ->where('sub_categories.id', '=', $subjects->id)
                        ->where('student_progress.user_id', '=', $request->userId)
                        ->get()->count();

                    $videoByCourse = Video::where('video_subject', $subjects->id)->get()->count();


                    $subjectResult=array();
                    if ($videoByCourse > 0) {
                        $subjectResult['subjectName'] = $subjects->subcategory_name;
                        $subjectResult['subjectProgress'] = number_format(($studentProgress / $videoByCourse) * 100, 2);
                        $subjectData[] = $subjectResult;
                    }
                }

                $data['courseName'] = $course->category_name;
                if ($videoByCoursCount > 0) {
                    $data['courseProgress'] = number_format(($videoCount / $videoByCoursCount) * 100, 2);
                } else {
                    $data['courseProgress'] = "0.0";
                }
                $data['subjectData'] = $subjectData;
                $result[] = $data;

            }
            return response()->json(["status" => 200, "message" => "success", "data" =>  $result], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }
}
