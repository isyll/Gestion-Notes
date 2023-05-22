<?php

namespace App\Controller;

use Core\Controller;
use Core\Database;

class StudentsController extends Controller
{
    public function __construct(Database $db)
    {
        parent::__construct($db);
    }
}
