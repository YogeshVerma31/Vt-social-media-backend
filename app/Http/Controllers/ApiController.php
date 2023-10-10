<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Concern;
use App\Models\Follower;
use App\Models\Following;
use App\Models\Like;
use App\Models\SaveLater;
use App\Models\SubCategory;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Video;
use App\Models\Wishlist;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{

    public function homeData(Request $request)
    {
        try {

            $data = [];
            $paginationWithData = [];

            $category = Category::paginate(10);
            foreach ($category as $course) {
                $homeData = [];
                $subcategory = SubCategory::where("category_id", "=", $course->category_id)->where("status", "=", 1)->get();
                if (count($subcategory) > 0) {
                    $homeData['className'] = $course->category_name;
                    $homeData['subjectList'] = $subcategory;
                    $data[] = $homeData;
                }
            }
            $paginationWithData["currentPage"] = $category->currentPage();
            $paginationWithData["totalItems"] = $category->total();
            $paginationWithData["itemsPerPage"] = $category->currentPage();
            $paginationWithData["homeData"] = $data;

            return response()->json(["status" => 200, "message" => "Success", "data" =>  $paginationWithData], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function subjectWiseChapter(Request $request, $id)
    {
        try {

            $data = [];
            $paginationWithData = [];

            $subcategory = Chapter::where("subcategory", "=", $id)->paginate(10);
            foreach ($subcategory as $chapter) {
                $homeData = [];
                $videos = Video::where("video_chapter", "=", $chapter->id)->get();
                foreach ($videos as $video) {
                    $likeByMe = Like::join('users', 'users.id', '=', 'likes.user_id')
                        ->select("users.*", "likes.*")->where("video_id", "=", $video->id)
                        ->where("user_id", "=", $request->userId)->first() ? true : false;
                    $totalLikes = Like::where("video_id", "=", $video->id)->get()->count();
                    $totalComments = Comment::where("video_id", "=", $video->id)->get()->count();
                    $videosUploadedBy = Video::join("users", "users.id", "videos.video_uploaded_by")
                        ->select("users.name", "users.id")->where("video_chapter", "=", $chapter->id)->first();

                        $WishlistByMe = Wishlist::leftjoin('users', 'users.id', '=', 'wishlists.user_id')
                    ->select("users.*", "wishlists.*")
                    ->where("video_id", "=", $video->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;

                    $saveLaterByMe = SaveLater::leftjoin('users', 'users.id', '=', 'save_laters.user_id')
                    ->select("users.*", "save_laters.*")
                    ->where("video_id", "=", $video->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;

                    if (count($videos) > 0) {
                        $homeData['chapterId'] = $chapter->id;
                        $homeData['chapterName'] = $chapter->name;
                        $homeData['chapterVideos'] = $videos;
                        $video['likes'] = $totalLikes;
                        $video['comments'] = $totalComments;
                        $video['likeByMe'] = $likeByMe;
                        $video['wishlistByMe'] = $WishlistByMe;
                        $video['saveLaterByMe'] = $saveLaterByMe;
                        $video['videosUploadedBy'] = $videosUploadedBy;
                    }
                }
                if (count($homeData) > 0)
                    $data[] = $homeData;
            }
            $paginationWithData["currentPage"] = $subcategory->currentPage();
            $paginationWithData["totalItems"] = $subcategory->total();
            $paginationWithData["itemsPerPage"] = $subcategory->currentPage();
            $paginationWithData["chapterData"] = $data;

            return response()->json(["status" => 200, "message" => "Success", "data" =>  $paginationWithData], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function videoByChapterId(Request $request, $id)
    {
        try {

            $data = [];
            $paginationWithData = [];
            $homeData = [];
            $videos = Video::where("video_chapter", "=",  $id)->paginate(10);
            foreach ($videos as $video) {
                $likeByMe = Like::join('users', 'users.id', '=', 'likes.user_id')
                    ->select("users.*", "likes.*")->where("video_id", "=", $video->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;
                    $WishlistByMe = Wishlist::leftjoin('users', 'users.id', '=', 'wishlists.user_id')
                    ->select("users.*", "wishlists.*")
                    ->where("video_id", "=", $video->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;

                    $saveLaterByMe = SaveLater::leftjoin('users', 'users.id', '=', 'save_laters.user_id')
                    ->select("users.*", "save_laters.*")
                    ->where("video_id", "=", $video->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;

                $totalLikes = Like::where("video_id", "=", $video->id)->get()->count();
                $totalComments = Comment::where("video_id", "=", $video->id)->get()->count();
                $videosUploadedBy = Video::join("users", "users.id", "videos.video_uploaded_by")
                    ->select("users.name", "users.id")->where("video_chapter", "=", $id)->where('is_today_learning_video', '=', 0)->first();

                if (count($videos) > 0) {
                    $video['likes'] = $totalLikes;
                    $video['comments'] = $totalComments;
                    $video['likeByMe'] = $likeByMe;
                    $video['wishlistByMe'] = $WishlistByMe;
                    $video['saveLaterByMe'] = $saveLaterByMe;
                    $video['videosUploadedBy'] = $videosUploadedBy;
                    $homeData[] = $video;
                }
            }
            if (count($homeData) > 0)
                $data[] = $homeData;
            $paginationWithData["currentPage"] = $videos->currentPage();
            $paginationWithData["totalItems"] = $videos->total();
            $paginationWithData["itemsPerPage"] = $videos->currentPage();
            $paginationWithData["videos"] = $homeData;

            return response()->json(["status" => 200, "message" => "Success", "data" =>  $paginationWithData], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function likeDislikeVideo(Request $request, $id)
    {
        try {
            $videoExist = Video::where("id", '=', $id)->first();

            if ($videoExist) {
                $isVideoLiked = Like::where('video_id', '=', $id)->where('user_id', '=', $request['userId'])->first();
                $like = new Like();
                if ($isVideoLiked) {
                    Like::where('video_id', '=', $id)->where('user_id', '=', $request['userId'])->delete();
                    return response()->json(["status" => 200, "message" => "Success", "data" =>  "Disliked successfully"], 200);
                } else {
                    $like->video_id = $id;
                    $like->user_id = $request['userId'];
                    $like->save();
                    return response()->json(["status" => 200, "message" => "Success", "data" =>  "Liked successfully"], 200);
                }
            } else {
                return response()->json(["status" => 403, "message" => "Success", "data" =>  "Video may be deleted or not found!"], 403);
            }
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function getCommentsOnVideo(Request $request, $id)
    {
        try {
            $videoExist = Video::where("id", '=', $id)->first();

            if ($videoExist) {
                $comments = Comment::join('users', 'users.id', '=', 'comments.user_id')->select("users.name as username", "users.profile_image as profileImage", "comments.*")->where('video_id', '=', $id)->orderBy('created_at', 'DESC')->get();
                return response()->json(["status" => 200, "message" => "Success", "data" =>  $comments], 200);
            } else {
                return response()->json(["status" => 403, "message" => "Success", "data" =>  "Video may be deleted or not found!"], 403);
            }
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function postCommentsOnVideo(Request $request, $id)
    {
        try {
            $videoExist = Video::where("id", '=', $id)->first();

            if ($videoExist) {
                $comments = new Comment();
                $comments->user_id = $request['userId'];
                $comments->video_id = $id;
                $comments->comments = $request->comment;
                $comments->save();
                $allComments = Comment::join('users', 'users.id', '=', 'comments.user_id')->select("users.name as username", "comments.*")->where('video_id', '=', $id)->orderBy('created_at', 'DESC')->get();
                return response()->json(["status" => 200, "message" => "Success", "data" =>  $allComments], 200);
            } else {
                return response()->json(["status" => 403, "message" => "Success", "data" =>  "Video may be deleted or not found!"], 403);
            }
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function getSubcategoryByCategoryId(Request $request, $id)
    {
        try {
            $subcategory = SubCategory::where("category_id", "=", $id)->where("status", "=", 1)->get();
            return response()->json(["status" => 200, "message" => "Success", "data" =>  $subcategory], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }
    public function getChapterBySubCategoryId(Request $request, $id)
    {
        try {
            $subcategory = Chapter::where("subcategory", "=", $id)->where("status", "=", 1)->get();
            return response()->json(["status" => 200, "message" => "Success", "data" =>  $subcategory], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }


    public function allVideos(Request $request)
    {
        $final = [];
        try {
            $data = [];
            $paginationWithData = [];
            $homeData = [];
            $videos = Video::where('is_today_learning_video', '=', 0)->paginate(15);
            foreach ($videos as $video) {
                $likeByMe = Like::join('users', 'users.id', '=', 'likes.user_id')
                    ->select("users.*", "likes.*")->where("video_id", "=", $video->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;

                    $WishlistByMe = Wishlist::leftjoin('users', 'users.id', '=', 'wishlists.user_id')
                    ->select("users.*", "wishlists.*")
                    ->where("video_id", "=", $video->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;

                    $saveLaterByMe = SaveLater::leftjoin('users', 'users.id', '=', 'save_laters.user_id')
                    ->select("users.*", "save_laters.*")
                    ->where("video_id", "=", $video->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;

                $totalLikes = Like::where("video_id", "=", $video->id)->get()->count();
                $totalComments = Comment::where("video_id", "=", $video->id)->get()->count();
                $videosUploadedBy = Video::join("users", "users.id", "videos.video_uploaded_by")
                    ->select("users.name", "users.id")->first();

                if (count($videos) > 0) {
                    $video['likes'] = $totalLikes;
                    $video['comments'] = $totalComments;
                    $video['likeByMe'] = $likeByMe;
                    $video['wishlistByMe'] = $WishlistByMe;
                    $video['saveLaterByMe'] = $saveLaterByMe;
                    $video['videosUploadedBy'] = $videosUploadedBy;
                    $homeData[] = $video;
                }
            }
            if (count($homeData) > 0)
                $data[] = $homeData;
            $paginationWithData["currentPage"] = $videos->currentPage();
            $paginationWithData["totalItems"] = $videos->total();
            $paginationWithData["itemsPerPage"] = $videos->currentPage();
            $paginationWithData["videos"] = $homeData;
            return response()->json(["status" => 200, "message" => "Success", "data" => $paginationWithData], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function todaysLearningVideos(Request $request)
    {
        $final = [];
        try {
            $data = [];
            $paginationWithData = [];
            $homeData = [];
            $videos = Video::where('is_today_learning_video', '=', 1)->where('created_at', '>=', Carbon::now()->subDay()->toDateTimeString())->paginate(15);
            foreach ($videos as $video) {
                $likeByMe = Like::join('users', 'users.id', '=', 'likes.user_id')
                    ->select("users.*", "likes.*")->where("video_id", "=", $video->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;
                $totalLikes = Like::where("video_id", "=", $video->id)->get()->count();
                $totalComments = Comment::where("video_id", "=", $video->id)->get()->count();
                $videosUploadedBy = Video::join("users", "users.id", "videos.video_uploaded_by")
                    ->select("users.name", "users.id")->first();

                if (count($videos) > 0) {
                    $video['likes'] = $totalLikes;
                    $video['comments'] = $totalComments;
                    $video['likeByMe'] = $likeByMe;
                    $video['videosUploadedBy'] = $videosUploadedBy;
                    $homeData[] = $video;
                }
            }
            if (count($homeData) > 0)
                $data[] = $homeData;
            $paginationWithData["currentPage"] = $videos->currentPage();
            $paginationWithData["totalItems"] = $videos->total();
            $paginationWithData["itemsPerPage"] = $videos->currentPage();
            $paginationWithData["videos"] = $homeData;
            return response()->json(["status" => 200, "message" => "Success", "data" => $paginationWithData], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function likedVideo(Request $request)
    {
        $final = [];
        try {
            $data = [];
            $paginationWithData = [];
            $homeData = [];
            $videos = Like::join('videos', 'likes.video_id', '=', 'videos.id')
                ->select('videos.*')->where("user_id", "=", $request->query('userId'))->paginate(15);
            foreach ($videos as $video) {

                $totalLikes = Like::where("video_id", "=", $video->id)->get()->count();

                $totalComments = Comment::where("video_id", "=", $video->id)->get()->count();

                $videosUploadedBy = Video::join("users", "users.id", "videos.video_uploaded_by")
                    ->select("users.name", "users.id")->first();

                    $WishlistByMe = Wishlist::leftjoin('users', 'users.id', '=', 'wishlists.user_id')
                    ->select("users.*", "wishlists.*")
                    ->where("video_id", "=", $video->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;

                    $saveLaterByMe = SaveLater::leftjoin('users', 'users.id', '=', 'save_laters.user_id')
                    ->select("users.*", "save_laters.*")
                    ->where("video_id", "=", $video->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;

                if (count($videos) > 0) {
                    $video['likes'] = $totalLikes;
                    $video['comments'] = $totalComments;
                    $video['likeByMe'] = true;
                    $video['wishlistByMe'] = $WishlistByMe;
                    $video['saveLaterByMe'] = $saveLaterByMe;
                    $video['videosUploadedBy'] = $videosUploadedBy;
                    $homeData[] = $video;
                }
            }
            if (count($homeData) > 0)
                $data[] = $homeData;
            $paginationWithData["currentPage"] = $videos->currentPage();
            $paginationWithData["totalItems"] = $videos->total();
            $paginationWithData["itemsPerPage"] = $videos->currentPage();
            $paginationWithData["videos"] = $homeData;
            return response()->json(["status" => 200, "message" => "Success", "data" => $paginationWithData], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function searchVideo(Request $request, $subjectName)
    {
        try {
            $data = [];
            $paginationWithData = [];
            $homeData = [];
            $videos = SubCategory::join('videos', 'videos.video_subject', '=', 'sub_categories.id')
                ->where("subcategory_name", 'like', "%{$subjectName}%")->select('videos.*')->where('is_today_learning_video', '=', 0)->paginate(15);
            foreach ($videos as $video) {
                $likeByMe = Like::join('users', 'users.id', '=', 'likes.user_id')
                    ->select("users.*", "likes.*")->where("video_id", "=", $video->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;

                    $WishlistByMe = Wishlist::leftjoin('users', 'users.id', '=', 'wishlists.user_id')
                    ->select("users.*", "wishlists.*")
                    ->where("video_id", "=", $video->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;

                    $saveLaterByMe = SaveLater::leftjoin('users', 'users.id', '=', 'save_laters.user_id')
                    ->select("users.*", "save_laters.*")
                    ->where("video_id", "=", $video->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;

                $totalLikes = Like::where("video_id", "=", $video->id)->get()->count();
                $totalComments = Comment::where("video_id", "=", $video->id)->get()->count();
                $videosUploadedBy = Video::join("users", "users.id", "videos.video_uploaded_by")
                    ->select("users.name", "users.id")->first();

                if (count($videos) > 0) {
                    $video['likes'] = $totalLikes;
                    $video['comments'] = $totalComments;
                    $video['likeByMe'] = $likeByMe;
                    $video['wishlistByMe'] = $WishlistByMe;
                    $video['saveLaterByMe'] = $saveLaterByMe;
                    $video['videosUploadedBy'] = $videosUploadedBy;
                    $homeData[] = $video;
                }
            }
            if (count($homeData) > 0)
                $data[] = $homeData;
            $paginationWithData["currentPage"] = $videos->currentPage();
            $paginationWithData["totalItems"] = $videos->total();
            $paginationWithData["itemsPerPage"] = $videos->currentPage();
            $paginationWithData["videos"] = $homeData;
            return response()->json(["status" => 200, "message" => "Success", "data" => $paginationWithData], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function followUser(Request $request)
    {
        try {
            $response = Follower::where(['user_id' => $request->query('user_id'), 'follower_id' => $request->query('follower_id')])->get();
            // dd(count($request));
            $follower = new Follower();
            if (count($response) == 0) {
                $follower->user_id = $request->query('user_id');
                $follower->follower_id = $request->query('follower_id');
                $follower->save();
                return response()->json(["status" => 200, "message" => "Followed", "data" => []], 200);
            } else {
                $followDeleteRequest = Follower::where('follower_id', '=', $request->query('follower_id'))->delete();
                return response()->json(["status" => 200, "message" => "unfollowed", "data" => []], 200);
            }
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function profileData(Request $request)
    {
        try {

            $data = User::leftJoin('likes', 'likes.user_id', '=', 'users.id')
                ->select(
                    'users.*',
                    DB::raw("count(likes.id) as likedPost"),
                )
                ->groupBy('users.id', 'users.name', 'users.email', 'users.mobilenumber', 'users.profile_image', 'users.password', 'users.remember_token', 'users.created_at', 'users.updated_at', 'users.course', 'users.usertype', 'users.status', 'users.fcm_token', 'users.views')
                ->where('users.id', '=', $request->query('id'))
                ->first();
            $data['following'] = Follower::where('follower_id', '=', $request->query('id'))->get()->count();
            $data['follower'] = Follower::where('user_id', '=', $request->query('id'))->get()->count();
            $data['isFollow'] = Follower::where(['follower_id' => $request->query('userId'), 'user_id' => $request->query('id')])->first() ? true : false;

            return response()->json(["status" => 200, "message" => " Successfully", "data" => $data], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 403);
        }
    }

    public function updateView(Request $request)
    {
        try {

            $data = User::where("id", request()->query('userid'))->first();
            $data->views = $data->views + 1;
            $data->save();

            return response()->json(["status" => 200, "message" => " Successfully", "data" => []], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 403);
        }
    }

    public function getViews(Request $request)
    {
        try {

            $data = User::where("id", request()->query('userid'))->first();

            return response()->json(["status" => 200, "message" => " Successfully", "data" => $data->views], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 403);
        }
    }

    public function followersData(Request $request)
    {
        try {

            $data = Follower::leftjoin('users', 'users.id', 'followers.follower_id')
                ->select('users.id as userId', 'users.name', 'users.profile_image')->where('followers.user_id', request()->query('userId'))->get();

            return response()->json(["status" => 200, "message" => " Successfully", "data" => $data], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 403);
        }
    }

    public function followingData(Request $request)
    {
        try {

            $data = Follower::leftjoin('users', 'users.id', 'followers.user_id')
                ->select('users.id as userId', 'users.name', 'users.profile_image')
                ->where('follower_id', request()->query('userId'))->get();

            return response()->json(["status" => 200, "message" => " Successfully", "data" => $data], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 403);
        }
    }

    public function getWishList(Request $request)
    {
        $final = [];
        try {
            $data = [];
            $paginationWithData = [];
            $homeData = [];
            $videos = Wishlist::join('videos', 'wishlists.video_id', '=', 'videos.id')
                ->select('videos.*')->where("user_id", "=", $request->query('userId'))->paginate(15);
            foreach ($videos as $video) {

                $totalLikes = Like::where("video_id", "=", $video->id)->get()->count();

                $totalComments = Comment::where("video_id", "=", $video->id)->get()->count();

                $videosUploadedBy = Video::join("users", "users.id", "videos.video_uploaded_by")
                    ->select("users.name", "users.id")->first();

                    $WishlistByMe = Wishlist::leftjoin('users', 'users.id', '=', 'wishlists.user_id')
                    ->select("users.*", "wishlists.*")
                    ->where("video_id", "=", $video->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;

                if (count($videos) > 0) {
                    $video['likes'] = $totalLikes;
                    $video['comments'] = $totalComments;
                    $video['likeByMe'] = true;
                    $video['wishlistByMe'] = $WishlistByMe;
                    $video['videosUploadedBy'] = $videosUploadedBy;
                    $homeData[] = $video;
                }
            }
            if (count($homeData) > 0)
                $data[] = $homeData;
            $paginationWithData["currentPage"] = $videos->currentPage();
            $paginationWithData["totalItems"] = $videos->total();
            $paginationWithData["itemsPerPage"] = $videos->currentPage();
            $paginationWithData["videos"] = $homeData;
            return response()->json(["status" => 200, "message" => "Success", "data" => $paginationWithData], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function postWishlist(Request $request)
    {
        try {

            if (request()->query('userId') == null) {
                return response()->json(["status" => 403, "message" => "User id not empty", "data" => []], 403);
            }
            if (request()->query('videoId') == null) {
                return response()->json(["status" => 403, "message" => "Video id not empty", "data" => []], 403);
            }

            $data = Wishlist::where(['video_id' => request()->query('videoId'), 'user_id' => request()->query('userId')])->first();
            if ($data) {
                Wishlist::where(['video_id' => request()->query('videoId'), 'user_id' => request()->query('userId')])->delete();
                return response()->json(["status" => 200, "message" => "Removed From Wishlist Successfully", "data" => []], 200);
            }
            $wishlist = new Wishlist();
            $wishlist->user_id = request()->query('userId');
            $wishlist->video_id = request()->query('videoId');
            $wishlist->save();
            return response()->json(["status" => 200, "message" => "Added to Wishlist Successfully", "data" => []], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 403);
        }
    }

    public function getSaveLater(Request $request)
    {
        $final = [];
        try {
            $data = [];
            $paginationWithData = [];
            $homeData = [];
            $videos = SaveLater::join('videos', 'save_laters.video_id', '=', 'videos.id')
                ->select('videos.*')->where("user_id", "=", $request->query('userId'))->paginate(15);
            foreach ($videos as $video) {

                $totalLikes = Like::where("video_id", "=", $video->id)->get()->count();

                $totalComments = Comment::where("video_id", "=", $video->id)->get()->count();

                $videosUploadedBy = Video::join("users", "users.id", "videos.video_uploaded_by")
                    ->select("users.name", "users.id")->first();

                    $WishlistByMe = Wishlist::leftjoin('users', 'users.id', '=', 'wishlists.user_id')
                    ->select("users.*", "wishlists.*")
                    ->where("video_id", "=", $video->id)
                    ->where("user_id", "=", $request->userId)->first() ? true : false;

                if (count($videos) > 0) {
                    $video['likes'] = $totalLikes;
                    $video['comments'] = $totalComments;
                    $video['likeByMe'] = true;
                    $video['wishlistByMe'] = $WishlistByMe;
                    $video['saveLaterByMe'] = true;
                    $video['videosUploadedBy'] = $videosUploadedBy;
                    $homeData[] = $video;
                }
            }
            if (count($homeData) > 0)
                $data[] = $homeData;
            $paginationWithData["currentPage"] = $videos->currentPage();
            $paginationWithData["totalItems"] = $videos->total();
            $paginationWithData["itemsPerPage"] = $videos->currentPage();
            $paginationWithData["videos"] = $homeData;
            return response()->json(["status" => 200, "message" => "Success", "data" => $paginationWithData], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }

    public function postSaveLater(Request $request)
    {
        try {

            if (request()->query('userId') == null) {
                return response()->json(["status" => 403, "message" => "User id not empty", "data" => []], 403);
            }
            if (request()->query('videoId') == null) {
                return response()->json(["status" => 403, "message" => "Video id not empty", "data" => []], 403);
            }

            $data = SaveLater::where(['video_id' => request()->query('videoId'), 'user_id' => request()->query('userId')])->first();
            if ($data) {
                SaveLater::where(['video_id' => request()->query('videoId'), 'user_id' => request()->query('userId')])->delete();
                return response()->json(["status" => 200, "message" => "Removed From SaveLater Successfully", "data" => []], 200);
            }
            $wishlist = new SaveLater();
            $wishlist->user_id = request()->query('userId');
            $wishlist->video_id = request()->query('videoId');
            $wishlist->save();
            return response()->json(["status" => 200, "message" => "Added to SaveLater Successfully", "data" => []], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 403);
        }
    }

    public function postconcern(Request $request)
    {
        try {

            $wishlist = new Concern();
            $wishlist->user_id = request()->query('userId');
            $wishlist->title = $request->title;
            $wishlist->concern = $request->concern;
            $wishlist->save();
            return response()->json(["status" => 200, "message" => "Concern Send Successfully!", "data" => []], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 403);
        }
    }

    public function getSubscription(Request $request)
    {

        try {
            $response = Subscription::all();
            return response()->json(["status" => 200, "message" => "Success", "data" => $response], 200);
        } catch (Exception $e) {
            return response()->json(["status" => 500, "message" => $e->getMessage(), "data" => []], 500);
        }
    }
}
