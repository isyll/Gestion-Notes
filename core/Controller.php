<?php

namespace Core;

class Controller
{
    private $userDataTableName = 'params';
    protected Database $db;
    protected FormValidator $fv;
    protected SessionManager $session;
    protected AccessControl $ac;
    protected Helpers $helpers;
    protected array $request;
    protected array $data;
    protected string $defaultLayout = 'layout';

    public function __construct()
    {
        $this->db = new Database(
            dbname: 'gnotes',
            user: 'isyll',
            password: 'xCplm_'
        );

        $this->request = Helpers::resolveRequest();
        $this->session = new SessionManager();
        $this->fv      = new FormValidator();
        $this->ac      = new AccessControl();
        $this->helpers = new Helpers();

        $this->ac->loadFromDatabase($this->db, 'accesscontrol');

        $this->data['title']      = 'Accueil ' . $GLOBALS['siteName'];
        $this->data['urls']       = Router::getURLs();
        $this->data['currentURL'] = $this->currentURL();
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

    public function loadUserDatas()
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

    public function getUserData(string $name)
    {
        if (!$this->session->get('params'))
            $this->loadUserDatas();

        $datas = $this->session->get('params');

        if (isset($datas[$name]))
            return $datas[$name];

        return false;
    }

    public function setUserData(string $name, string $value)
    {

    }

    public function redirect(string $location, bool $prependHost = true)
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
        string $layout = NULL
    ): string {
        if (!$layout)
            $layout = $this->defaultLayout;

        if (!empty($data) && !array_is_list($data))
            extract($data);

        ob_start();
        require_once "{$GLOBALS['viewsPath']}/$file.html.php";
        $content = ob_get_clean();

        ob_start();
        require_once "{$GLOBALS['viewsPath']}/$layout.html.php";

        return ob_get_clean();
    }

    public function jsonDecode()
    {
        $jsonDatas = file_get_contents('php://input');
        return json_decode($jsonDatas, true);
    }

    public function jsonResponse(
        int $code,
        string $codeMsg,
        string $msg,
        array $datas = null
    ) {
        header($codeMsg);

        $results = [
            "code" => $code,
            "message" => $msg,
            "datas" => $datas ?? []
        ];

        header('content-type:application/json;charset=utf-8');
        echo json_encode($results);
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
