<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Usercontroller;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [PageController::class, 'main'])->name('main');
Route::get('about', [PageController::class, 'about'])->name('about');
Route::get('service', [PageController::class, 'service'])->name('service');
Route::get('projects', [PageController::class, 'projects'])->name('projects');
Route::get('contact', [PageController::class, 'contact'])->name('contact');

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'register_store'])->name('register.store');

Route::middleware('auth')->group(function(){
   Route::get('notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');
});

//php artisan route:listRoute::get('language/{locale}',[LanguageController::class ,'change_locale'])->name('local.change');





Route::resources([
   'posts' => PostController::class,
   'comments' => CommentController::class,
   //'users' => Usercontroller::class,
   'notifications' => NotificationController::class,
]);






// Route:: get('/users', [Usercontroller::class, 'index']);

// Route:: get('/users/{use}', [Usercontroller::class, 'show'] );

// Route:: get('/userYangi', [Usercontroller::class, 'ishgaTush']);
