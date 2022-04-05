<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserServices
{

    static public function getAll(): Collection
    {
        $userId = auth()->user()->id;
        $users = User::where('role', '!=', 'alumni')->where('id', '!=', $userId);
        if (auth()->user()->role == 'superadmin') {
            $users = $users->where('role', '!=', 'developer');
        }
        return $users->get();
    }
    static public function getRoles(): array
    {
        if (auth()->user()->role == 'developer') {
            $roles = [
                "admin" => "Admin",
                "superadmin" => "Super Admin",
                "developer" => "Developer",
            ];
        } else if (auth()->user()->role == 'superadmin') {
            $roles = [
                "admin" => "Admin",
                "superadmin" => "Super Admin",
            ];
        }
        else{
            $roles = [];
        }
        return $roles;
    }

    static public function storeUser(Request $request): bool
    {
        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->level ?? 'admin';

        if ($user->save()) {
            return true;
        }
        return false;
    }
}
