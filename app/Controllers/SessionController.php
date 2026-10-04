<?php
declare(strict_types=1);

namespace App\Controllers;

use GuzzleHttp\Psr7\ServerRequest;
use GuzzleHttp\Psr7\Response;
// use GuzzleHttp\Psr7\Utils;


class SessionController
{
    public function test(ServerRequest $request) : Response
    {
        $_SESSION['test'] = "Hello Session";

        $response = new Response(
            200,
            ['Content-Type' => 'text/plain'],
            'Session value: ' . $_SESSION['test']
        );
        
        return $response;
    }

    public function read(ServerRequest $request) : Response
    {
        $value = $_SESSION['test'] ?? 'Session does not exist';

        $response = new Response(
            200,
            ['Content-Type' => 'text/plain'],
            $value
        );
        
        return $response;
    }
}
?>
