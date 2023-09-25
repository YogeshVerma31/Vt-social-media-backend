<?php

namespace App\Http\Controllers;

use App\Models\TodayLearning;
use App\Models\Video;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class TodayLearningController extends Controller
{
    public function index(Request $request)
    {

        try {

            return view("admin/learning_video/createLearningVideo");
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return  redirect()->intended('/view-course');
        }
    }
    

    public function viewTodayLearning(Request $request)
    {

        try {
            $trendingVideos = Video::where('is_today_learning_video','=',1)->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->get();
            return view("admin/learning_video/viewLearningVideo", ['trendingVideos' => $trendingVideos]);
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return  redirect()->intended('/view-course');
        }
    }


    public function createTodaysLearningVideos(Request $request)
    {
        $credentials = $request->validate([
            'video_name' => ['required'],
            'video_desc' => ['required'],
            'video_url' => ['required'],
            'video_length' => ['required'],
            'video_thumbnail' => ['required'],
        ]);


        $video = $request->file('video_url');
        $image = $request->file('video_thumbnail');


        $extension = $video->getClientOriginalExtension();
        $imageExtension = $image->getClientOriginalExtension();

        // Store the video in the storage (e.g., public disk).
        try {

            if ($extension != "mp4") {
                Session::flash('error', "Support only mp4");
                return redirect()->intended('/videos');
            }

            $path = $video->store('videos', 'public');
            $imagePath = $image->store('images', 'public');

            // Save the image data to the database.
            $videoModel = new Video();
            $videoModel->video_name = $request->video_name;
            $videoModel->video_desc = $request->video_desc;
            $videoModel->video_url = $path;
            $videoModel->video_length = $request->video_length;
            $videoModel->video_thumbnail = $imagePath;
            $videoModel->video_course = 0;
            $videoModel->video_subject = 0;
            $videoModel->video_chapter = 0;
            $videoModel->is_today_learning_video = 1;
            $videoModel->video_uploaded_by = Session::get('user')->id;
            $videoModel->save();

            Session::flash('success', 'Video created successfully');
            return  redirect()->intended('/today_learning');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->intended('/today_learning');
        }
    }
}
