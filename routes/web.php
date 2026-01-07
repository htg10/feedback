<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\FloorController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\ToiletController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BuildingController;
use App\Http\Controllers\BackendIndexController;
use App\Http\Controllers\OtpController;

Route::get('/welcome', function () {
    return view('welcome');
});


// Route::get('/', [OTPController::class, 'showForm']);
Route::get('/feedback/{slug}', [OtpController::class, 'showForm'])->name('otp.form');
Route::post('/send-otp', [OTPController::class, 'sendOtp']);
Route::post('/verify-otp', [OTPController::class, 'verifyOtp']);
Route::post('/submit-feedback', [FeedbackController::class, 'submit']);
Route::post('/track-complaint', [OtpController::class, 'trackComplaint'])->name('track.complaint');


//LoginPage===========--------------===========>>>>
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('/admin', [LoginController::class, 'loginPost'])->name('login.post');
Route::get('admin/logout', [LoginController::class, 'logout'])->name('adminLogout');

Route::get('/dashboard', [BackendIndexController::class, 'index'])->name('dashboard')->middleware('auth');

//Authentication
Route::group(['middleware' => ['auth', 'role:1'], 'as' => 'admin.'], function () {

    Route::get('/admin/index', [BackendIndexController::class, 'index'])->name('dashboard');

    Route::get('/admin/user/register', [LoginController::class, 'register'])->name('register');
    Route::post('/admin/user/register', [LoginController::class, 'store'])->name('register.store');
    Route::get('/admin/user/{id}/edit', [LoginController::class, 'edit'])->name('user.edit');
    Route::patch('/admin/user/{id}', [LoginController::class, 'update'])->name('user.update');

    Route::get('/admin/users', [AdminController::class, 'listUsers'])->name('users');
    // Route::get('/search-filter', [AdminController::class, 'filter'])->name('filter');
    Route::get('/admin/user/delete/{id}', [AdminController::class, 'delete']);

    // Department
    Route::get('/admin/departments', [DepartmentController::class, 'index'])->name('departments');
    Route::get('/admin/department/create', [DepartmentController::class, 'create'])->name('department.create');
    Route::post('/admin/department/store', [DepartmentController::class, 'store'])->name('department.store');
    Route::get('/admin/department/{id}/edit', [DepartmentController::class, 'edit'])->name('department.edit');
    Route::patch('/admin/department/{id}', [DepartmentController::class, 'update'])->name('department.update');
    Route::get('/admin/department/delete/{id}', [DepartmentController::class, 'delete']);

    // Building
    Route::get('/admin/buildings', [BuildingController::class, 'index'])->name('buildings');
    Route::get('/admin/building/create', [BuildingController::class, 'create'])->name('building.create');
    Route::post('/admin/building/store', [BuildingController::class, 'store'])->name('building.store');
    Route::get('/admin/building/{id}/edit', [BuildingController::class, 'edit'])->name('building.edit');
    Route::patch('/admin/building/{id}', [BuildingController::class, 'update'])->name('building.update');
    Route::get('/admin/building/delete/{id}', [BuildingController::class, 'delete']);

    // Floor
    Route::get('/admin/floors', [FloorController::class, 'index'])->name('floors');
    Route::get('/admin/floor/create', [FloorController::class, 'create'])->name('floor.create');
    Route::post('/admin/floor/store', [FloorController::class, 'store'])->name('floor.store');
    Route::get('/admin/floor/{id}/edit', [FloorController::class, 'edit'])->name('floor.edit');
    Route::patch('/admin/floor/{id}', [FloorController::class, 'update'])->name('floor.update');
    Route::get('/admin/floor/delete/{id}', [FloorController::class, 'delete']);

    // Category
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/admin/category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/admin/category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/admin/category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::patch('/admin/category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/admin/category/delete/{id}', [CategoryController::class, 'delete']);

    // Room
    Route::get('/admin/rooms', [RoomController::class, 'index'])->name('rooms');
    Route::get('/admin/room/create', [RoomController::class, 'create'])->name('room.create');
    Route::post('/admin/room/store', [RoomController::class, 'store'])->name('room.store');
    Route::get('/admin/room/{id}/edit', [RoomController::class, 'edit'])->name('room.edit');
    Route::patch('/admin/room/{id}', [RoomController::class, 'update'])->name('room.update');
    Route::get('/admin/room/delete/{id}', [RoomController::class, 'delete']);

    // Feedback
    // Route::get('/admin/feedbacks', [AdminController::class, 'feedbacks'])->name('feedbacks');
    Route::get('/admin/feedbacks', [AdminController::class, 'feedbacks'])->name('feedbacks');
    Route::get('/admin/feedbacks/{id}/download', [AdminController::class, 'downloadDocuments'])->name('feedbacks.download');

    // For Feedback
    //export excel
    Route::get('admin/feedbacks/export', [AdminController::class, 'exportExcel'])
        ->name('feedbacks.export');
    //export pdf
    Route::get('admin/feedbacks/export-pdf', [AdminController::class, 'exportPDF'])
        ->name('feedbacks.export.pdf');

    // For Complaint
    Route::get('/admin/complaints/export/excel', [AdminController::class, 'exportExcel1'])
        ->name('complaints.export.excel');

    Route::get('/admin/complaints/export/pdf', [AdminController::class, 'exportPdf1'])
        ->name('complaints.export.pdf');

    // Complaint
    // Route::get('/admin/complaints', [AdminController::class, 'complaints'])->name('complaints');
    Route::get('/admin/complaints', [AdminController::class, 'complaints'])->name('complaints');
    Route::get('/admin/complaints/{id}/download', [AdminController::class, 'downloadDocuments'])->name('complaints.download');
    Route::post('/admin/complaint/statusToggle/{id}', [AdminController::class, 'statusToggle'])->name('statusToggle');

});

// User Routes
Route::group(['middleware' => ['auth', 'role:2'], 'as' => 'user.'], function () {

    Route::get('/user/index', [BackendIndexController::class, 'index'])->name('dashboard');

    // Complaint
    Route::get('/complaint/complaints', [UserController::class, 'complaints'])->name('complaints');
    Route::get('/complaint/history', [UserController::class, 'complaintHistory'])->name('history');
    Route::get('/complaint/{id}/download', [AdminController::class, 'downloadDocuments'])->name('complaints.download');
    Route::post('/complaint/statusToggle/{id}', [UserController::class, 'statusToggle'])->name('statusToggle');
    Route::post('/complaint/statusToggle1/{id}', [UserController::class, 'statusToggle1'])->name('statusToggle1');


});




