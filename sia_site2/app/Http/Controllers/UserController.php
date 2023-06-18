<?php

namespace App\Http\Controllers;


use Illuminate\Http\Response;
use App\Models\User;
use App\Models\UserJob;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;


Class UserController extends Controller {

    use ApiResponser;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function getUsers()
    {
        $users = User::all();
        return response()->json(['data' => $users], 200);
        
        //return $this->successResponse($users);
    }

    public function showALLUSERS()
    {
        $users = User::all();
        
        return $this->successResponse($users);
    }



    public function addUser(Request $request)
    {
        
        $rules = [
            'username' => 'required|max:20',
            'password' => 'required|max:20',
            'gender' => 'required|in:Male,Female',
            'jobid' => 'required|numeric|min:1|not_in:0',
        ];

        $this->validate($request,$rules);

        //validate if Jobid is found in the table tbluserjob
        //$userjob = UserJob::findOrFail($request->jobid);
        $user = User::create($request->all());
        
        return $this->successResponse($user, Response::HTTP_CREATED);
        //return response()->json($user, 200);
    }


    public function showUser($id)
    {
        $user =  User::findOrFail($id);

        return $this->successResponse($user);

        //$user = User::where('userid', $id)->first();

        /*if($user){
            return $this->successResponse($user);
        }
        else{
            return $this->errorResponse('User ID Does Not Exists', Response::HTTP_NOT_FOUND);
        }*/
        
    }

    public function deleteUser($id) {

        $user =  User::findOrFail($id);

        $user->delete();

        return $this->successResponse('User Deleted!');
        //return $this->errorResponse('User ID Does Not Exists', Response::HTTP_NOT_FOUND);
        
        /*$user = User::where('userid', $id)->delete();

        if($user){
            return $this->successResponse($user);
        }
        else{
            return $this->errorResponse('User ID Does Not Exists', Response::HTTP_NOT_FOUND);
        }*/
    }

    // UPDATE
    public function updateUser(Request $request, $id)
    {

        $rules = [
                'username' => 'max:20',
                'password' => 'max:20',
                'gender' => 'in:Male,Female',
                'jobid' => 'required|numeric|min:1|not_in:0',
        ];

        $this->validate($request, $rules);

        //$userjob = UserJob::findOrFail($request->jobid);

        $user = User::where('userid', $id)->firstOrFail();

        $user->fill($request->all());

        if($user->isClean()) {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();
        return $this->successResponse($user);

        /*$user = User::where('userid', $id)->firstOrFail();
        $rules = [
            $this->validate($request, [
                'username' => 'required|max:20',
                'password' => 'required|max:20',
                'gender' => 'required|in:Male,Female',
            ])  
        ];
        $this->validate($request, $rules);
        $user->fill($request->all());
        $user->save();
        
        return $this->successResponse($user);*/
    
    } 

}


