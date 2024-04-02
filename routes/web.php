<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PathController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\DirectionsController;

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
Route::get('/admin/buildings/reload', [BuildingController::class, 'reload'])->name('buildings.reload');
Route::get('/admin/buildings/get', [BuildingController::class, 'get'])->name('buildings.get');
Route::get('/admin/buildings/find', [BuildingController::class, 'find'])->name('buildings.find');
Route::get('/admin/buildings/add', [BuildingController::class, 'add'])->name('buildings.add');
Route::get('/admin/buildings/{id}/edit', [BuildingController::class, 'edit'])->name('buildings.edit');
Route::get('/admin/buildings/{id}/view', [BuildingController::class, 'view'])->name('buildings.view');
Route::get('/admin/buildings/delete', [BuildingController::class, 'delete'])->name('buildings.delete');
Route::get('/admin/buildings/delete-validator', [BuildingController::class, 'delete_validator'])->name('buildings.delete.validator');
Route::post('/admin/buildings/add-submit', [BuildingController::class, 'add_submit'])->name('buildings.add.submit');

Route::get('/admin/paths', [PathController::class, 'index'])->name('paths.index');
Route::get('/admin/paths/get', [PathController::class, 'get'])->name('paths.get');
Route::get('/admin/paths/find', [PathController::class, 'find'])->name('paths.find');
Route::get('/admin/paths/add', [PathController::class, 'add'])->name('paths.add');
Route::get('/admin/paths/add-submit', [PathController::class, 'add_submit'])->name('paths.add.submit');
Route::get('/admin/paths/add-validator', [PathController::class, 'validator'])->name('paths.add.validator');
Route::get('/admin/paths/edit', [PathController::class, 'edit'])->name('paths.edit');
Route::get('/admin/paths/delete', [PathController::class, 'delete'])->name('paths.delete');

Route::get('/directions/get', [DirectionsController::class, 'get'])->name('directions.get');
Route::get('/directions/get/polarpoints', [DirectionsController::class, 'polarpoints'])->name('directions.get.polarpoints');

Route::get('/procedures/index', [ProcedureController::class, 'index'])->name('procedures.index');
Route::get('/procedures/add', [ProcedureController::class, 'add'])->name('procedures.add');
Route::get('/procedures/add/validate', [ProcedureController::class, 'add_validate'])->name('procedures.add.validate');
Route::get('/procedures/add/submit', [ProcedureController::class, 'add_submit'])->name('procedures.add.submit');

Route::get('/msuiit_map', function () {
    return view('msuiit_map');
});
