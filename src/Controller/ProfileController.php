<?php

namespace App\Controller;

use App\BaseController;

class ProfileController extends BaseController
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
