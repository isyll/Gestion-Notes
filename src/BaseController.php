<?php

namespace App;

use Core\Controller;
use Core\Database;
use Core\Router;
use App\Model\AdminModel;
use App\Model\ClassesModel;
use App\Model\NiveauxModel;
use App\Model\NotesModel;
use App\Model\SchoolYearsModel;
use App\Model\StudentsModel;
use App\Model\SubjectsModel;

class BaseController extends Controller
{
    protected SchoolYearsModel $schoolYearsModel;
    protected NiveauxModel $niveauxModel;
    protected ClassesModel $classesModel;
    protected StudentsModel $studentsModel;
    protected AdminModel $adminModel;
    protected SubjectsModel $subjectsModel;
    protected NotesModel $notesModel;

    public function __construct()
    {
        parent::__construct();

        if (!$this->session->get('logged-in') && !isset($_POST['login-form'])) {
            $loginPage = Router::getURLs()['login-page'];

            if ($loginPage != $this->request['uri']) {
                $this->redirect($loginPage);
            }
        }

        $this->db = new Database(
            dbname: 'gnotes',
            user: 'isyll',
            password: 'xCplm_'
        );

        $this->schoolYearsModel = new SchoolYearsModel($this->db);
        $this->studentsModel    = new StudentsModel($this->db);
        $this->niveauxModel     = new NiveauxModel($this->db);
        $this->classesModel     = new ClassesModel($this->db);
        $this->adminModel       = new AdminModel($this->db);
        $this->subjectsModel    = new SubjectsModel($this->db);
        $this->notesModel       = new NotesModel($this->db);

        $this->ac->loadFromDatabase($this->db, 'accesscontrol');

        $this->data = [
            'currentYear' => $this->getParam('annee-actuelle'),
            'msg' => $this->session->get('msg') ?? NULL,
            'errors' => $this->session->get('form-errors') ?? NULL,
            'urls' => Router::getURLs(),
            'currentURL' => $this->currentURL(),
            'userInfos' => $this->session->get('log-infos'),
            'title' => Router::$title ?? $GLOBALS['siteName'],
        ];

        $this->data['yearInfos']       = $this->schoolYearsModel->getYearByLibelle($this->data['currentYear']);
        $this->data['urls']['baseURL'] = $this->helpers::getBaseURL();
        $this->session->remove(['msg', 'form-errors']);

        $this->loadParams();
        if (
            empty($this->session->get('params')['annee-actuelle'])
            && Router::getURLs()['school-years'] != $this->request['uri']
        ) {
            $this->redirect(Router::getURLs()['no-init-page']);
        }
    }

    public function loadParams()
    {
        $datas = $this->db->pexec(
            'SELECT * FROM params',
            [],
            'fetchAll'
        );

        $params = [];

        foreach ($datas as $param) {
            $params[$param['nom']] = $param['valeur'];
        }

        $this->session->set('params', $params);
    }

    public function updateParam(string $name, $value): void
    {
        $this->db->pexec(
            'UPDATE params SET valeur = ? WHERE nom = ?',
            [$value, $name],
            'fetchAll'
        );

        $this->loadParams();
    }

    public function getParam(string $name)
    {
        if (!$this->session->get('params'))
            $this->loadParams();

        $datas = $this->session->get('params');

        if (isset($datas[$name]))
            return $datas[$name];

        return false;
    }

    public function initParams(array $datas): void
    {
        $sql  = 'INSERT INTO params(nom, valeur) VALUES(?,?)';
        $stmt = $this->db->getPDO()->prepare($sql);

        foreach ($datas as $key => $value) {
            $stmt->execute([$key, $value]);
        }
    }
}