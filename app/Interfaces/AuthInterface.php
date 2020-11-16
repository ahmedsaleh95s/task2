<?php

namespace App\Interfaces;

interface AuthInterface {
    
    public function getProvider();
    public function getModel($username);
}