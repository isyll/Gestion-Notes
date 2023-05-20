<?php

namespace Core;

class Controller
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function render(string $file, array $data = [], bool $extendLayout = true): string
    {
        if (!empty($data) && !array_is_list($data))
            extract($data);

        ob_start();
        require_once "{$GLOBALS['viewsPath']}/$file.html.php";
        $content = ob_get_clean();

        if ($extendLayout) {
            ob_start();
            require_once "{$GLOBALS['viewsPath']}/layout.html.php";
            return ob_get_clean();
        }

        return $content;
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
