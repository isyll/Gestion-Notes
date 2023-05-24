<?php

namespace App\Controller;

use Core\Controller;
use Core\Database;
use Core\SessionManager;

class LoginController extends Controller
{
    private static array $loginInfos = [
        'login' => 'email'
    ];

    public function __construct(Database $db)
    {
        parent::__construct();
    }

    public function login()
    {
        $login    = $_POST['login'];
        $password = $_POST['password'];
    }
}
