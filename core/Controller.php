<?php

namespace Core;

use App\Model\AdminModel;
use App\Model\ClassesModel;
use App\Model\NiveauxModel;
use App\Model\SchoolYearsModel;
use App\Model\StudentsModel;

class Controller
{
    private string $userDataTableName = 'params';
    private array $httpResponseCodeMsg = [
        '200' => '200 OK',
        '204' => '204 No Content',
        '300' => '300 Multiple Choices',
        '301' => '301 Moved Permanently',
        '304' => '304 Not Modified',
        '400' => '400 Bad Request',
        '403' => '403 Forbidden',
        '404' => '404 Not Found',
    ];
    protected Database $db;
    protected FormValidator $fv;
    protected SessionManager $session;
    protected AccessControl $ac;
    protected Helpers $helpers;
    protected SchoolYearsModel $schoolYearsModel;
    protected NiveauxModel $niveauxModel;
    protected ClassesModel $classesModel;
    protected StudentsModel $studentsModel;
    protected AdminModel $adminModel;
    protected array $request;
    protected array $data;
    protected string $defaultLayout = 'layout';

    public function __construct()
    {
        $this->request = Helpers::resolveRequest();
        $this->session = new SessionManager();
        $this->fv      = new FormValidator();
        $this->ac      = new AccessControl();
        $this->helpers = new Helpers();

        if (!$this->session->get('logged-in') && !isset($_POST['login-form'])) {
            $loginPage = Router::getURLs()['login-page'];

            if ($loginPage != $_SERVER['REQUEST_URI']) {
                $this->redirect($loginPage);
            }
        }

        $this->db = new Database(
            dbname: 'gnotes',
            user: 'isyll',
            password: 'xCplm_'
        );

        $this->schoolYearsModel = new SchoolYearsModel($this->db);
        $this->niveauxModel     = new NiveauxModel($this->db);
        $this->classesModel     = new ClassesModel($this->db);
        $this->adminModel       = new AdminModel($this->db);

        $this->ac->loadFromDatabase($this->db, 'accesscontrol');

        $this->data = [
            'currentYear' => $this->getParam('annee-actuelle'),
            'msg' => $this->session->get('msg') ?? NULL,
            'errors' => $this->session->get('form-errors') ?? NULL,
            'urls' => Router::getURLs(),
            'currentURL' => $this->currentURL(),
            'userInfos' => $this->session->get('log-infos'),
            'title' => Router::$title ?? $GLOBALS['siteName']
        ];

        $this->data['urls']['baseURL']     = $this->helpers::getBaseURL();
        $this->data['urls']['current-url'] = $this->currentURL();
        $this->session->remove(['msg', 'form-errors']);
    }

    public function setLogInfo(string $name, mixed $value)
    {
        $infos        = $this->session->get('log-infos') ?? [];
        $infos[$name] = $value;
        $this->session->set('log-infos', $infos);
    }

    public function userLogin(array $infos)
    {
        $this->session->set('logged-in', true);
        $this->session->set('log-infos', $infos);
        $this->redirect();
    }

    public function userLogout()
    {
        $this->session->destroy();
        $this->redirect($this->data['urls']['login-page']);
    }

    public function currentURL()
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $url = "https://";
        else
            $url = "http://";

        $url .= $_SERVER['HTTP_HOST'];
        $url .= $_SERVER['REQUEST_URI'];

        return $url;
    }

    public function loadValidationRules(string $name, array &$values)
    {
        $datas = \App\Configuration\ValidationRules::$datas[$name];

        $this->fv->form($datas, $values);
    }

    public function loadParams()
    {
        $datas = $this->db->pexec(
            "SELECT * FROM params",
            [],
            'fetchAll'
        );

        $params = [];

        foreach ($datas as $param) {
            $params[$param['nom']] = $param['valeur'];
        }

        $this->session->set('params', $params);
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

    public function setUserData(string $name, string $value)
    {

    }

    public function redirect(string $location = '', bool $prependHost = true)
    {
        if ($location === '')
            $location = '/';

        if ($prependHost)
            $location = Helpers::getBaseURL() . $location;

        header("Location: $location");
        exit;
    }

    public function render(
        string $file,
        array $data = [],
        string $layout = NULL,
        bool $minify = false
    ): string {
        if ($layout === NULL)
            $layout = $this->defaultLayout;

        if (!empty($data) && !array_is_list($data))
            extract($data);

        ob_start();
        require_once "{$GLOBALS['viewsPath']}/$file.html.php";
        $content = ob_get_clean();

        if ($minify)
            $content = $this->helpers::minifyHtml($content);

        if (!$layout)
            return $content;

        ob_start();
        require_once "{$GLOBALS['viewsPath']}/$layout.html.php";
        $result = ob_get_clean();

        if ($minify)
            $result = $this->helpers::minifyHtml($result);

        return $result;
    }

    public function jsonDecode()
    {
        $jsonDatas = file_get_contents('php://input');
        return json_decode($jsonDatas, true);
    }

    public function jsonResponse(
        int $code,
        string $msg,
        array $datas = []
    ): bool|string {
        $codeMsg = $this->httpResponseCodeMsg[$code] ?? '200 OK';
        header('HTTP/1.1 ' . $codeMsg);

        $results = [
            "code" => $code,
            "message" => $msg,
            "datas" => $datas
        ];

        header('content-type:application/json;charset=utf-8');
        return json_encode($results);
    }

    public function success(string $value): array
    {
        return [
            'type' => 'success',
            'value' => $value
        ];
    }

    public function error(string $value): array
    {
        return [
            'type' => 'danger',
            'value' => $value
        ];
    }
}
