<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userList()
    {
        $users = User::where('is_admin', 0)->get();
        return view('admin.user-list', compact('users'));
    }
}
