<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PathController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\DirectionsController;
use App\Http\Controllers\FeedbackReportController;

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
Route::get('/logout_user', [AuthController::class, 'logout_user'])->name('logout');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/admin/buildings/get', [BuildingController::class, 'get'])->name('buildings.get');
Route::get('/admin/buildings/find', [BuildingController::class, 'find'])->name('buildings.find');

Route::get('/directions/get', [DirectionsController::class, 'get'])->name('directions.get');
Route::get('/directions/get/polarpoints', [DirectionsController::class, 'polarpoints'])->name('directions.get.polarpoints');

Route::get('/home/feedback-report/validate', [FeedbackReportController::class, 'add_validate'])->name('home.feedback.validate');
Route::get('/home/feedback-report/submit', [FeedbackReportController::class, 'submit'])->name('home.feedback.submit');

Route::get('/admin/paths/find', [PathController::class, 'find'])->name('paths.find');
Route::get('/admin/paths/get', [PathController::class, 'get'])->name('paths.get');

Route::get('/admin/procedures/get', [ProcedureController::class, 'get'])->name('procedures.get');

Route::get('/admin/events/get', [EventController::class, 'get'])->name('events.get');

Route::get('/admin/offices/get', [OfficeController::class, 'get'])->name('offices.get');

Route::middleware('auth', 'isAdmin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::get('/admin/feedback', [FeedbackReportController::class, 'index'])->name('feedbacks.index');
    Route::get('/admin/feedback/all', [FeedbackReportController::class, 'all'])->name('feedbacks.all');
    Route::get('/admin/feedback/edit', [FeedbackReportController::class, 'edit'])->name('feedbacks.edit');
    Route::get('/admin/feedback/delete', [FeedbackReportController::class, 'delete'])->name('feedbacks.delete');

    Route::get('/admin/buildings', [BuildingController::class, 'index'])->name('buildings.index');
    Route::get('/admin/buildings/reload', [BuildingController::class, 'reload'])->name('buildings.reload');
    Route::get('/admin/buildings/add', [BuildingController::class, 'add'])->name('buildings.add');
    Route::get('/admin/buildings/{id}/edit', [BuildingController::class, 'edit'])->name('buildings.edit');
    Route::get('/admin/buildings/{id}/view', [BuildingController::class, 'view'])->name('buildings.view');
    Route::get('/admin/buildings/edit/submit', [BuildingController::class, 'edit_submit'])->name('buildings.edit.submit');
    Route::post('/admin/buildings/edit/submit/mi', [BuildingController::class, 'edit_submit_mi'])->name('buildings.edit.submit.mi');
    Route::get('/admin/buildings/delete', [BuildingController::class, 'delete'])->name('buildings.delete');
    Route::get('/admin/buildings/delete-validator', [BuildingController::class, 'delete_validator'])->name('buildings.delete.validator');
    Route::post('/admin/buildings/add-submit', [BuildingController::class, 'add_submit'])->name('buildings.add.submit');
    Route::get('/admin/buildings/types', [BuildingController::class, 'types'])->name('buildings.types');
    Route::get('/admin/buildings/types/add', [BuildingController::class, 'types_add'])->name('buildings.types.add');
    Route::get('/admin/buildings/types/reload', [BuildingController::class, 'types_reload'])->name('buildings.types.reload');
    Route::get('/admin/buildings/types/delete', [BuildingController::class, 'types_delete'])->name('buildings.types.delete');

    Route::get('/admin/users/encrypt_passwords', [AuthController::class, 'encrypt_passwords'])->name('encrypt.passwords');

    Route::get('/admin/paths', [PathController::class, 'index'])->name('paths.index');
    Route::get('/admin/paths/add', [PathController::class, 'add'])->name('paths.add');
    Route::get('/admin/paths/add-submit', [PathController::class, 'add_submit'])->name('paths.add.submit');
    Route::get('/admin/paths/add-validator', [PathController::class, 'validator'])->name('paths.add.validator');
    Route::get('/admin/paths/edit', [PathController::class, 'edit'])->name('paths.edit');
    Route::get('/admin/paths/delete', [PathController::class, 'delete'])->name('paths.delete');
    Route::get('/admin/paths/reset', [PathController::class, 'reset'])->name('paths.reset');
    Route::get('/admin/paths/enable', [PathController::class, 'enable'])->name('paths.enable');
    Route::get('/admin/paths/disable', [PathController::class, 'disable'])->name('paths.disable');
    Route::get('/admin/paths/list/render', [PathController::class, 'render'])->name('paths.list.render');

    Route::get('/admin/procedures/index', [ProcedureController::class, 'index'])->name('procedures.index');
    Route::get('/admin/procedures/add', [ProcedureController::class, 'add'])->name('procedures.add');
    Route::get('/admin/procedures/add/validate', [ProcedureController::class, 'add_validate'])->name('procedures.add.validate');
    Route::get('/admin/procedures/add/submit', [ProcedureController::class, 'add_submit'])->name('procedures.add.submit');
    Route::get('/admin/procedures/delete', [ProcedureController::class, 'delete'])->name('procedures.delete');
    Route::get('/admin/procedures/all', [ProcedureController::class, 'all'])->name('procedures.all');
    Route::get('/admin/procedures/{id}/edit', [ProcedureController::class, 'edit'])->name('procedures.edit');
    Route::get('/admin/procedures/edit', [ProcedureController::class, 'edit_submit'])->name('procedures.edit.submit');

    Route::get('/admin/events/index', [EventController::class, 'index'])->name('events.index');
    Route::get('/admin/events/add', [EventController::class, 'add'])->name('events.add');
    Route::get('/admin/events/add/validate', [EventController::class, 'add_validate'])->name('events.add.validate');
    Route::get('/admin/events/delete', [EventController::class, 'delete'])->name('events.delete');
    Route::get('/admin/events/all', [EventController::class, 'all'])->name('events.all');
    Route::get('/admin/events/active', [EventController::class, 'active'])->name('events.active');

    Route::get('/admin/offices/index', [OfficeController::class, 'index'])->name('offices.index');
    Route::get('/admin/offices/add', [OfficeController::class, 'add'])->name('offices.add');
    Route::post('/admin/offices/add/validate', [OfficeController::class, 'add_validate'])->name('offices.add.validate');
    Route::get('/admin/offices/render', [OfficeController::class, 'render'])->name('offices.render');
    Route::get('/admin/offices/delete', [OfficeController::class, 'delete'])->name('offices.delete');
});




Route::get('/msuiit_map', function () {
    return view('msuiit_map');
});
