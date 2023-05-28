<?php

namespace App\Controller;

use Core\Controller;

class ProfileController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function userPage($userId)
    {
        echo $this->render('user-profile', $this->data);
    }
}
