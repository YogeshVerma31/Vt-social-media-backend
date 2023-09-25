<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubCategoryController extends Controller
{

    public function createSubCategory(Request $request)
    {

        $credentials = $request->validate([
            'subcategory_name' => ['required'],
            'category_id' => ['required'],
            'subcategory_image' => ['required'],
        ]);


        $image = $request->file('subcategory_image');

        // Get the size of the image in bytes.
        $sizeInBytes = $image->getSize();

        // Convert the size to a human-readable format (e.g., KB, MB, etc.).
        $humanReadableSize = $this->formatSize($sizeInBytes);

        // Store the image in the storage (e.g., public disk).
        try {

            $path = $image->store('images', 'public');

            // Save the image data to the database.
            $categoryModel = new SubCategory();
            $categoryModel->subcategory_image = $path;
            $categoryModel->subcategory_name = $request->subcategory_name;
            $categoryModel->category_id = $request->category_id;
            $categoryModel->save();

            Session::flash('success', 'Sub Category created successfully');
            return  redirect()->intended('/subcategory');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return  redirect()->intended('/subcategory');
        }
    }

    public function index(Request $request)
    {
        try {
            $subcategoryModel = SubCategory::Join('categories', 'sub_categories.category_id', '=', 'categories.category_id')
                ->select('sub_categories.*', 'categories.category_name')
                ->get();
            $categoryModel = Category::all();

            return view("admin/subject/viewSubject", ['subcategoryData' => $subcategoryModel, 'categoryData' => $categoryModel]);
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            print_r($e->getMessage());
            die;
            //return  redirect()->intended('/subcategory');
        }
    }

    public function viewCreateSubject(Request $request)
    {
        try {

            $categoryModel = Category::all();
            // print_r($categoryModel);die;

            return view("admin/subject/createSubject", [ 'categoryData' => $categoryModel]);
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            print_r($e->getMessage());
            die;
            //return  redirect()->intended('/subcategory');
        }
    }

    public function editSubject(Request $request, $id)
    {
        $subcategoryModel = SubCategory::Join('categories', 'sub_categories.category_id', '=', 'categories.category_id')
                ->select('sub_categories.*', 'categories.category_name')
                ->where("id",'=',$id)
                ->first();
            $categoryModel = Category::all();

            return view("admin/subject/editSubject", ['subcategoryData' => $subcategoryModel, 'categoryData' => $categoryModel]);
    }

    public function updateSubject(Request $request, $id)
    {


        try {

            $subcategoryModel = SubCategory::where('id', '=', $id)->first();
            // print_r($categoryModel);die;

            if (!$subcategoryModel) {
                Session::flash('error', 'Sub Category not found');
                return redirect()->intended("/view-subject");
            }
            if ($request->subcategory_image) {
                $image = $request->file('subcategory_image');
                $path = $image->store('images', 'public');

                SubCategory::where('id', '=', $id)->update(['subcategory_name' => $request->subcategory_name,'category_id' => $request->category_id, 'subcategory_image' => $path]);
            } else {
                SubCategory::where('id', '=', $id)->update(['subcategory_name' => $request->subcategory_name,'category_id' => $request->category_id]);
            }



            Session::flash('success', 'Category updated successfully');
            return redirect()->intended("/view-subject");
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->intended("/view-subject");
        }
    }

    public function loadSubCategory(Request $request)
    {

        try {
            $subcategoryModel = SubCategory::Join('categories', 'sub_categories.category_id', '=', 'categories.category_id')
                ->select('sub_categories.*', 'categories.category_name')
                ->get();
            $categoryModel = Category::all();
            // print_r($categoryModel);die;

            return view("admin/subcategory", ['subcategoryData' => $subcategoryModel, 'categoryData' => $categoryModel]);
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            print_r($e->getMessage());
            die;
            //return  redirect()->intended('/subcategory');
        }
    }

    private function formatSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Calculate the size in the selected unit.
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    public function updateStatus(Request $request, $id)
    {


        try {

            $subCategoryModel = SubCategory::find($id);
            // print_r($subCategoryModel);die;


            if (!$subCategoryModel) {
                Session::flash('error', 'SubCategory not found');
                return view("admin/subject/viewSubject");
            }

            $subCategoryModel->update(['status' => !$subCategoryModel->status]);

            Session::flash('success', 'SubCategory updated successfully');
            return redirect()->intended("/view-subject");

        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            // return view("admin/subcategory");
            print_r($e->getMessage());die;

        }
    }



    //
}
