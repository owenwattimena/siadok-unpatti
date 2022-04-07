<?php

namespace App\Http\Controllers\Admin;

use PDF;
use Illuminate\Http\Request;
use App\Services\CityServices;
use App\Services\AlumniServices;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index(Request $request)
    {

        $query = [];
        $filter = '';
        if($request->city != null){
            $city = CityServices::getCities($request->city)->first();
            $query['cities.id'] = $request->city;
            $filter .= '<b>KOTA/KABUPATEN:</b> '.$city->city_name.'<br>';
        }
        if($request->entry_year != null){
            $query['alumni.entry_year'] = $request->entry_year;
            $filter .= '<b>TAHUN MASUK:</b> '.$request->entry_year.'<br>';
        }
        if($request->graduation_year != null){
            $query['alumni.graduation_year'] = $request->graduation_year;
            $filter .= '<b>TAHUN LULUS:</b> '.$request->graduation_year.'<br>';
        }

        if($query)
        {
            $alumni = AlumniServices::getAlumnus(null, $query);
            $filter .= '<b>TOTAL:</b> '.count($alumni).'</br>';             
        }
        $data['filter'] = $filter;
        $data['alumnus'] = $alumni ?? [];
        $data['cities'] = CityServices::getCities();
        if($request->download){
            // return view('admin.report.pdf', $data);
            $pdf = PDF::loadview('admin.report.pdf',$data)->setPaper('a4', 'landscape');
            ;
            return $pdf->download('laporan-pegawai-pdf');
        
        }
        return view('admin.report.index', $data);
    }

}
