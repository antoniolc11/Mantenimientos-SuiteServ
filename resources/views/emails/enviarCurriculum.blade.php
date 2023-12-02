<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitación a Completar Registro</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f3f4f6;
            padding: 1rem;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 1rem;
            border-radius: 8px;
            color: #000000;
            background-color: #b6c5d4;
        }

        .greeting {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .message {
            font-size: 14px;
            margin-bottom: 12px;
        }

        .cta-button {
            display: inline-block;
            margin-top: 12px;
            padding: 10px 20px;
            background-color: #000000;
            color: #fdfdfd;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .cta-button:hover {
            background-color: #414547;
        }

        .signature {
            margin-top: 16px;
            font-size: 12px;
            color: #555555;
        }
    </style>
</head>

<body>
    <div class="container">
        <p class="greeting">Hola
            {{ $aspirante->nombre . ' ' . $aspirante->primer_apellido . ' ' . $aspirante->segundo_apellido }}</p>

        <p class="message">Esperamos que reciba este mensaje correctamente. En SuiteServ Solutions, estamos emocionados
            de
            saber más sobre ti y tu interés en unirte a nuestro equipo.</p>

        <p class="message">Para continuar con el proceso de registro, por favor, adjunta tu currículum vitae haciendo
            clic en el siguiente botón:</p>

        <a href="{{ route('formulario.curriculum', $aspirante) }}" class="cta-button" style="color: #fdfdfd;">Subir Curriculum</a>

        <p class="message">Si tienes alguna pregunta o necesitas asistencia durante el proceso, no dudes en
            contactarnos.</p>

        <p class="message">¡Esperamos con ansias conocer más sobre ti y tu potencial contribución a nuestro equipo!</p>

        <p class="message">Saludos cordiales,</p>
        <p class="signature">Antonio Fernando Román Fernández<br>Mantenimientos SuiteServ Solutions</p>
    </div>
</body>

</html>
