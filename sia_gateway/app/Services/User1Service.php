<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class User1Service
{
    use ConsumesExternalService;

    /**
    * The base uri to consume the User1 Service
    * @var string
    */
    public $baseUri;

    /**
    * The secret to consume the User1 Service
    * @var string
    */
    public $secret;


    public function __construct()
    {
        $this->baseUri = config('services.users1.base_uri');
        $this->secret =  config('services.users1.secret');
    }

    public function obtainUsers1()
    {
        return $this->performRequest('GET', '/show/users');
    }
    
    public function createUser1($data)
    {
        return $this->performRequest('POST', '/add/users', $data);
    }

    public function obtainUser1($id)
    {
        return $this->performRequest('GET', "/find/users/{$id}");
    }

    public function editUser1($data, $id)
    {
        return $this->performRequest('PUT', "/update/users/{$id}", $data);
    }

    public function deleteUser1($id)
    {
        return $this->performRequest('DELETE', "/delete/users/{$id}");
    }

    public function obtainUserJobSITE1($id)
    {
        return $this->performRequest('GET', "/usersjob/{$id}");
    }
}
