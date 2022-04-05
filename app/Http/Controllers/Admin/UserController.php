<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }

    public function store(Request $request)
    {
        dd($request);
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "username" => "required|unique:users,username",
            "password" => "required|confirmed",
            "level" => "required|in:developer,superadmin,admin,mahasiswa"
        ]);

    }
}
