<?php

namespace App\Repositories;
use Kreait\Firebase\Database;

class FirebaseRepositories
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function all()
    {
        $reference = $this->database->getReference();
        return  $reference->getValue();
    }

    public function store($data)
    {
        $this->database->getReference($data['name'])->set($data['value']);
    }

    public function update($data, $node)
    {
        $updates = [$node => $data['value']];
        $this->database->getReference() // this is the root reference
            ->update($updates);
    }

    public function destroy($node)
    {
        $this->database->getReference($node)->remove();
    }
}