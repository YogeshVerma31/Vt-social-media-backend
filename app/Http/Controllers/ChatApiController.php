<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ChatApiController extends Controller
{
    public function getChatList(Request $request)
    {
        try {

            $data = [];
            $receiverData = [];

            $response = Chat::where('user1', '=',request()->query('userId'))
            ->orwhere('user2','=',request()->query('userId'))
            ->get();

            foreach($response as $chatUser){
                $receiverData['roomId'] = $chatUser->roomId;
                if($chatUser->user1!=request()->query('userId')){
                    $receiverData['receiverData'] = User::where('id',$chatUser->user1)->first(['id','name','profile_image']);
                }else{
                    $receiverData['receiverData'] = User::where('id',$chatUser->user2)->first(['id','name','profile_image']);
                }
                $data[] = $receiverData;
            }

            return response()->json(["status" => 200, "message" => "Successfully!", "data" => $data], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 403);
        }
    }
}
