<?php

namespace App\Http\Controllers;

use App\Models\TodayLearning;
use App\Models\Video;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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
            $trendingVideos = Video::where('is_today_learning_video', '=', 1)->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->get();
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

            $videoFileName = time() . '.' . $video->getClientOriginalExtension();

            $path = $request->file('video_url')->storeAs(
                'videos',
                $videoFileName,
                's3'
            );
            $imageFileName = time() . '.' . $image->getClientOriginalExtension();

            $imagePath = $request->file('video_thumbnail')->storeAs(
                'images',
                $imageFileName,
                's3'
            );


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

    public function editVideos(Request $request, $id)
    {
        $videoModel = Video::find($id);
        return view("admin/learning_video/editLearningVideo", ['videos' => $videoModel]);
    }

    public function updateVideo(Request $request, $id)
    {


        try {

            $videoModel = Video::where('id', '=', $id)->first();

            if (!$videoModel) {
                Session::flash('error', 'Video not found');
                return redirect()->intended("/videos");
            }

            if ($request->video_url && $request->video_thumbnail) {
                $video = $request->file('video_url');
                $image = $request->file('video_thumbnail');
                $videoFileName = time() . '.' . $video->getClientOriginalExtension();

                $videoPath = $request->file('video_url')->storeAs(
                    'videos',
                    $videoFileName,
                    's3'
                );
                $imageFileName = time() . '.' . $image->getClientOriginalExtension();

                $imagePath = $request->file('video_thumbnail')->storeAs(
                    'images',
                    $imageFileName,
                    's3'
                );

                Video::where('id', '=', $id)
                    ->update([
                        'video_name' => $request->video_name,
                        'video_desc' => $request->video_desc,
                        'video_url' => $videoPath,
                        'video_thumbnail' => $imagePath,
                    ]);
            } else if ($request->video_url && !$request->video_thumbnail) {
                $video = $request->file('video_url');
                $videoFileName = time() . '.' . $video->getClientOriginalExtension();

                $videoPath = $request->file('video_url')->storeAs(
                    'videos',
                    $videoFileName,
                    's3'
                );


                Video::where('id', '=', $id)
                    ->update([
                        'video_name' => $request->video_name,
                        'video_desc' => $request->video_desc,
                        'video_url' => $videoPath
                    ]);
            } else if (!$request->video_url && $request->video_thumbnail) {
                $image = $request->file('video_thumbnail');
                $imageFileName = time() . '.' . $image->getClientOriginalExtension();

                $imagePath = $request->file('video_thumbnail')->storeAs(
                    'images',
                    $imageFileName,
                    's3'
                );


                Video::where('id', '=', $id)
                    ->update([
                        'video_name' => $request->video_name,
                        'video_desc' => $request->video_desc,
                        'video_thumbnail' => $imagePath,
                    ]);
            } else {

                Video::where('id', '=', $id)
                    ->update([
                        'video_name' => $request->video_name,
                        'video_desc' => $request->video_desc,
                    ]);
            }



            Session::flash('success', 'Video updated successfully');
            return redirect()->intended("view-today-learning");
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->intended("view-today-learning");
        }
    }

    public function deleteVideos(Request $request, $id)
    {
        try {
            $videoModel = Video::find($id);
            Storage::disk('s3')->delete($videoModel->video_url);
            Storage::disk('s3')->delete($videoModel->video_thumbnail);
            $videoModel->delete();
            Session::flash('success', 'Video deleted successfully');
            return redirect()->intended("view-today-learning");
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->intended("view-today-learning");
        }
    }
}
