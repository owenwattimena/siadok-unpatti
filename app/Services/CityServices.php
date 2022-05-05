<?php

namespace App\Services;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityServices
{
    public static function getCities(String $kota_kabupaten = null)
    {
        if ($kota_kabupaten) return DB::table('alumni')->select('kota_kabupaten_tempat_pekerjaan_utama as kota_kabupaten')->where('kota_kabupaten_tempat_pekerjaan_utama', $kota_kabupaten)->distinct()->get();
        return DB::table('alumni')->select('kota_kabupaten_tempat_pekerjaan_utama as kota_kabupaten')->distinct()->get();
    }

    public static function storeCity(Request $request, int $id = null) : bool
    {
        $lokasi = $id != null ? Lokasi::findOrFail($id) : new Lokasi;
        $lokasi->city_name = $request->city;
        $lokasi->description = $request->description;
        $lokasi->created_by = auth()->user()->id;

        if($lokasi->save()){
            return true;
        }
        return false;
    }
}
