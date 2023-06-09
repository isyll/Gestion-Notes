<?php

namespace Core;

class Controller
{
    private array $httpResponseCodeMsg = [
        '200' => '200 OK',
        '204' => '204 No Content',
        '300' => '300 Multiple Choices',
        '301' => '301 Moved Permanently',
        '304' => '304 Not Modified',
        '400' => '400 Bad Request',
        '403' => '403 Forbidden',
        '404' => '404 Not Found',
        '500' => '500 Internal Server Error'
    ];
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
        $this->session = new SessionManager();
        $this->fv      = new FormValidator();
        $this->ac      = new AccessControl();
        $this->helpers = new Helpers();
        $this->request = $this->helpers::resolveRequest();
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
        $datas = require_once dirname(__DIR__) . '/config/validationRules.php';
        $this->fv->form($datas[$name], $values);
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
        bool $minify = false,
        array $scripts = []
    ): string {
        if ($layout === NULL)
            $layout = $this->defaultLayout;

        if (!empty($data) && !array_is_list($data))
            extract($data);

        ob_start();
        require_once "{$GLOBALS['viewsPath']}/$file.html.php";
        $content = ob_get_clean();

        if (count($scripts) > 0) {
            $scriptTags = '';

            foreach ($scripts as $s)
                $scriptTags .= "<script src=\"/js/$s.js\"></script>\n";
        }

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
        array $datas = [],
        string $code = '200',
    ) {
        $codeMsg = $this->httpResponseCodeMsg[$code] ?? '200 OK';
        header('HTTP/1.1 ' . $codeMsg);

        $results = [
            "code" => $code,
            "datas" => $datas
        ];

        header('content-type:application/json;charset=utf-8');
        echo json_encode($results);
        exit;
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
