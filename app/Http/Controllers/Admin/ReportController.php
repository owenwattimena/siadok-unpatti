<?php

namespace App\Http\Controllers\Admin;

use PDF;
use Illuminate\Http\Request;
use App\Services\CityServices;
use App\Services\AlumniServices;
use App\Http\Controllers\Controller;
use App\Exports\AlumniExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {

        $query = [];
        $filter = '';
        if($request->city != null){
            $city = CityServices::getCities($request->city)->first();
            $query['kota_kabupaten_tempat_pekerjaan_utama'] = $request->city;
            $filter .= '<b>KOTA/KABUPATEN:</b> '.$city->kota_kabupaten.'<br>';
        }
        if($request->entry_year != null){
            $query['tahun_masuk_s1'] = $request->entry_year;
            $filter .= '<b>TAHUN MASUK S1:</b> '.$request->entry_year.'<br>';
        }
        if($request->graduation_year != null){
            $query['tahun_lulus_s1'] = $request->graduation_year;
            $filter .= '<b>TAHUN LULUS S1:</b> '.$request->graduation_year.'<br>';
        }

        $alumni = AlumniServices::getAlumnus(null, $query);
        $filter .= '<b>TOTAL:</b> '.count($alumni).'</br>';             
        if($query)
        {
        }
        $data['filter'] = $filter;
        $data['alumnus'] = $alumni ?? [];
        $data['cities'] = CityServices::getCities();
        if($request->download){
            // return view('admin.report.pdf', $data);
            $pdf = PDF::loadview('admin.report.pdf',$data)->setPaper('a4', 'landscape');
            return $pdf->download('laporan-alumni.pdf');
        }
        if($request->export){
            return Excel::download(new AlumniExport($query), 'TRACER STUDY ALUMNI.xlsx');
        }
        return view('admin.report.index', $data);
    }

}
