<?php

namespace App\Http\Controllers;


use Illuminate\Http\Response;
//use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Services\User1Service;
use App\Services\User2Service;


Class User1Controller extends Controller {

    use ApiResponser;

    /**
        * The service to consume the User1 Microservice
        * @var User1Service
        */

    public $user1Service;

    /**
        * Create a new controller instance
        * @return void
        */
    
    /**
        * The service to consume the User1 Microservice
        * @var User2Service
        */

    public $user2Service;

    /**
        * Create a new controller instance
        * @return void
        */

    public function __construct(User1Service $user1Service, User2Service $user2Service){
        $this->user1Service = $user1Service;
        $this->user2Service = $user2Service;
    }


    public function showALLUSERS()
    {
        return $this->successResponse($this->user1Service->obtainUsers1());
    }


    public function addUser(Request $request)
    {
        if ($request->jobid <= 5)
        {
            $this->user1Service->obtainUserJobSITE1($request->jobid);
            return $this->successResponse($this->user1Service->createUser1($request->all(), Response::HTTP_CREATED));
        }
        elseif($request->jobid <= 10)
        {
            $this->user2Service->obtainUserJobSITE2($request->jobid);
            return $this->successResponse($this->user1Service->createUser1($request->all(), Response::HTTP_CREATED));
        }
        else{
            return response()->json(['error' => "Does not exist any instance of jobid with the given id", 'site' => 1, "code" => Response::HTTP_NOT_FOUND]);
        } 
    }


    public function showUser($id)
    {
        return $this->successResponse($this->user1Service->obtainUser1($id));      
    }

    // UPDATE
    public function updateUser(Request $request, $id)
    {
        if ($request->jobid <= 5)
        {
            $this->user1Service->obtainUserJobSITE1($request->jobid);
             return $this->successResponse($this->user1Service->editUser1($request->all(), Response::HTTP_CREATED));
        }
        elseif($request->jobid <= 10)
        {
            $this->user2Service->obtainUserJobSITE2($request->jobid);
            return $this->successResponse($this->user1Service->editUser1($request->all(), Response::HTTP_CREATED));
        }
        else{
            return response()->json(['error' => "Does not exist any instance of jobid with the given id", 'site' => 1, "code" => Response::HTTP_NOT_FOUND]);
        } 
    } 

    public function deleteUser($id)
    {
        return $this->successResponse($this->user1Service->deleteUser1($id));
    }

    

}


