<?php

namespace App\Http\Controllers\Admin;

use App\Models\Alumni;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;

class AlumniController extends Controller
{
    public function index()
    {
        $alumni = Alumni::all();
        $lokasi = Lokasi::all();
        $data['alumni'] = $alumni;
        $data['lokasi'] = $lokasi;
        return view('admin.alumni.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'angkatan' => 'required|numeric',
            'lokasi_id' => 'required|numeric',
            'tempat_kerja' => 'required',
        ]);

        $alumni                 = new Alumni;
        $alumni->nama           = $request->nama;
        $alumni->angkatan       = $request->angkatan;
        $alumni->lokasi_id      = $request->lokasi_id;
        $alumni->tempat_kerja   = $request->tempat_kerja;

        if($alumni->save())
        {
            return redirect()->back()->with(AlertFormatter::success('Data Alumni Berhasil Ditambahkan'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Data Alumni Gagal Ditambahkan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'angkatan' => 'required|numeric',
            'lokasi_id' => 'required|numeric',
            'tempat_kerja' => 'required',
        ]);

        $alumni                 = Alumni::findOrFail($id);
        $alumni->nama           = $request->nama;
        $alumni->angkatan       = $request->angkatan;
        $alumni->lokasi_id      = $request->lokasi_id;
        $alumni->tempat_kerja   = $request->tempat_kerja;

        if($alumni->save())
        {
            return redirect()->back()->with(AlertFormatter::success('Data Alumni Berhasil Ubah'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Data Alumni Gagal Ubah'));
    }

    public function delete($id)
    {
        if(Alumni::destroy($id))
        {
            return redirect()->back()->with(AlertFormatter::success('Data Alumni Berhasil Hapus'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Data Alumni Gagal Hapus'));
    }
}
