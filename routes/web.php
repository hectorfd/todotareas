<?php

use App\Http\Controllers\Api\TaskListController;
use App\Http\Controllers\Api\SubtaskController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\InvitationController;


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

Route::get('/google-auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});
 
Route::get('/google-auth/callback', function () {
    $user_google = Socialite::driver('google')->user();
    $user = User::updateOrCreate(
                ['email' => $user_google->getEmail()],
                [
                    'username' => $user_google->getName(),
                    'email' => $user_google->getEmail(),
                    'foto' => $user_google->getAvatar(),
                    'password' => Hash::make(uniqid()), 
                ]
            );
    Auth::login($user);
    return redirect('/dashboard');
    // $user->token
});

// Route::get('google-auth/redirect', function () {
//     return Socialite::driver('google')->redirect();
// });
// // ->name('google.login');

// Route::get('google-auth/callback', function () {
//     $googleUser = Socialite::driver('google')->user();

//     // Buscar o crear un usuario
//     $user = User::updateOrCreate(
//         ['email' => $googleUser->getEmail()],
//         [
//             'username' => $googleUser->getName(),
//             'email' => $googleUser->getEmail(),
//             'foto' => $googleUser->getAvatar(),
//             'password' => Hash::make(uniqid()), // Contraseña temporal
//         ]
//     );

//     Auth::login($user);
//     return redirect('/dashboard');
// });

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

Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::patch('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');


Route::post('/tasks/{task}/subtasks', [SubtaskController::class, 'store'])->name('subtasks.store');
Route::patch('/subtasks/{subtask}/update-status', [SubtaskController::class, 'updateStatus'])->name('subtasks.updateStatus');
Route::delete('/subtasks/{subtask}', [SubtaskController::class, 'destroy'])->name('subtasks.destroy');

Route::get('/task-lists/{taskList}/tasks', [TaskListController::class, 'getTasks'])->name('task-lists.tasks');

Route::resource('groups', GroupController::class);
Route::put('task_lists/{id}/assign-group', [TaskListController::class, 'assignGroup'])->name('task_lists.assignGroup');
Route::get('/dashboard', [TaskListController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'showDashboard'])->name('dashboard');

Route::post('/groups/{group}/invite', [GroupController::class, 'inviteUser'])->name('groups.inviteUser');
Route::put('/invitations/{invitation}/respond', [InvitationController::class, 'respond'])->name('invitations.respond');
