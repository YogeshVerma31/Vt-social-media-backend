<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chapter;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RoutesController extends Controller
{
    public function index(Request $request)
    {
        if (Session::get('user')->usertype == 1) {
            $teacher = User::where('usertype', '=', 3)->get();
            $course = Category::all();
            $subject = SubCategory::all();
            $chapter = Chapter::all();
            $video = Video::all();
            return view('admin/dashboard', ['chapter'=>$chapter,'teacher' => $teacher,'course'=>$course,'subject'=>$subject,'video'=>$video]);
        } else {
            return redirect('videos');
        }
    }
}
