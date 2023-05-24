<?php

namespace Core;

class Controller
{
    protected Database $db;
    protected FormValidator $fv;
    protected SessionManager $session;
    protected array $request;
    protected array $data;
    protected string $defaultLayout = 'layout';

    public function __construct(Database $db)
    {
        $this->db      = $db;
        $this->request = Helpers::resolveRequest();
        $this->session = new SessionManager();
        $this->fv      = new FormValidator();

        $this->data['title'] = 'Accueil ' . $GLOBALS['siteName'];
        $this->data['urls']  = Router::getURLs();
    }

    public function redirect(string $location)
    {
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
}
