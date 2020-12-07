<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Kreait\Firebase\Database;

class FirebaseService
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

    public function show($key)
    {
        $reference = $this->database->getReference($key);
        return  $reference->getValue();
    }

    public function update($data, $node)
    {
        $updates = [$node => $data];
        $this->database->getReference() // this is the root reference
            ->update($updates);
    }

    public function destroy($node)
    {
        $this->database->getReference($node)->remove();
    }
}