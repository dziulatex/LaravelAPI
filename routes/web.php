
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostsController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/debug', function () {
    return view('debug');
});
Route::get('/posts', function () {
    return view('posts');
});

Route::post('/user', [UserController::class, 'index']);
Route::post('/getPosts', [PostsController::class, 'getPosts']);
Route::post('/getUserBasic', [UserController::class, 'getUserBasic']);
Route::post('/getUserAdditional', [UserController::class, 'getUserAdditional']);
Route::post('/getUserCompany', [UserController::class, 'getUserCompany']);
Route::post('/getMostActiveUsers', [UserController::class, 'getMostActiveUsers']);
?>

