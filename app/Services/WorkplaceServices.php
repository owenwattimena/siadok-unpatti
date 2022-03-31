<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class WorkplaceServices{

    public static function getSelect2Workplace($workplace_name)
    {
        $result = DB::table('workplaces')->select('id', 'workplace_name as text');
        if ($workplace_name != null) {
            return $result->where('workplace_name', 'like', '%' . $workplace_name . '%')->get();
        }
        return $result->get();
    }
    
    public static function getWorkplaces($id = null)
    {
        $result = DB::table('workplaces')
            ->select(['workplaces.id' ,'workplaces.workplace_name as workplace', 'workplaces.latitude', 'workplaces.longitude', 'cities.id as city_id','cities.city_name', 'cities.description'])
            ->join('cities', 'workplaces.city_id', '=', 'cities.id');
        if ($id) return $result->where('workplaces.id', $id)->first();
        return $result->get();
    }
}