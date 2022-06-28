<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\productController;

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

Route::get('/admin', function () {
    return view('welcome');
})->name('admin.dashboard');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/admin/products/trash', [ProductController::class, 'trash'])->name('products.trash');
Route::put('/admin/products/trash/{id?}', [ProductController::class, 'restore'])->name('products.restore');
Route::delete('/admin/products/trash/{id?}', [ProductController::class, 'force_delete'])->name('products.force-delete');

Route::resource('/admin/products', 'Admin\ProductController')->middleware(['auth']);

Route::get('/admin/categories/trash', [CategoryController::class, 'trash'])->name('categories.trash');
Route::put('/admin/categories/trash/{id?}', [CategoryController::class, 'restore'])->name('categories.restore');
Route::delete('/admin/categories/trash/{id?}', [CategoryController::class, 'force_delete'])->name('categories.force-delete');

Route::resource('/admin/categories', 'Admin\CategoryController')->middleware('auth');

Route::resource('/admin/roles', 'Admin\RolesController')->middleware('auth');
