<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class CookieToJwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Obtener el token JWT de la cookie
        $token = $request->cookie('token_seguro');

        // Verificar si el token no existe
        if (!$token) {
            return response()->json(['error' => 'Token no proporcionado'], 401);
        }

        try {
            // Autenticar al usuario utilizando el token
            $user = JWTAuth::setToken($token)->authenticate();

            // Si la autenticación es exitosa, puedes establecer al usuario en la solicitud
            if ($user) {
                $request->auth = $user; // Guarda el usuario autenticado en la solicitud
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token no válido'], 401);
        }

        return $next($request);
    }

}
