<?php

// Regular routes
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\CommentController;

// Admin routes
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\CategoriesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();
Route::group(['middleware' => 'auth'],function(){
    Route::get('/', [HomeController::class, 'index'])->name('index');

    # Post
    Route::get('/post/create', [PostController::class,'create'])->name('post.create');
    Route::post('/post/store',[PostController::class,'store'])->name('post.store');
    Route::get('/post/{id}/show',[PostController::class,'show'])->name('post.show');
    Route::get('/post/{id}/edit',[PostController::class,'edit'])->name('post.edit');
    Route::patch('/post/{id}/update',[PostController::class,'update'])->name('post.update');
    Route::delete('/post/{id}/destroy',[PostController::class,'destroy'])->name('post.destroy');
    Route::get('/post/{id}/category', [PostController::class, 'category'])->name('post.category');


    # Comment
    Route::post('comment/{id}/store',[CommentController::class,'store'])->name('comment.store');
    Route::delete('comment/{id}/destroy',[CommentController::class,'destroy'])->name('comment.destroy');

    # Profile
    Route::get('/profile/{id}/show',[ProfileController::class,'show'])->name('profile.show');
    Route::get('/profile/edit',[ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile/update',[ProfileController::class,'update'])->name('profile.update');
    Route::get('/profile/{id}/followers',[ProfileController::class,'followers'])->name('profile.followers');
    Route::get('/profile/{id}/following',[ProfileController::class,'following'])->name('profile.following');
    Route::patch('/profile/update-password',[ProfileController::class,'updatePassword'])->name('profile.updatepassword');

    # Like
    Route::post('/like/{post_id}/store',[LikeController::class,'store'])->name('like.store');
    Route::delete('/like/{post_id}/destroy',[LikeController::class,'destroy'])->name('like.destroy');

    # Follow/Unfollow
    Route::post('/follow/{user_id}/store',[FollowController::class,'store'])->name('follow.store');
    Route::delete('/follow/{user_id}/destroy',[FollowController::class,'destroy'])->name('follow.destroy');

    # Chat
    Route::get('/chat/{id}/index',[ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{id}/show',[ChatController::class, 'show'])->name('chat.show');


    # Note: All the routes we have above are regular (regular users) routes


    #Admin
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'],function(){
        # Admin Users
        //route('admin.users) is the same with admin/users
        Route::get('/users',[UsersController::class,'index'])->name('users');
        Route::delete('/users/{id}/deactivate',[UsersController::class,'deactivate'])->name('users.deactivate');
        Route::patch('/users/{id}/activate',[UsersController::class,'activate'])->name('users.activate');

        # Admin Posts
        Route::get('/posts',[PostsController::class,'index'])->name('posts'); //admin.posts
        Route::delete('/posts/{id}/hide',[PostsController::class,'hide'])->name('posts.hide');
        Route::patch('/posts/{id}/unhide',[PostsController::class,'unhide'])->name('posts.unhide');

        # Admin Categories
        Route::get('/categories',[CategoriesController::class,'index'])->name('categories'); //admin.categories
        Route::post('/categories/store',[CategoriesController::class,'store'])->name('categories.store');
        Route::patch('/categories/{id}/update',[CategoriesController::class,'update'])->name('categories.update');
        Route::delete('/categories/{id}/destroy',[CategoriesController::class,'destroy'])->name('categories.destroy');

    });

    Route::group(['middleware' => 'auth'], function(){
        Route::get('/',[HomeController::class, 'index'])->name('index');
        Route::get('/people',[HomeController::class, 'search'])->name('search');
        Route::get('/people/show',[HomeController::class, 'allUsers'])->name('allusers');

    });
});
