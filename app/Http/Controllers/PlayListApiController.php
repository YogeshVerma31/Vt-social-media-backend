<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Playlist;
use App\Models\PlaylistVideo;
use App\Models\SaveLater;
use App\Models\Wishlist;
use Exception;
use Illuminate\Http\Request;

class PlayListApiController extends Controller
{
    public function playlistByUser(Request $request)
    {

        try {
            $data = Playlist::where("user_id", $request->userId)->get();
            foreach ($data as $playlist) {
                $playlist->videoIsIn = playlistVideo::
                where(['playlist_id' => $playlist->id, 'video_id' => request()->query('video_id')])->first() ? true : false;
            }

            return response()->json(["status" => 200, "message" => "Success", "data" => $data], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function createPlaylistByUser(Request $request)
    {

        try {

            $playlist = new Playlist();
            $playlist->user_id = $request->userId;
            $playlist->playlist_name = $request->playlistName;
            $playlist->save();

            return response()->json(["status" => 200, "message" => "created"], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function playlistVideo(Request $request)
    {

        try {
            $playlists = PlaylistVideo::where("playlist_id", request()->query('playlistId'))->with('videos')->get();
            // foreach ($playlists as $playlistData){
            //     $homeData = $playlistData->videos->id;
            // }
            $homeData = [];
            foreach ($playlists as $playlistData) {
                $likeByMe = Like::join('users', 'users.id', '=', 'likes.user_id')
                    ->select("users.*", "likes.*")->where("video_id", "=", $playlistData->videos->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;

                $WishlistByMe = Wishlist::leftjoin('users', 'users.id', '=', 'wishlists.user_id')
                    ->select("users.*", "wishlists.*")
                    ->where("video_id", "=", $playlistData->videos->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;

                $saveLaterByMe = SaveLater::leftjoin('users', 'users.id', '=', 'save_laters.user_id')
                    ->select("users.*", "save_laters.*")
                    ->where("video_id", "=", $playlistData->videos->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;

                $totalLikes = Like::where("video_id", "=", $playlistData->videos->id)->get()->count();
                $totalComments = Comment::where("video_id", "=", $playlistData->videos->id)->get()->count();
                $playlistData->videos->likes = $totalLikes;
                $playlistData->videos->comments = $totalComments;
                $playlistData->videos->likeByMe = $likeByMe;
                $playlistData->videos->wishlistByMe = $WishlistByMe;
                $playlistData->videos->saveLaterByMe = $saveLaterByMe;
                $homeData[] = $playlistData;
            }

            return response()->json(["status" => 200, "message" => "Success", "data" => $homeData], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }
}
