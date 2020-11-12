<?php

namespace App\Interfaces;

interface AuthInterface {
    
    public function setProvider();
    public function findForPassport($username);
}