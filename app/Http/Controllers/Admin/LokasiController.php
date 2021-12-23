<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::all();
        $data['lokasi'] = $lokasi;
        return view('admin.lokasi.index',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'lokasi' => 'required',
        ]);

        $lokasi = new Lokasi;
        $lokasi->nama = $request->lokasi;
        $lokasi->latitude = $request->latitude;
        $lokasi->longitude = $request->longitude;
        $lokasi->keterangan = $request->keterangan;

        if($lokasi->save())
        {
            return redirect()->back()->with(AlertFormatter::success('Data Lokasi Berhasil Ditambahkan'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Data Lokasi Gagal Ditambahkan'));
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
