<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/routing', function () {
    return view('routing');
});

Route::get('/basic_routing', function () {
    return 'Hello World';
});

Route::view('/view_route', 'view_route', ['name' => 'Filiana']);

Route::get('/controller_route', [RouteController::class, 'index']);

// Route::redirect('/', '/routing');

Route::get('/user/{id}', function ($id) {
    return "User Id: " . $id;
});

Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return "Post Id: " . $postId . ", Comment Id: " . $commentId;
});

Route::get('username/{name?}', function ($name = null) {
    return 'Username: ' . $name;
});

Route::get('/title/{title}', function ($title) {
    return "Title: " . $title;
})->where('title', '[A-Za-z]+');

Route::get('/profile/{profileId}', [RouteController::class, 'profile'])->name('profileRouteName');

// Route priority is resolved by the order they are defined
Route::get('/route_priority/user', function () {
    return "This is Route 1";
});

Route::fallback(function () {
    return 'This is Fallback Route';
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return "This is admin dashboard";
    })->name('dashboard');
    Route::get('/users', function () {
        return "This is user data on admin page";
    })->name('users');
    Route::get('/items', function () {
        return "This is item data on admin page";
    })->name('items');
});

Route::get('/bootstrap-clone', function () {
    return view('bootstrap-clone');
});

Route::get('home', [HomeController::class, 'index'])->name('home');

// Assuming ProfileController is an invokable controller
Route::get('profile', ProfileController::class)->name('profile');
Route::resource('employees', EmployeeController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'authenticate']);

Route::get('/local-disk', function () {
    Storage::disk('local')->put('local-example.txt', 'This is local example content');
    return asset('storage/local-example.txt');

});
Route::get('/public-disk', function () {
    Storage::disk('public')->put('public-example.txt', 'This is public example content');
    return asset('storage/public-example.txt');
});
Route::get('/retrieve-local-file', function () {
    if (Storage::disk('local')->exists('local-example.txt')) {
        $contents = Storage::disk('local')->get('local-example.txt');
    } else {
        $contents = 'File does not exist';
    }

    return $contents;
});
Route::get('/retrieve-public-file', function () {
    if (Storage::disk('public')->exists('public-example.txt')) {
        $contents = Storage::disk('public')->get('public-example.txt');
    } else {
        $contents = 'File does not exist';
    }

    return $contents;
});
Route::get('/download-local-file', function () {
    return Storage::download('local-example.txt', 'local file');
});
Route::get('/download-public-file', function () {
    return Storage::download('public/public-example.txt', 'public file');
});
Route::get('/file-url', function () {
    // Just prepend "/storage" to the given path and return a relative URL
    $url = Storage::url('local-example.txt');
    return $url;
});

Route::get('/file-size', function () {
    $size = Storage::size('local-example.txt');
    return $size;
});

Route::get('/file-path', function () {
    $path = Storage::path('local-example.txt');
    return $path;
});
Route::get('/upload-example', function () {
    return view('upload_example');
});

Route::post('/upload-example', function (Request $request) {
    $path = $request->file('avatar')->store('public');
    return $path;
})->name('upload-example');

Route::get('/delete-local-file', function(Request $request) {
    Storage::disk('local')->delete('local-example.txt');
    return 'Deleted';
});

Route::get('/delete-public-file', function(Request $request) {
    Storage::disk('public')->delete('public-example.txt');
    return 'Deleted';
});

Route::get('download-file/{employeeId}', [EmployeeController::class, 'downloadFile'])->name('employees.downloadFile');

Route::get('getEmployees', [EmployeeController::class, 'getData'])->name('employees.getData');
Route::get('exportExcel', [EmployeeController::class, 'exportExcel'])->name('employees.exportExcel');
