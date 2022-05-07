<?php

namespace App\Services;

use App\Models\User;
use App\Models\Alumni;
use App\Models\Workplace;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AlumniImport;
use App\Helpers\AlertFormatter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use phpDocumentor\Reflection\Types\Null_;
use Illuminate\Database\Eloquent\Collection;

/**
 * This class is use to get all about alumnus
 */
class AlumniServices
{

    // use to get list of alumni or specific alumni by nim
    public static function getTracerStudy(array $filter = null)
    {
        $query = Alumni::query();
        // $query = DB::table('alumni')->makeHidden(['latitude', 'longitude', 'photo', 'created_at', 'updated_at']);

        if($filter){
            $query->where($filter);
        }
        return $query
            ->get()->makeHidden(['id', 'photo', 'created_at', 'updated_at']);
    }
    public static function getAlumnus(?int $nim = null, ?array $filter = null)
    {
        $query = DB::table('alumni')
            ->select([
                'id',
                'nama_lengkap',
                'nim',
                'email',
                'tahun_masuk_s1',
                'tahun_lulus_s1',
                'wahana_internship',
                'tempat_kerja',
                'kota_kabupaten_tempat_pekerjaan_utama as kota_kabupaten',
                'latitude',
                'longitude',
                'photo',
            ]);

        if($filter){
            $query->where($filter);
        }
        if ($nim)
            return $query
                ->where([['nim', $nim]])
                ->first();
        return $query
            ->get();
    }
    // use to get list of entry year with total alumni per year
    public static function getGroupEntryYear()
    {
        return DB::table('alumni')->orderBy('alumni.tahun_masuk_s1', 'asc')->get()->groupBy('tahun_masuk_s1');
        // return DB::table('alumni')->select('entry_year')->distinct()->get();
    }

    public static function getGroupWorkplace($filter = null)
    {
        
        $items =  DB::table('alumni')->select(
            'kota_kabupaten_tempat_pekerjaan_utama as kota_kabupaten',
            'tempat_kerja',
            'latitude', 
            'longitude');
        if($filter){
            $items->where($filter);
        }
            
        $items = $items->orderBy('tempat_kerja', 'asc')->distinct()->get();
        // $items = $items->get();

        foreach ($items as $key => $item) {
            $alumni =  DB::table('alumni')
                ->select(['tahun_masuk_s1', 'tahun_lulus_s1', 'tempat_kerja','nim', 'nama_lengkap', 'kota_kabupaten_tempat_pekerjaan_utama as kota_kabupaten'])
                ->where('tempat_kerja', $item->tempat_kerja)
                ->orderBy('tempat_kerja', 'asc');
            if($filter){
                $alumni->where($filter);
            }
            $alumni = $alumni->get()->groupBy('tahun_masuk_s1');
            $listAngkatan = [];
            foreach ($alumni as $key => $value) {
                $listAngkatan[] = new Collection(
                    [
                        'tahun_masuk_s1' => $key,
                        'alumnus' => $value
                    ]
                );

            }
            $item->angkatan = new Collection($listAngkatan);
            // $item->push(['angkatan'=>new Collection($listAngkatan)]);
        }

        // foreach ($items as $item) {
        //     $item->alumni = [$item->workplace_name . ' - ' . $item->city_name];
        // }
        // dd($items);
        return $items;
    }

    public static function import(Request $requset)
    {
        Excel::import(new AlumniImport, $requset->file('file'));
    }

    public static function storeAlumni(Request $request, int $nim = null): array
    {
        try {
            if ($nim != null) {
                $oldData = self::getAlumnus($nim);
            }

            $user                 = $nim == null ? new User : User::where('nim', $nim)->first();
            $user->name           = $request->name;
            $user->nim            = $request->nim;
            $user->username       = $request->nim;
            $user->email          = $request->email;
            if ($nim == null) {
                $user->password   = Hash::make($request->password);
                $user->created_by = auth()->user()->id;
                $user->role       = "alumni";
            }
            if ($user->save()) {
                // check if $nim not null its mean user update they data. then get alumni by user id else create new alumni
                if ($nim == null) {
                    $alumni = new Alumni;
                } else {
                    $alumni = Alumni::where('user_id', $user->id)->first();
                    if (!$alumni) {
                        $alumni = new Alumni;
                    }
                }
                $alumni->user_id            = $user->id;
                $alumni->entry_year         = $request->entry_year;
                $alumni->graduation_year    = $request->graduation_year;
                $alumni->previous_job       = $request->previous_job;

                //check if workplace is select 
                if ($request->workplace != null) {
                    /// Check if workplace is int its mean user choose from list of workplace
                    if (is_int(intval($request->workplace)) && intval($request->workplace) != 0) {
                        /// check if old workplace equal to new workplace its mean user not change workplace name
                        if (isset($oldData) && $oldData->workplace_id == $request->workplace) {
                            ///check if old lat is't equal to new lat its or old long is't equal to new long its mean user change pin location then create new workplace
                            if ($oldData->latitude != $request->latitude || $oldData->longitude != $request->longitude || $oldData->city_id != $request->city_id) {
                                $workplace                  =  new Workplace;
                                $workplace->workplace_name  = $oldData->workplace_name;
                                $workplace->latitude        = $request->latitude;
                                $workplace->longitude       = $request->longitude;
                                $workplace->city_id         = $request->city_id;
                                if ($workplace->save()) {
                                    $alumni->workplace_id       = $workplace->id;
                                }
                            } else {
                                ///else its mean user not change pin location then use old workplace
                                $alumni->workplace_id = $oldData->workplace_id;
                            }
                        } else {

                            /// else its mean user change new workplace
                            $newWorkplace  =  Workplace::findOrFail($request->workplace);
                            ///check if old lat is't equal to new lat or old long is't equal to new long its mean user change pin location then create new workplace
                            // dd($newWorkplace);
                            if ($newWorkplace->latitude != $request->latitude || $newWorkplace->longitude != $request->longitude || ( isset($oldData) && $oldData->city_id != $request->city_id)) {

                                $workplace                  =  new Workplace;
                                $workplace->workplace_name  = $oldData->workplace_name;
                                $workplace->latitude        = $request->latitude;
                                $workplace->longitude       = $request->longitude;
                                $workplace->city_id         = $request->city_id;
                                if ($workplace->save()) {
                                    $alumni->workplace_id       = $workplace->id;
                                }
                            } else {
                                ///else its mean user not change pin location then use new selected workplace
                                $alumni->workplace_id = $newWorkplace->id;
                            }
                        }
                    } else {
                        // else its mean user create new workplace
                        $workplace                  =  new Workplace;
                        $workplace->workplace_name  = $request->workplace;
                        $workplace->latitude        = $request->latitude;
                        $workplace->longitude       = $request->longitude;
                        $workplace->city_id         = $request->city_id;
                        if ($workplace->save()) {
                            $alumni->workplace_id       = $workplace->id;
                        }
                    }
                }
                $alumni->save();

                return AlertFormatter::success('Data Alumni Berhasil Ditambahkan');
            }
            return AlertFormatter::danger('Error...');
        } catch (\Throwable $e) {
            dd($e);
            return AlertFormatter::danger('Error. ' . $e->getMessage());
            # code...
        }
    }
}
