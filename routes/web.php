<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\HomeController;

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

Route::get('/', [AuthController::class, 'index'])->name('landing');
Route::get('/login_user', [AuthController::class, 'login_user'])->name('login_user');
Route::get('/register_user', [AuthController::class, 'register_user'])->name('register_user');
Route::get('/logout_user', [AuthController::class, 'logout_user'])->name('logout_user');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard');

Route::get('/admin/buildings', [BuildingController::class, 'index'])->name('buildings.index');
Route::get('/admin/buildings/get', [BuildingController::class, 'get'])->name('buildings.get');
Route::get('/admin/buildings/add', [BuildingController::class, 'add'])->name('buildings.add');
Route::get('/admin/buildings/{id}/edit', [BuildingController::class, 'edit'])->name('buildings.edit');
Route::get('/admin/buildings/{id}/view', [BuildingController::class, 'view'])->name('buildings.view');
Route::get('/admin/buildings/delete', [BuildingController::class, 'delete'])->name('buildings.delete');
Route::post('/admin/buildings/add-submit', [BuildingController::class, 'add_submit'])->name('buildings.add.submit');
