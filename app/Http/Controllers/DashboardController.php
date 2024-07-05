<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskList;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $taskLists = TaskList::where('user_id', Auth::id())->get();
        return view('dashboard', compact('taskLists'));
        // return view('dashboard');
    }
}
