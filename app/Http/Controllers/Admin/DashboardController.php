<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $result = [];
        $lokasi = Lokasi::with('alumni')->get();

        foreach ($lokasi as $key => $value) {
            $result[$key]['lokasi'] = $value->nama;
            $result[$key]['latitude'] = $value->latitude;
            $result[$key]['longitude'] = $value->longitude;
            $result[$key]['angkatan'] = collect($value->alumni)->groupBy('angkatan');
            // foreach ($value->alumni as $key1 => $item) {
            // }
        }

        // dd($result);
        $data['lokasi'] = $result;
        return view('admin.dashboard', $data);
    }
}
