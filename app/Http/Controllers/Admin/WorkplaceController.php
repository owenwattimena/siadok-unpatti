<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\WorkplaceServices;
use App\Http\Controllers\Controller;

class WorkplaceController extends Controller
{
    // get workplaces for API
    // return workplace as select2 format form field
    public function getSelect2Workplace(Request $request)
    {
        $result = WorkplaceServices::getSelect2Workplace($request->query('workplace'));
        return json_encode($result);
    }

    // get workplaces for API
    public function getWorkplace(Request $request)
    {
        $workplaces = WorkplaceServices::getWorkplaces($request->query('id'));
        return json_encode($workplaces);
    }
}
