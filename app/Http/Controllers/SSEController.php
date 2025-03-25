<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\StreamedResponse;

class SSEController extends Controller
{
    public function stream()
    {
        set_time_limit(0);
        $response = new StreamedResponse(function () {
            ob_implicit_flush();
            echo 'data: ' . json_encode(['message' => '1']) . "\n\n";
            ob_flush();
            flush();
            sleep(1);
        });
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');
        $response->headers->set('X-Accel-Buffering', 'no');

        return $response;
    }

}
