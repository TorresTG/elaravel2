<?php

namespace App\Http\Controllers;

use App\Jobs\ExpireActivationCode;
use App\Mail\digitActivationMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use App\Mail\AccountActivationMail;
use App\Mail\AdminNotificationMail;
use Illuminate\Support\Facades\Validator;
use Log;
use Illuminate\Http\Request as HttpRequest;
use RateLimiter;

class AuthController extends Controller
{


    public function register_sanctum(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Los datos proporcionados son inválidos.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Generación mejorada de código único
        $codemail = null;
        $attempts = 0;

        do {
            $codemail = mt_rand(100000, 999999);
            $attempts++;

            if ($attempts > 100) { // Límite más generoso
                return response()->json([
                    'message' => 'No se pudo generar un código único'
                ], 500);
            }

        } while (User::where('codemail', $codemail)->exists());

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 1,
                'is_active' => false,
                'is_inactive' => true,
                'codemail' => $codemail,
                'profile_picture' => "https://ui-avatars.com/api/?name=" . urlencode($request->name) . "&color=7F9CF5&background=EBF4FF",
                'activation_token' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear el usuario: ' . $e->getMessage()
            ], 500);
        }

        // Verificación inmediata
        $freshUser = User::find($user->id);

        if (!$freshUser || !$freshUser->codemail) {
            return response()->json([
                'message' => 'Error crítico: El código no se guardó correctamente'
            ], 500);
        }

        $signedRoute = URL::temporarySignedRoute(
            'user.activate',  // Nombre de la nueva ruta
            now()->addMinutes(5),
            ['user' => $user->id]  // Pasamos el ID del usuario
        );
        Mail::to($request->email)->send(new digitActivationMail($codemail, $signedRoute));


        return response()->json([
            'success' => true,
            'message' => 'Procesando usuario. Por favor, revisa tu correo para activar la cuenta.'
        ], 201);
    }

    public function redireccionActivate(User $user)
    {
        return view('auth.verify', [
            'user' => $user,
            'signedParams' => request()->query()
        ]);
    }



    public function digitAA(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|digits:6',
            'user_id' => 'required|exists:users,id',
            'signature' => 'required',
            'expires' => 'required'
        ]);

        // Reconstruir la URL firmada original
        $url = url('/activate/' . $validated['user_id']) . '?' . http_build_query([
            'expires' => $validated['expires'],
            'signature' => $validated['signature']
        ]);

        // Crear una solicitud falsa para validar la firma
        $fakeRequest = HttpRequest::create($url);

        if (!URL::hasValidSignature($fakeRequest)) {
            return back()->with('error', 'Enlace inválido o expirado');
        }

        $user = User::findOrFail($request->user_id);

        if ($user->codemail != $request->code) {
            return back()->with('error', 'Código de activación incorrecto');
        }

        // Actualizar usuario
        $user->update([
            'is_active' => true,
            'role_id' => 2,
            'codemail' => null
        ]);

        return redirect()->away('http://localhost:4200/activation-success?status=success');
    }

    public function digitActivateAcount($code): JsonResponse
    {
        // Validar que el código sea numérico
        if (!ctype_digit($code)) {
            return response()->json(['error' => 'Código de activación inválido'], 400);
        }

        // Buscar usuario por código
        $user = User::where('codemail', $code)->first();

        if (!$user) {
            return response()->json(['error' => 'Código de activación no encontrado'], 404);
        }

        // Actualizar usuario
        $user->update([
            'is_active' => true,
            'role_id' => 2,
            'codemail' => null
        ]);


        return response()->json(['message' => 'Cuenta activada exitosamente'], 200);
    }

    //$activationLink = URL::temporarySignedRoute('user.activate', now()->addMinutes(5), ['user' => $user->id]);
    //Mail::to($request->email)->send(new AccountActivationMail($activationLink));


    public function login_sanctum(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Los datos proporcionados son inválidos.'], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }

        if (!$user->is_active) {
            return response()->json(['error' => 'Cuenta no activada. Por favor, revisa tu correo para activarla.'], 403);
        }

        $token = $user->createToken("Mi_dispositivo")->plainTextToken;

        return response()->json(['user' => $user, 'token' => $token], 201);
    }
    public function me()
    {
        return response()->json(['success' => true, 'user' => auth()->user()]);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Saliendo...'], 200);
    }


    public function activateAccount(Request $request)
    {
        $user = User::find($request->user);

        if ($user->is_active) {
            return response()->json(['message' => 'La cuenta ya está activada.'], 400);
        }

        $admin = User::where('role_id', 3)->first();

        if ($admin) {
            Mail::to($admin->email)->send(new AdminNotificationMail($user));
        }

        $user->is_active = true;
        $user->role_id = 2;
        $user->save();

        return response()->json(['message' => 'La cuenta ha sido activada.'], 200);
    }



    /*
    public function resendActivationCode(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Email inválido'], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        if ($user->is_active) {
            return response()->json(['error' => 'La cuenta ya está activada'], 400);
        }

        // Genera y guarda el nuevo código
        do {
            $code = random_int(100000, 999999);
        } while (User::where('codemail', $code)->exists()); // ✅ Usa User::where()

        $user->codemail = $code;
        $user->save();

        Mail::to($request->email)->send(new digitActivationMail($user->codemail));

        return response()->json(['message' => 'Nuevo código enviado al correo'], 200);
    }*/

    public function resendActivationCode(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Email inválido'], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        if ($user->is_active) {
            return response()->json(['error' => 'La cuenta ya está activada'], 400);
        }

        // Configuración de rate limiting
        $maxAttempts = 3;
        $decaySeconds = 60; // Bloqueo por 1 minuto
        $limiterKey = 'resend_code:' . $user->email;

        // Verificar límite de intentos
        if (RateLimiter::tooManyAttempts($limiterKey, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($limiterKey);
            return response()->json([
                'error' => 'Demasiados intentos. Intente nuevamente en ' . $seconds . ' segundos.'
            ], 429);
        }

        // Registrar intento
        RateLimiter::hit($limiterKey, $decaySeconds);

        // Generar nuevo código con protección contra bucles infinitos
        $attempts = 0;
        do {
            $code = random_int(100000, 999999);
            $attempts++;

            if ($attempts > 100) {
                RateLimiter::clear($limiterKey); // Limpiar rate limiter en caso de error
                return response()->json([
                    'error' => 'No se pudo generar un código único. Intente nuevamente.'
                ], 500); 
            }
        } while (User::where('codemail', $code)->exists());

        // Actualizar y enviar código
        try {
            $user->codemail = $code;
            $user->save();

            Mail::to($user->email)->send(new digitActivationMail(
                $code,
                URL::temporarySignedRoute(
                    'user.activate',
                    now()->addMinutes(5),
                    ['user' => $user->id]
                )
            ));
        } catch (\Exception $e) {
            RateLimiter::clear($limiterKey);
            return response()->json([
                'error' => 'Error al enviar el código. Intente nuevamente.'
            ], 500);
        }

        return response()->json(['message' => 'Nuevo código enviado al correo'], 200);
    }

    public function resendActivationLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Los datos proporcionados son inválidos.'], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'El usuario no existe.'], 404);
        }

        if ($user->is_active) {
            return response()->json(['message' => 'La cuenta ya está activada.'], 400);
        }

        $activationLink = URL::temporarySignedRoute('user.activate', now()->addMinutes(5), ['user' => $user->id]);
        Mail::to($request->email)->send(new AccountActivationMail($activationLink));

        return response()->json(['message' => 'Se ha enviado un nuevo enlace de activación a tu correo electrónico.'], 200);
    }


}
