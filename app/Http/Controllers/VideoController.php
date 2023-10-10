<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chapter;
use App\Models\SubCategory;
use App\Models\Video;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index(Request $request)
    {


        $subCategory = SubCategory::all();
        $videoModel = Video::Join('categories', 'videos.video_course', '=', 'categories.category_id')
            ->Join('users', 'users.id', '=', 'videos.video_uploaded_by')
            ->select('videos.*', 'categories.category_name', "users.name as users_name")
            ->where('is_today_learning_video','=',0)
            ->get();

        return view("admin/video/viewVideo", ['videos' => $videoModel, 'subject' => $subCategory]);
    }
    public function viewCreateVideo(Request $request)
    {
        $subCategory = Category::all();
        $videoModel = Video::Join('sub_categories', 'videos.video_course', '=', 'sub_categories.id')
            ->Join('users', 'users.id', '=', 'videos.video_uploaded_by')
            ->select('videos.*', 'sub_categories.subcategory_name', "users.name as users_name")
            ->where('is_today_learning_video','=',0)
            ->get();

        return view("admin/video/createVideo", ['videos' => $videoModel, 'subject' => $subCategory]);
    }
    public function editVideos(Request $request, $id)
    {
        $videoModel = Video::find($id);
        $category = Category::all();
        $subcategory = SubCategory::all();
        $chapter = Chapter::all();
        return view("admin/video/editVideo", ['videos' => $videoModel, 'category' => $category, 'subject' => $subcategory, 'chapter' => $chapter]);
    }



    public function createVideos(Request $request)
    {
        $credentials = $request->validate([
            'video_name' => ['required'],
            'video_desc' => ['required'],
            'video_url' => ['required'],
            'video_length' => ['required'],
            'video_thumbnail' => ['required'],
            'video_course' => ['required'],
            'video_subject' => ['required'],
            'video_chapter' => ['required'],
        ]);


        $video = $request->file('video_url');
        $image = $request->file('video_thumbnail');


        $extension = $video->getClientOriginalExtension();

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
            $videoModel->video_course = $request->video_course;
            $videoModel->video_subject = $request->video_subject;
            $videoModel->video_chapter = $request->video_chapter;
            $videoModel->video_uploaded_by = Session::get('user')->id;
            $videoModel->save();

            Session::flash('success', 'Video created successfully');
            return  redirect()->intended('/videos');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->intended('/videos');
        }
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
                $videoPath = $video->store('videos', 'public');
                $imagePath = $image->store('images', 'public');


                Video::where('id', '=', $id)
                    ->update(['video_name' =>$request->video_name,
                    'video_desc' => $request->video_desc,
                    'video_url' => $videoPath,
                    'video_thumbnail'=>$imagePath,
                    'video_course'=>$request->video_course,
                    'video_subject'=>$request->video_subject,
                    'video_chapter'=>$request->video_chapter,
                ]);
            } else if($request->video_url && !$request->video_thumbnail){
                $video = $request->file('video_url');
                $videoPath = $video->store('videos', 'public');


                Video::where('id', '=', $id)
                    ->update(['video_name' =>$request->video_name,
                    'video_desc' => $request->video_desc,
                    'video_url' => $videoPath,
                    'video_course'=>$request->video_course,
                    'video_subject'=>$request->video_subject,
                    'video_chapter'=>$request->video_chapter,
                ]);
            }else if(!$request->video_url && $request->video_thumbnail){
                $image = $request->file('video_thumbnail');
                $imagePath = $image->store('images', 'public');


                Video::where('id', '=', $id)
                    ->update(['video_name' =>$request->video_name,
                    'video_desc' => $request->video_desc,
                    'video_thumbnail'=>$imagePath,
                    'video_course'=>$request->video_course,
                    'video_subject'=>$request->video_subject,
                    'video_chapter'=>$request->video_chapter,
                ]);
            }else{

                Video::where('id', '=', $id)
                    ->update(['video_name' =>$request->video_name,
                    'video_desc' => $request->video_desc,
                    'video_course'=>$request->video_course,
                    'video_subject'=>$request->video_subject,
                    'video_chapter'=>$request->video_chapter,
                ]);
            }



            Session::flash('success', 'Video updated successfully');
            return redirect()->intended("/videos");
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->intended("/videos");
        }
    }
}
