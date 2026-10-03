<?php
declare(strict_types=1);

namespace App\Controllers;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;


class FeedbackController
{
    public function index()
    {
        ob_start();

        requireFile("../app/Views/feedback.php");

        $content = ob_get_clean();

        $stream = Utils::streamFor($content);

        $response = new Response;

        $response = $response->withBody($stream);
        
        return $response;
    }

    public function feedback()
    {
        ob_start();

        requireFile("../app/Models/provide_feedback.php");

        $content = ob_get_clean();

        $stream = Utils::streamFor($content);

        $response = new Response;

        $response = $response->withBody($stream);
        
        return $response;
    }
}
?>
