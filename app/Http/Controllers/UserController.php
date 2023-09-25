<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Models\UserType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{

    

    public function index(Request $request){
        try {
            $userModel = User::Join('categories', 'users.course', '=', 'categories.category_id')
                ->Join('user_types', 'users.usertype', '=', 'user_types.id')
                ->select('users.*', 'categories.category_name',"user_types.name as usertype_name")
                ->get();
            $categoryModel = Category::all();
            $userTypeModel = UserType::all();
            // print_r($userTypeModel);
            // die;
            return view("admin/user/viewUser", ['user' => $userModel,'category'=>$categoryModel,'userType'=>$userTypeModel]);
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            print_r($e->getMessage());
            die;
        }
    }
    public function viewCreateUser(Request $request){
        try {
            $userModel = User::Join('categories', 'users.course', '=', 'categories.category_id')
                ->Join('user_types', 'users.usertype', '=', 'user_types.id')
                ->select('users.*', 'categories.category_name',"user_types.name as usertype_name")
                ->get();
            $categoryModel = Category::all();
            $userTypeModel = UserType::all();
            // print_r($userTypeModel);
            // die;
            return view("admin/user/createUser", ['user' => $userModel,'category'=>$categoryModel,'userType'=>$userTypeModel]);
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            print_r($e->getMessage());
            die;
        }
    }


    public function apiGetUser(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();


            if(!$user){
                return response()->json(["status"=>403,"message"=>"User not found","data"=>[]],403);
            }
        
            return response()->json(["status"=>201,"message"=>"User Created Successfully","data"=>$user],201);

        } catch (JWTException $e) {
            return response()->json(["status"=>500,"message"=>$e->getMessage(),"data"=>[]],403);
        }
    }
    
}
