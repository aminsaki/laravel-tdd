<?php
use App\Http\Controllers as Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin as Admin;
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

Route::get('/', [Controller\HomeController::class, 'index'])->name('home');
Route::get('/home', [Controller\HomeController::class, 'index'])->name('home');
Route::get('/single/{post}', [Controller\SingleController::class, 'index'])->name('single');


Route::middleware(['auth:web'])->group(function () {

    Route::post('/single/{post}/comment', [Controller\SingleController::class, 'comment'])->name('single.comment');
    ///  method test  Ajax
    Route::post('/singleAjax/{post}/comment', [Controller\SingleController::class, 'commenteAjax'])->name('singleAjax.comment');

});

# panel Admin
Route::get('admin/post/index' ,[Admin\PostController::class ,'index'])->name('post.index');
Route::get('admin/post/create' ,[Admin\PostController::class ,'create'])->name('post.create');
Route::get('admin/post/edit/{post}' ,[Admin\PostController::class ,'edit'])->name('post.edit');
Route::get('admin/post/delete/{post}' ,[Admin\PostController::class ,'destroy'])->name('post.delete');
Route::post('admin/post/store' ,[Admin\PostController::class ,'store'])->name('post.store');



Auth::routes();
