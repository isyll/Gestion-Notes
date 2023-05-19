<?php

namespace Core;

class Controller
{
    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function render(string $file, array $data = [], bool $extendLayout = true) : string
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

    public static function getBaseURL() : string
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $url = 'https';
        else
            $url = 'http';

        $url .= "://{$_SERVER['HTTP_HOST']}";
        return $url;
    }
}