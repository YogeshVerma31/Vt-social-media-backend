<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function show()
    {
        return redirect('admin.login');
    }

    public function register(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|unique:users,email',
            'password' => 'required',
        ]);



        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return redirect('/login');
    }

    public function login(Request $request)
    {


        try {

            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $data['email'] = $request->email;


            $user = User::where('email', $data['email'])->first();
            // print_r(password_verify($request->password, $user->password));
            // die;

            if ($user->usertype != 4 && password_verify($request->password, $user->password)) {
                $request->session()->put('user', $user);
                Session::flash('success', 'Login Successfully');
                return  redirect()->intended('/')->with('message', 'Login Successfully');
            } else {

                Session::flash('error', 'user not found');
                return  redirect()->intended('/login');
            }
        } catch (Exception $e) {
            print_r($e->getMessage());
            die;
        }
    }

    public function loginView()
    {
        return view('admin.login');
    }

    public function registerView()
    {
        return view('admin.register');
    }

    public function logout()
    {
        Session::forget('email');
        Auth::logout();
        return redirect('/login');
    }

    public function createUser(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'mobilenumber' => 'required|max:10',
        ]);

        $user = User::where('email', $request->email)->first();
        $mobileExist = User::where('mobilenumber', $request->mobilenumber)->first();

        if ($user) {
            Session::flash('error', "Email Already Exist");
            return view('admin/user/createUser');
        }

        if ($mobileExist) {
            Session::flash('error', "Mobile number already exist");
            return view('admin/user/createUser');
        }
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobilenumber' => $request->mobilenumber,
            'password' => password_hash($request->password, PASSWORD_DEFAULT),
            'course' => $request->course,
            'usertype' => $request->usertype
        ]);
        $credentials = $request->only('email', 'password');
        Session::flash('Success', "User created success!");
        Auth::attempt($credentials);
        return redirect('/create-user');
    }


    public function apiCreateStudent(Request $request)
    {
        try {

            $validate = $request->validate([
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'required',
                'mobilenumber' => 'required|min:10',
                'profile_image' => 'required'
            ]);

            $user = User::where(['email' => $request->email, "usertype" => 4])->first();
            $mobileExist = User::where(['mobilenumber' => $request->mobilenumber])->first();

            if ($user) {
                return response()->json(["status" => 403, "message" => "Email Already Exist", "data" => []], 403);
            }

            if ($mobileExist) {
                return response()->json(["status" => 403, "message" => "Mobile number already exist", "data" => []], 403);
            }



            $image = $request->file('profile_image');
            $path = $image->store('images', 'public');
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'profile_image' => $path,
                'mobilenumber' => $request->mobilenumber,
                'password' =>   ($request->password, PASSWORD_DEFAULT),
                'usertype' => 4
            ]);
            return response()->json(["status" => 200, "message" => "User Created Successfully", "data" => $path], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function apiLoginStudent(Request $request)
    {
        try {

            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
            $jwt_token = null;

            $data['email'] = $request->email;
            $input = $request->only('email', 'password');

            $user = User::where('email', $data['email'])->first();

            if (!$jwt_token = JWTAuth::attempt($input)) {
                return response()->json([
                    'status' => 403,
                    'message' => 'Invalid Email or Password',
                    'data' => null
                ], 403);
            }
            $user->fcm_token = $request->fcm_token;
            $user->remember_token = $jwt_token;
            $user->save();

            $user['token'] = $jwt_token;

            return response()->json(["status" => 201, "message" => "Login Successfully", "data" => $user], 201);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 403);
        }
    }

    public function changePassword(Request $request)
    {
        try {

            if ($request->inputType == "email") {
                $user = User::where("email", $request->input)->update(["password" => password_hash($request->password, PASSWORD_DEFAULT)]);
            } else {
                $user = User::where("mobilenumber", $request->input)->update(["password" => password_hash($request->password, PASSWORD_DEFAULT)]);
            }


            return response()->json(["status" => 200, "message" => "Password updated Successfully", "data" => []], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 403);
        }
    }
    public function changeProfileImage(Request $request)
    {
        try {


            $image = $request->file('profile_image');
            $imageFileName = time() . '.' . $image->getClientOriginalExtension();

            $imagePath = $request->file('profile_image')->storeAs(
                'images',
                $imageFileName,
                's3'
            );

            $user = User::where("id", $request->id)->update(["profile_image" =>$imagePath]);


            return response()->json(["status" => 200, "message" => "Image updated Successfully", "data" => []], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 403);
        }
    }

    public function changeProfileData(Request $request)
    {
        try {

            $bio = $request->bio;
            $fullname = $request->full_name;

            $user = User::where("id", $request->id)->update(["bio" =>$bio,'name'=>$fullname]);


            return response()->json(["status" => 200, "message" => "Profile updated Successfully", "data" => []], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 403);
        }
    }
}
