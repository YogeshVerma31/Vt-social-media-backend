<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{

    public function createCategory(Request $request)
    {

        $credentials = $request->validate([
            'category_name' => ['required'],
            'category_image' => ['required'],
        ]);


        $image = $request->file('category_image');

        // Store the image in the storage (e.g., public disk).
        try {

            $imageFileName = time() . '.' . $image->getClientOriginalExtension();

            $imagePath = $request->file('category_image')->storeAs(
                'images',
                $imageFileName,
                's3'
            );


            // Save the image data to the database.
            $categoryModel = new Category();
            $categoryModel->category_image = $imagePath;
            $categoryModel->category_name = $request->category_name;
            $categoryModel->save();

            $firebase = new FirebasePushController();
            $requestFirebase = new Request();
            $requestFirebase['title'] = "New course added";
            $requestFirebase['body'] = "Course $request->category_name added ";
            $requestFirebase['imageUrl'] = "$imagePath";
            $requestFirebase['topic'] = 'CoursePublish';
            $firebase->sendPushToFCM($requestFirebase);

            Session::flash('success', 'Category created successfully');
            return  redirect()->intended('/category');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return  redirect()->intended('/category');
        }
    }

    public function loadCategory(Request $request)
    {

        try {
            $categoryModel = Category::all();

            return view("admin/course/viewCourse", ['categoryData' => $categoryModel]);
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return  redirect()->intended('/category');
        }
    }

    public function index(Request $request)
    {

        try {
            $categoryModel = Category::all();
            return view("admin/course/viewCourse", ['categoryData' => $categoryModel]);
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return  redirect()->intended('/view-course');
        }
    }

    public function viewCreateCourse(Request $request)
    {

        try {
            $categoryModel = Category::all();

            return view("admin/course/createCourse");
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return  redirect()->intended('/create-course');
        }
    }

    public function updateStatus(Request $request, $id)
    {

        try {

            $categoryModel = Category::where('category_id', '=', $id)->first();
            // print_r($categoryModel);die;

            if (!$categoryModel) {
                Session::flash('error', 'Category not found');
                return redirect()->intended("/view-course");
            }

            Category::where('category_id', '=', $id)->update(['status' => !$categoryModel->status]);
            // $categoryModel->update(['status' => !$categoryModel->status]);

            Session::flash('success', 'Category updated successfully');
            return redirect()->intended("/view-course");
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->intended("/view-course");
            // print_r($e->getMessage());
            // die;
        }
    }

    public function updateCourse(Request $request, $id)
    {


        try {

            $categoryModel = Category::where('category_id', '=', $id)->first();
            // print_r($categoryModel);die;

            if (!$categoryModel) {
                Session::flash('error', 'Category not found');
                return redirect()->intended("/view-course");
            }
            if ($request->category_image) {
                $image = $request->file('category_image');

                $imageFileName = time() . '.' . $image->getClientOriginalExtension();

            $imagePath = $request->file('category_image')->storeAs(
                'images',
                $imageFileName,
                's3'
            );


                Category::where('category_id', '=', $id)->update(['category_name' => $request->category_name, 'category_image' => $imagePath]);
            } else {
                Category::where('category_id', '=', $id)->update(['category_name' => $request->category_name]);
            }



            Session::flash('success', 'Category updated successfully');
            return redirect()->intended("/view-course");
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->intended("/view-course");
        }
    }

    public function editCourse(Request $request, $id)
    {
        $courseModel = Category::where('category_id', '=', $id)->first();
        return view("admin/course/editCourse", ['course' => $courseModel]);
    }


}
