<?php

namespace App\Http\Controllers;


use Illuminate\Http\Response;
//use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Services\User2Service;
use App\Services\User1Service;


Class User2Controller extends Controller {

    use ApiResponser;

    /**
        * The service to consume the User2 Microservice
        * @var User2Service
        */

    public $user2Service;

    /**
        * Create a new controller instance
        * @return void
        */

    /**
        * The service to consume the User1 Microservice
        * @var User1Service
        */

    public $user1Service;

    /**
        * Create a new controller instance
        * @return void
        */

    public function __construct(User2Service $user2Service, User1Service $user1Service){
        $this->user2Service = $user2Service;
        $this->user1Service = $user1Service;
    }


    public function showALLUSERS()
    {
        return $this->successResponse($this->user2Service->obtainUsers2());
    }


    public function addUser(Request $request)
    {
        if ($request->jobid <= 5)
        {
            $this->user1Service->obtainUserJobSITE1($request->jobid);
             return $this->successResponse($this->user2Service->createUser2($request->all(), Response::HTTP_CREATED));
        }
        elseif($request->jobid <= 10)
        {
            $this->user2Service->obtainUserJobSITE2($request->jobid);
            return $this->successResponse($this->user2Service->createUser2($request->all(), Response::HTTP_CREATED));
        }
        else{
               return response()->json(['error' => "Does not exist any instance of jobid with the given id", 'site' => 2, "code" => Response::HTTP_NOT_FOUND]);
        } 
    }


    public function showUser($id)
    {
        return $this->successResponse($this->user2Service->obtainUser2($id));      
    }

    // UPDATE
    public function updateUser(Request $request, $id)
    {
        if ($request->jobid <= 5)
        {
            $this->user1Service->obtainUserJobSITE1($request->jobid);
             return $this->successResponse($this->user2Service->editUser2($request->all(), Response::HTTP_CREATED));
        }
        elseif($request->jobid <= 10)
        {
            $this->user2Service->obtainUserJobSITE2($request->jobid);
            return $this->successResponse($this->user2Service->editUser2($request->all(), Response::HTTP_CREATED));
        }
        else{
               return response()->json(['error' => "Does not exist any instance of jobid with the given id", 'site' => 2, "code" => Response::HTTP_NOT_FOUND]);
        } 
    } 

    
    public function deleteUser($id)
    {
        return $this->successResponse($this->user2Service->deleteUser2($id));
    }

}


