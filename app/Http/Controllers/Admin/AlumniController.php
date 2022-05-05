<?php

namespace App\Http\Controllers\Admin;

use App\Models\Alumni;
use App\Models\Lokasi;
use Illuminate\Http\Request;
use App\Helpers\AlertFormatter;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\AlumniServices;
use App\Services\CityServices;

class AlumniController extends Controller
{
    public function index()
    {
        $alumni = AlumniServices::getAlumnus();
        // $lokasi = CityServices::getCities();
        $data['alumni'] = $alumni;
        // $data['lokasi'] = $lokasi;
        return view('admin.alumni.index', $data);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        $result = AlumniServices::import($request);
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'nim' => 'required|numeric',
            // 'password' => 'required|confirmed',
            // 'email' => 'required|string|email|max:255|unique:users,email,'. auth()->user()->id,
        ]);
        
        // dd($request->all());
        $result = AlumniServices::storeAlumni($request, $id);
        if($result['status'] == 'success')
        {
            return redirect()->back()->with(AlertFormatter::success('Data Alumni Berhasil Ubah'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Data Alumni Gagal Ubah'));
    }

    public function delete($id)
    {
        $alumni = Alumni::findOrFail($id);
        if(Alumni::where('id', $id)->delete())
        {
            $directoryPath = 'public/profile-picture';
            if($alumni->photo != null)
            {
                $path = public_path($directoryPath .'/'.$alumni->photo);
                if(file_exists($path))
                {
                    unlink($path);
                }
            }
            return redirect()->back()->with(AlertFormatter::success('Data Alumni Berhasil Dihapus'));
        }
        {
            return redirect()->back()->with(AlertFormatter::success('Data Alumni Berhasil Hapus'));
        }
        return redirect()->back()->with(AlertFormatter::danger('Data Alumni Gagal Hapus'));
    }

    // for API
    public function getAlumni(Request $request)
    {
        $alumni = AlumniServices::getAlumnus($request->query('nim'));
        return response()->json($alumni);
    }
    
    public function changePhotoProfile(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $alumni = Alumni::where('nim', $request->nim)->first();
        if(!$alumni)
        {
            return response()->json(['status' => 'error', 'message' => 'Alumni tidak ditemukan']);
        }
        $directoryPath = 'public/profile-picture';
        if($alumni->photo != null)
        {
            $path = public_path($directoryPath .'/'.$alumni->photo);
            if(file_exists($path))
            {
                unlink($path);
            }
        }
        $file = $request->file('photo');
        $profileImage = date('YmdHis') . "." . $file->getClientOriginalExtension();
        $file->move($directoryPath, $profileImage);
        $alumni->photo = $profileImage;
        if($alumni->save())
        {
            return response()->json(['status' => 'success', 'message' => 'Foto Profil Berhasil Diubah', 'photo' => $profileImage]);
        }
        return response()->json(['status' => 'error', 'message' => 'Foto Profil Gagal Diubah']);
    }
}
