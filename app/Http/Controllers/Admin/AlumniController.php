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
        $lokasi = CityServices::getCities();
        $data['alumni'] = $alumni;
        $data['lokasi'] = $lokasi;
        return view('admin.alumni.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'nim' => 'required|numeric|unique:users,nim',
            'password' => 'required|confirmed',
            'email' => 'required|string|email|max:255|unique:users,email',
        ]);

        if($request->workplace != null){
            $request->validate([
                'city_id' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
            ]);
        }
        if($request->city_id != null){
            $request->validate([
                'workplace' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
            ]);
        }

        $result = AlumniServices::storeAlumni($request);
        if($result['status'] == 'success')
        {
            return redirect()->back()->with($result);
        }
        return redirect()->back()->with($result);
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
        if(User::where('id', $id)->delete())
        {
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

}
