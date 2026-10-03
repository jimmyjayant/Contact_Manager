<?php
declare(strict_types=1);

namespace App\Controllers;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;


class ShowController
{
    public function index()
    {
        ob_start();

        requireFile("../app/Views/show.php");

        $content = ob_get_clean();

        $stream = Utils::streamFor($content);

        $response = new Response;

        $response = $response->withBody($stream);
        
        return $response;
    }

    public function show()
    {
        ob_start();

        requireFile("../app/Models/get_user_contacts.php");

        $content = ob_get_clean();

        $stream = Utils::streamFor($content);

        $response = new Response;

        $response = $response->withBody($stream);
        
        return $response;
    }
}
?>
