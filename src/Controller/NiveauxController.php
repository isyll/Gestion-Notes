<?php

namespace App\Controller;

use App\Model\NiveauxModel;
use Core\Controller;
use Core\Database;

class NiveauxController extends Controller
{

    private NiveauxModel $model;

    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->model = new NiveauxModel($db);
    }
}
