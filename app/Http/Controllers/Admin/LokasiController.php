<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use App\Services\CityServices;
use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasi = CityServices::getCities();
        $data['lokasi'] = $lokasi;
        return view('admin.city.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'city' => 'required',
        ]);

        if (CityServices::storeCity($request)) {
            return redirect()->back()->with(AlertFormatter::success('Data Kota/Kabupaten Ditambahkan'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Data Kota/Kabupaten Gagal Ditambahkan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'city' => 'required',
        ]);

        if (CityServices::storeCity($request, $id)) {
            return redirect()->back()->with(AlertFormatter::success('Data Kota/Kabupaten Disimpan'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Data Kota/Kabupaten Gagal Ditambahkan'));
    }

    public function delete($id)
    {
        try {
            if (Lokasi::destroy($id)) {
                return redirect()->back()->with(AlertFormatter::success('Data Lokasi Berhasil Hapus'));
            }
            return redirect()->back()->with(AlertFormatter::danger('Data Lokasi Gagal Hapus'));
            # code...
            
        } catch (QueryException $e) {
            if(intval($e->getCode()) == 23000){
                return redirect()->back()->with(AlertFormatter::danger('Tidak dapat menghapus. Data ini memiliki relasi.'));
            }
        } catch (\Throwable $e) {
            dd($e);
        }
    }
}
