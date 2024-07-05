<?php

use App\Http\Controllers\Api\TaskListController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;

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



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Route::get('/registro', [RegisterController::class, 'showRegistrationForm'])->name('registro');
// Route::post('/registro', [RegisterController::class, 'register']);
// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [LoginController::class, 'login']);
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('auth/login');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register'])->name('registro');

Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/task-lists/create', [TaskListController::class, 'create'])->name('task_lists.create');
Route::post('/task-lists', [TaskListController::class, 'store'])->name('task_lists.store');

Route::get('/task_lists/{taskList}/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/task_lists/{taskList}/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
Route::get('/task_lists/{taskList}/completed', [TaskController::class, 'completed'])->name('tasks.completed');
