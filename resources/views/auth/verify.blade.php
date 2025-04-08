<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Email</title>
    <style>
        .verification-container {}

        .dynamic-form {
            max-width: 500px;
            margin: 2rem auto;
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dynamic-form .form-field {
            margin-bottom: 1rem;
        }

        .dynamic-form label {
            display: block;
            margin-bottom: 0.5rem;
            color: #0066cc;
            font-weight: 500;
        }

        .dynamic-form input,
        .dynamic-form select,
        .dynamic-form textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #cccccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        .dynamic-form input:focus,
        .dynamic-form select:focus,
        .dynamic-form textarea:focus {
            outline: none;
            border-color: #0066cc;
            box-shadow: 0 0 0 2px rgba(0, 102, 204, 0.2);
        }

        .dynamic-form .error-messages {
            color: #ff4d4d;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .dynamic-form button[type="submit"] {
            width: 100%;
            padding: 0.75rem;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .dynamic-form button[type="submit"]:hover {
            background-color: #003366;
        }

        .dynamic-form button[type="submit"]:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .verification-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 80px);
            background-color: #f4f6f9;
        }

        .verification-card {
            background-color: white;
            width: 100%;
            max-width: 500px;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .verification-card .title {
            color: #0066cc;
            margin-bottom: 1rem;
        }

        .verification-card .instructions {
            color: #333;
            margin-bottom: 1.5rem;
        }

        .code-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .input-group {
            margin-bottom: 1.5rem;
            width: 100%;
        }

        .code-input {
            width: 100%;
            text-align: center;
            font-size: 2rem;
            letter-spacing: 10px;
            padding: 0.75rem;
            border: 1px solid #cccccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        .code-input:focus {
            outline: none;
            border-color: #0066cc;
            box-shadow: 0 0 0 2px rgba(0, 102, 204, 0.2);
        }

        .verify-button {
            width: 100%;
            padding: 0.75rem;
            background-color: #0066cc;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .verify-button:hover {
            background-color: #003366;
        }

        .resend-container {
            margin-top: 1rem;
        }

        .resend-link {
            color: #0066cc;
            cursor: pointer;
            text-decoration: underline;
            transition: color 0.3s ease;
        }

        .resend-link:hover {
            color: #003366;
        }

        .error-message {
            color: #ff4d4d;
            margin-top: 1rem;
        }

        .success-message {
            color: #28a745;
            margin-top: 1rem;
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {

            .dynamic-form,
            .verification-card {
                margin: 1rem;
                padding: 1.5rem;
            }
        }

        /* Copia todos los estilos del ejemplo Angular */
    </style>
</head>

<body>
    <div class="verification-container">
        <div class="verification-card">
            <h2 class="title">Verificación de Email</h2>
            <p class="instructions">Ingresa el código de 6 dígitos enviado a<br>
                <strong>tuCorreoElec@mail.com</strong>
            </p>

            <form class="code-container" method="POST" action="{{ route('user.digitAA', request()->query()) }}">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <div class="input-group">
                    <input name="code" type="text" inputmode="numeric" pattern="[0-9]*" maxlength="6" class="code-input"
                        required autofocus>
                </div>

                <button type="submit" class="verify-button">Confirmar Código</button>
            </form>

            <div class="resend-container">
                <form method="POST" action="{{ route('resend-activation-code') }}">
                    @csrf
                    <!-- Añadir campo oculto con el email del usuario -->
                    <input type="hidden" name="email" value="{{ $user->email }}">

                    <p>¿No recibiste el código?
                        <button type="submit" class="resend-link">Reenviar código</button>
                    </p>
                </form>
            </div>

            @if(session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
</body>

</html>