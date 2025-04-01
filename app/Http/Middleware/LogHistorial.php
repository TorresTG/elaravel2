<?php

namespace App\Http\Middleware;

use App\Models\Historial;
use Closure;
use Illuminate\Http\Request;

class LogHistorial
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (auth()->check()) {
            $route = $request->route();
            $user = auth()->user();

            $controllerMethod = '';
            if ($route && $route->getAction() && isset($route->getAction()['controller'])) {
                $controllerParts = explode('@', $route->getAction()['controller']);
                $controllerMethod = end($controllerParts);
            }

            Historial::create([
                'user_id' => $user->id,
                'user_name' => $user->email, // Nuevo campo
                'url' => $request->fullUrl(),
                'methodo' => $request->method(),
                'func' => $controllerMethod,
                // Eliminados: header y body según tu requerimiento
            ]);
        }

        return $response;
    }
}
