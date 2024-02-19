<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FirebasePushController extends Controller
{
    public function sendPushToFCM(Request $request)
    {
        try {

            $url = 'https://fcm.googleapis.com/fcm/send';

            $data = [
                'notification' => [
                    'title' => $request->title,
                    'body' => $request->body,
                ],
                'to' => $request->fcm_token == null ? "/topics/$request->topic" : $request->fcm_token,
                'data' => [
                    'imageUrl' => $request->imageUrl
                ]
            ];

            $response =  Http::withHeaders([
                'Authorization' => 'key=AAAAm13raK8:APA91bECH45iENd4qEZVObiMeSiaCf56DOPmSdDqJdkgiGW93-tf-lQg-gHKJ9bHoW1X7r1tEnj0FvpOZ8S5h87IGQW8GzfAZm36wbVj-weSq2PDztHslASVc_LX0ahQhGYCkZv_QQv7',
                'Content-Type' => 'application/json',
            ])->post($url, $data);

            return response()->json(["status" => 200, "message" => "success", "data" => $response->body()], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }
}
