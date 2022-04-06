<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\UserServices;
use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $data['roles'] = UserServices::getRoles();
        $data['users'] = UserServices::getAll();
        return view('admin.user.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email",
            "username" => "required|unique:users,username",
            "password" => "required|confirmed",
            "level" => "required|in:developer,superadmin,admin,mahasiswa"
        ]);

        if (UserServices::storeUser($request)) {
            return redirect()->back()->with(AlertFormatter::success('User berhasil di tambahkan'));
        }
        return redirect()->back()->with(AlertFormatter::danger('User gagal di tambahkan'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            "name" => "required",
            "email" => "required|email",
            "username" => "required|unique:users,username," . auth()->user()->id,
            "level" => "required|in:developer,superadmin,admin,mahasiswa"
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return back()->withErrors($validator, 'update');

        }

        if (UserServices::storeUser($request, $id)) {
            return redirect()->back()->with(AlertFormatter::success('User berhasil di ubah'));
        }
        return redirect()->back()->with(AlertFormatter::danger('User gagal di ubah'));

    }
}
