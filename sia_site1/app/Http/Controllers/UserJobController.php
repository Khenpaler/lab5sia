<?php

namespace App\Http\Controllers;

use App\Models\UserJob;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;


Class UserJobController extends Controller {

    use ApiResponser;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function showALLUSERSJOB()
    {
        $usersjob = UserJob::all();
        
        return $this->successResponse($usersjob);
    }

    public function showUSERJOB($id)
    {
        $usersjob =  UserJob::findOrFail($id);

        return $this->successResponse($usersjob);
        
    }

}


