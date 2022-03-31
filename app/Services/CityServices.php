<?php

namespace App\Services;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityServices
{
    public static function getCities(int $id = null)
    {
        if ($id) return DB::table('cities')->where('id', $id)->get();
        return DB::table('cities')->get();
    }

    public static function storeCity(Request $request) : bool
    {
        $lokasi = new Lokasi;
        $lokasi->city_name = $request->city;
        $lokasi->description = $request->description;
        $lokasi->created_by = auth()->user()->id;

        if($lokasi->save()){
            return true;
        }
        return false;
    }
}
