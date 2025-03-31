<?php

namespace App\Http\Controllers;

use Closure;
use Illuminate\Http\Request;
use App\Models\Historial;
use Symfony\Component\HttpFoundation\Response;


class LogHistorial extends Controller
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        $user = $request->user();
        $controllerMethod = $this->getControllerMethod($request);

        Historial::create([
            'user_id' => $user ? $user->id : null,
            'url' => $request->fullUrl(),
            'methodo' => $request->method(),
            'header' => $request->headers->all(),
            'func' => $controllerMethod,
            'body' => $request->all(),
        ]);
        
    }

    protected function getControllerMethod(Request $request): ?string
    {
        $route = $request->route();
        return $route?->getActionName() ?? null;
    }
}

