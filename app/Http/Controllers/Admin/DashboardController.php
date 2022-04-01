<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AlumniServices;

class DashboardController extends Controller
{
    public function index()
    {
        $data['lokasi'] = [];
        $data['alumni'] = AlumniServices::getAlumnus();
        $data['entryYear'] = AlumniServices::getGroupEntryYear();
        // dd($data);
        return view('admin.dashboard', $data);
    }
}
