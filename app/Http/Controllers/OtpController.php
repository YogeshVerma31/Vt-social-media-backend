<?php

namespace App\Http\Controllers;

use App\Mail\MyMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        try {

            $otpNumber = (string)random_int(100000, 999999);
            $mobilenumber = request()->query("mobilenumber");

            if (!$mobilenumber) {
                return response()->json(["status" => 401, "message" => "Mobile number not found", "data" =>  []], 401);
            }

            $otp =  Http::get(
                "http://sms.shivmaytechs.com/sms-panel/api/http/index.php?username=Opucation&apikey=62C87-FDFFE&apirequest=Text&sender=OPUCAN&mobile=$mobilenumber&message=Your One-Time Password (OTP) for login is:$otpNumber This code is valid for the next 5 minutes. Do not share this code with anyone.OPUCATION E-LEARNING&route=OTP&TemplateID=1707169831356992777&format=JSON"
            );

            if (json_decode($otp)->status == "success") {
                $user = User::where('mobilenumber', $mobilenumber)->update(['otp' => $otpNumber]);

                return response()->json(["status" => 200, "message" => json_decode($otp)->message, "data" =>  []], 200);
            } else {
                return response()->json(["status" => 401, "message" => json_decode($otp)->message, "data" =>  []], 401);
            }
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function forgetSendOtp(Request $request)
    {
        try {

            $otpNumber = (string)random_int(100000, 999999);

            if($request->inputType =='mobile'){
                $mobilenumber = $request->mobilenumber;
                $otp =  Http::get(
                    "http://sms.shivmaytechs.com/sms-panel/api/http/index.php?username=Opucation&apikey=62C87-FDFFE&apirequest=Text&sender=OPUCAN&mobile=$mobilenumber&message=Your One-Time Password (OTP) for login is:$otpNumber This code is valid for the next 5 minutes. Do not share this code with anyone.OPUCATION E-LEARNING&route=OTP&TemplateID=1707169831356992777&format=JSON"
                );

                if (json_decode($otp)->status == "success") {
                    $user = User::where('mobilenumber', $mobilenumber)->update(['otp' => $otpNumber]);

                    return response()->json(["status" => 200, "message" => json_decode($otp)->message, "data" =>  []], 200);
                } else {
                    return response()->json(["status" => 401, "message" => json_decode($otp)->message, "data" =>  []], 401);
                }
            }else{
                $email = $request->email;
                Mail::to($email)->send(new MyMail($otpNumber));
                $user = User::where('email', $email)->update(['otp' => $otpNumber]);

                return response()->json(["status" => 200, "message" => "Otp send to your email", "data" =>  []], 200);
            }


        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function verifyForgetOtp(Request $request)
    {
        try {

            if($request->inputType=="mobile"){
                $otp = User::Where(['mobilenumber' => $request->input, 'otp' => $request->otp])->first();
            }else{
                $otp = User::Where(['email' => $request->input, 'otp' => $request->otp])->first();
            }



            if ($otp) {
                return response()->json(["status" => 200, "message" => "Otp Verified", "data" =>  []], 200);
            } else {
                return response()->json(["status" => 401, "message" => "Otp Wrong", "data" =>  []], 401);
            }


        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function verifyMobileNumber(Request $request)
    {
        try {

            $otp = User::where(['mobilenumber' => $request->mobilenumber, 'otp' => $request->otp])->first();

            if ($otp) {
                $response = User::where('mobilenumber', $request->mobilenumber)->update(['mobile_verify' => true]);
                return response()->json(["status" => 200, "message" => "Mobile number verfied.", "data" =>  []], 200);
            } else {
                return response()->json(["status" => 401, "message" => $request->mobilenumber, "data" =>  []], 401);
            }
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }
}
