<?php

namespace App\Services;

use App\Repositories\FirebaseRepositories;
use Symfony\Component\HttpFoundation\Response;

class FirebaseService
{
    private $firebaseRepositories;
    public function __construct(FirebaseRepositories $firebaseRepositories)
    {
        $this->firebaseRepositories = $firebaseRepositories;
    }

    public function all()
    {
        return $this->firebaseRepositories->all();   
    }

    public function store($data)
    {
        $this->firebaseRepositories->store($data);
    }

    public function update($data, $node)
    {
        $this->firebaseRepositories->update($data, $node);
    }

    public function destroy($node)
    {
        $this->firebaseRepositories->destroy($node);
    }
}