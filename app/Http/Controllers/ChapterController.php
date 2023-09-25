<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ChapterController extends Controller
{

    public function updateStatus(Request $request, $id)
    {


        try {

            $chapterModel = Chapter::find($id);
            // print_r($chapterModel);die;

            if (!$chapterModel) {
                Session::flash('error', 'chapter not found');
                return view("admin/subject/viewchapter");
            }

            $chapterModel->update(['status' => !$chapterModel->status]);

            Session::flash('success', 'chapter status updated successfully');
            return redirect()->intended("/view-chapter");

        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->intended("/view-chapter");
            // print_r($e->getMessage());die;

        }
    }

    public function updateChapter(Request $request, $id)
    {


        try {

            $chapterModel = Chapter::where('id', '=', $id)->first();
            // print_r($categoryModel);die;

            if (!$chapterModel) {
                Session::flash('error', 'Chapter not found');
                return redirect()->intended("/view-chapter");
            }
            if ($request->image) {
                $image = $request->file('image');
                $path = $image->store('images', 'public');
                Chapter::where('id', '=', $id)->update(['name' => $request->name,'subcategory' => $request->subcategory, 'image' => $path]);
            } else {
                Chapter::where('id', '=', $id)->update(['name' => $request->name,'subcategory' => $request->subcategory]);
            }



            Session::flash('success', 'Category updated successfully');
            return redirect()->intended("/view-chapter");
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->intended("/view-chapter");
        }
    }

    public function createChapter(Request $request)
    {

        $credentials = $request->validate([
            'name' => ['required'],
            'subcategory' => ['required'],
            'image' => ['required'],
        ]);


        $image = $request->file('image');

        // Get the size of the image in bytes.
        $sizeInBytes = $image->getSize();


        try {

            $path = $image->store('images', 'public');

            // Save the image data to the database.
            $categoryModel = new Chapter();
            $categoryModel->image = $path;
            $categoryModel->name = $request->name;
            $categoryModel->subcategory = $request->subcategory;
            $categoryModel->save();

            Session::flash('success', 'Chapter created successfully');
            return  redirect()->intended('/view-create-chapter');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return  redirect()->intended('/view-create-chapter');
        }
    }

    public function index(Request $request)
    {

        $chapters = [];
        try{
        if(!$request->id){
            $chapters = Chapter::index();
        }else{
            $chapters=Chapter::getChapterBySubject($request->id);
        }
        $subject = SubCategory::all();
        return view('admin/chapter/viewchapter', ['chapter' => $chapters,'subject'=>$subject]);
        }
        catch(Exception $e){
            Session::flash('error', $e->getMessage());
            return view('admin/chapter/viewchapter');
        }
    }

    public function indexCreateChapter(Request $request)
    {

        $chapters = [];
        try{
        if(!$request->id){
            $chapters = Chapter::index();
        }else{
            $chapters=Chapter::getChapterBySubject($request->id);
        }
        $subject = SubCategory::all();
        return view('admin/chapter/createchapter', ['chapter' => $chapters,'subject'=>$subject]);
        }
        catch(Exception $e){
            Session::flash('error', $e->getMessage());
            return view('admin/chapter/createchapter');
        }
    }

    public function editChapter(Request $request,$id)
    {

        try{
            $chapters =  Chapter::Join('sub_categories', 'chapters.subcategory', '=', 'sub_categories.id')
            ->select('chapters.*', 'sub_categories.subcategory_name')
            ->where('chapters.id','=',$id)
            ->first();
        $subject = SubCategory::all();
        return view('admin/chapter/editchapter', ['chapter' => $chapters,'subject'=>$subject]);
        }
        catch(Exception $e){
            Session::flash('error', $e->getMessage());
            return redirect()->intended("/view-chapter");
        }
    }


}
