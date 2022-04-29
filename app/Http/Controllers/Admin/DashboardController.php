<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AlumniServices;
use App\Services\WorkplaceServices;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user()->role != 'alumni'){

            $filter = [];

            if ($request->has('entry_year')) {
                $filter['tahun_masuk_s1'] = $request->query('entry_year');
            }

            $data['alumni'] = AlumniServices::getAlumnus(null, $filter);
            // $data['lokasi'] = AlumniServices::getGroupWorkplace($filter);

            $data['entryYear'] = AlumniServices::getGroupEntryYear();
            return view('admin.dashboard', $data);

        }else{
            $data['lokasi'] = Lokasi::all();
            return view('alumni.dashboard.index', $data);
        }
    }
}
