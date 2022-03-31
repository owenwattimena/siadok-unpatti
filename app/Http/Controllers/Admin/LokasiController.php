<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use App\Services\CityServices;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasi = CityServices::getCities();
        $data['lokasi'] = $lokasi;
        return view('admin.city.index',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'city' => 'required',
        ]);

        if(CityServices::storeCity($request))
        {
            return redirect()->back()->with(AlertFormatter::success('Data Kota/Kabupaten Ditambahkan'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Data Kota/Kabupaten Gagal Ditambahkan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'lokasi' => 'required',
        ]);

        $lokasi = Lokasi::findOrFail($id);
        $lokasi->nama = $request->lokasi;
        $lokasi->latitude = $request->latitude;
        $lokasi->longitude = $request->longitude;
        $lokasi->keterangan = $request->keterangan;

        if($lokasi->save())
        {
            return redirect()->back()->with(AlertFormatter::success('Data Lokasi Berhasil Ubah'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Data Lokasi Gagal Ubah'));

    }

    public function delete($id)
    {
        if(Lokasi::destroy($id))
        {
            return redirect()->back()->with(AlertFormatter::success('Data Lokasi Berhasil Hapus'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Data Lokasi Gagal Hapus'));
    }
}
