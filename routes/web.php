<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;

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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::resource('blog', BlogController::class);

Route::middleware(['auth'])->controller(CategoryController::class)->prefix('admin')->name('category.')->group(function () {

    Route::get('category' , 'index')->name('index');
    Route::get('category/list' , 'list')->name('list');
    Route::post('category/post', 'store')->name('store');
    Route::get('/{category}', 'show')->name('show');
    Route::post('/{category}', 'update')->name('update');
    Route::delete('/{category}', 'delete')->name('delete');


});