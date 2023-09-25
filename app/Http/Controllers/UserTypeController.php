<?php

namespace App\Http\Controllers;

use App\Models\UserType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserTypeController extends Controller
{


    public function index(Request $request)
    {

        try {
            $userTypeModel = UserType::all();

            return view("admin/userType/viewUserType", ['userType' => $userTypeModel]);
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            print_r($e->getMessage());
            die;
        }
    }

    public function viewCreateType(Request $request)
    {

        try {
            $userTypeModel = UserType::all();

            return view("admin/userType/createUserType", ['userType' => $userTypeModel]);
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            print_r($e->getMessage());
            die;
        }
    }


    public function createUserType(Request $request)
    {

        $credentials = $request->validate([
            'name' => ['required'],
        ]);

        // Store the image in the storage (e.g., public disk).
        try {

            // Save the image data to the database.
            $userTypeModel = new UserType();
            $userTypeModel->name = $request->name;
            $userTypeModel->save();

            Session::flash('success', 'UserType created successfully');
            return  redirect()->intended('/usertype');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            print_r($e->getMessage());
            die;
            // return  redirect()->intended('/usertype');
        }
    }



    public function updateStatus(Request $request, $id)
    {


        try {

            $UserStatusModel = UserType::find($id);
            // print_r($UserStatusModel);die;


            if (!$UserStatusModel) {
                Session::flash('error', 'UserType not found');
                return redirect()->intended("/create-usertype");
            }

            $UserStatusModel->update(['status' => !$UserStatusModel->status]);

            Session::flash('success', 'UserType status updated successfully');
            return redirect()->intended("/create-usertype");

        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            // return view("admin/subcategory");
            print_r($e->getMessage());die;

        }
    }

}
