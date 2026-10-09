<?php
declare(strict_types=1);

namespace App\Controllers;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;

class ErrorController
{
    public function index():Response
    {
        ob_start();
        require_once("../app/Views/404.php");
        $content = ob_get_clean();

        $stream = Utils::streamFor($content);
        $response = new Response(404);
        $response = $response->withBody($stream);
        return $response;
    }
}
?>
