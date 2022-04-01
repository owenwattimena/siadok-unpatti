<?php

namespace App\Services;

use App\Models\User;
use App\Models\Alumni;
use App\Models\Workplace;
use Illuminate\Http\Request;
use App\Helpers\AlertFormatter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use phpDocumentor\Reflection\Types\Null_;

/**
 * This class is use to get all about alumnus
 */
class AlumniServices
{

    // use to get list of alumni or specific alumni by nim
    public static function getAlumnus(int $nim = null)
    {
        $query = DB::table('users')
            ->select(['users.*', 'alumni.entry_year', 'alumni.graduation_year', 'alumni.previous_job', 'workplaces.id as workplace_id', 'workplaces.workplace_name', 'workplaces.latitude', 'workplaces.longitude', 'cities.id as city_id', 'cities.city_name', 'cities.description'])
            ->leftJoin('alumni', 'users.id', '=', 'alumni.user_id')
            ->leftJoin('workplaces', 'alumni.workplace_id', '=', 'workplaces.id')
            ->leftJoin('cities', 'workplaces.city_id', '=', 'cities.id');
        if ($nim)
            return $query
                ->where([['nim', $nim], ['role', 'alumni']])
                ->first();
        return $query
            ->where([['role', 'alumni']])
            ->get();
    }
    // use to get list of entry year with total alumni per year
    public static function getEntryYear()
    {
        return DB::table('users')->join('alumni', 'users.id', '=', 'alumni.user_id')->get();
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
                $user->created_by     = auth()->user()->id;
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
                if ($request->workplace != null ) {
                    /// Check if workplace is int its mean user choose from list of workplace

                    if (is_int(intval($request->workplace))) {
                        /// check if old workplace equal to new workplace its mean user not change workplace name
                        if ($oldData->workplace_id == $request->workplace) {
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
                            ///check if old lat is't equal to new lat its or old long is't equal to new long its mean user change pin location then create new workplace
                            if ($newWorkplace->latitude != $request->latitude || $newWorkplace->longitude != $request->longitude || $oldData->city_id != $request->city_id) {
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
                /// check if request workplace is't null its mean user has input workplace value
                // if ($request->workplace != null) {
                //     /// check if instace of Workplace is set, its mean user that user wont to create or udpate workplace 
                //     if(isset($workplace)){
                //         // if workplace is succesfully save set workplace id to alumni
                //         if ($workplace->save()) {
                //             $alumni->workplace_id       = $workplace->id;
                //         }
                //     }else{
                //         /// else its mean user dont change the workplace value then use workplace old data
                //         $alumni->workplace_id= $oldData->workplace_id;
                //     }
                // }
                $alumni->save();

                return AlertFormatter::success('Data Alumni Berhasil Ditambahkan');
            }
            return AlertFormatter::danger('Data Alumni Gagal Ditambahkan');
        } catch (\Throwable $e) {
            dd($e);
            return AlertFormatter::danger('Data Alumni Gagal Ditambahkan. ' . $e->getMessage());
            # code...
        }

    }
}
