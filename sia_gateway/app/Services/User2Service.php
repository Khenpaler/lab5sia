<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class User2Service{

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
        $this->baseUri = config('services.users2.base_uri');
        $this->secret =  config('services.users2.secret');
    }

    public function obtainUsers2()
    {
        return $this->performRequest('GET','/show/users');
    }

    public function createUser2($data)
    {
        return $this->performRequest('POST', '/add/users', $data);
    }

    public function obtainUser2($id)
    {
        return $this->performRequest('GET', "/find/users/{$id}");
    }

    public function editUser2($data, $id)
    {
        return $this->performRequest('PUT',"/update/users/{$id}", $data);
    }

    public function deleteUser2($id)
    {
        return $this->performRequest('DELETE', "/delete/users/{$id}");
    }

    public function obtainUserJobSITE2($id)
    {
        return $this->performRequest('GET', "/usersjob/{$id}");
    }
}