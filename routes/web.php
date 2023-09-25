<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\RoutesController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TodayLearningController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\VideoController;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Login
Route::get('/login', [AuthController::class, 'loginView'])->name('auth.loginView');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Register
Route::get('/register', [AuthController::class, 'registerView'])->name('auth.registerView');
Route::post('/register', [AuthController::class, 'register'])->name('register');


Route::group(['middleware'=>['customAuth']],function(){
   
    Route::get('/', [RoutesController::class,'index'])->name('dashboard');

    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::get('/category',[CategoryController::class, 'loadCategory'])->name('category');
    Route::get('/view-course',[CategoryController::class, 'index'])->name('view-course');
    Route::get('/create-course',[CategoryController::class, 'viewCreateCourse'])->name('view-create-course');
    Route::post('/category', [CategoryController::class, 'createCategory'])->name('createCategory');
    Route::get('/category/status/{id}', [CategoryController::class, 'updateStatus'])->name('updateCategoryStatus');
    Route::get('/edit-course/{id}',[CategoryController::class, 'editCourse'])->name('editCourse');
    Route::post('/update-course/{id}',[CategoryController::class, 'updateCourse'])->name('updateCourse');



    Route::get('/subcategory',[SubCategoryController::class, 'index'])->name('subcategory');
    Route::get('/view-subject',[SubCategoryController::class, 'index'])->name('view-subject');
    Route::get('/create-subject',[SubCategoryController::class, 'viewCreateSubject'])->name('view-create-subject');
    Route::post('/subcategory', [SubCategoryController::class, 'createSubCategory'])->name('createsubCategory');
    Route::get('/subcategory/status/{id}', [SubCategoryController::class, 'updateStatus'])->name('updateSubCategoryStatus');
    Route::get('/edit-subject/{id}',[SubCategoryController::class, 'editSubject'])->name('editSubject');
    Route::post('/update-subcategory/{id}',[SubCategoryController::class, 'updateSubject'])->name('updateSubCategory');




    Route::get('/usertype',[UserTypeController::class, 'index'])->name('usertype');
    Route::get('/view-usertype',[UserTypeController::class, 'index'])->name('view-usertype');
    Route::get('/create-usertype',[UserTypeController::class, 'viewCreateType'])->name('view-create-usertype');
    Route::post('/usertype', [UserTypeController::class, 'createUserType'])->name('createUserType');
    Route::get('/usertype/status/{id}', [UserTypeController::class, 'updateStatus'])->name('updateUserTypeStatus');


    Route::get('/user',[UserController::class, 'index'])->name('user');
    Route::post('/user',[AuthController::class, 'createUser'])->name('createUser');

    Route::get('/view-user',[UserController::class, 'index'])->name('view-user');
    Route::get('/create-user',[UserController::class, 'viewCreateUser'])->name('view-create-user');

    
    Route::get('/videos',[VideoController::class, 'index'])->name('videos');
    Route::post('/videos',[VideoController::class, 'createVideos'])->name('createVideo');
    Route::get('/edit-videos/{id}',[VideoController::class, 'editVideos'])->name('editVideo');
    Route::post('/update-video/{id}',[VideoController::class, 'updateVideo'])->name('updateVideo');


    Route::get('/view-video',[VideoController::class, 'index'])->name('view-video');
    Route::get('/create-video',[VideoController::class, 'viewCreateVideo'])->name('view-create-video');


    Route::get('/view-chapter',[ChapterController::class, 'index'])->name('view-chapter');
    Route::get('/view-create-chapter',[ChapterController::class, 'indexCreateChapter'])->name('view-create-chapter');
    Route::post('/chapter',[ChapterController::class, 'createChapter'])->name('createChapter');
    Route::get('/chapter/status/{id}', [ChapterController::class, 'updateStatus'])->name('updateChapterStatus');
    Route::get('/edit-chapter/{id}',[ChapterController::class, 'editChapter'])->name('editChapter');
    Route::post('/update-chapter/{id}',[ChapterController::class, 'updateChapter'])->name('updateChapter');



    Route::get('/getSubcategory/{id}',[ApiController::class, 'getSubcategoryByCategoryId']);
    Route::get('/getChapter/{id}',[ApiController::class, 'getChapterBySubCategoryId']);
    

    Route::get('/today_learning',[TodayLearningController::class, 'index'])->name('create-today-learning');
    Route::post('/create-today-learning',[TodayLearningController::class, 'createTodaysLearningVideos'])->name('create-today-learning-video');
    Route::get('/view-today-learning',[TodayLearningController::class, 'viewTodayLearning'])->name('view-today-learning');






});