<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Paróquia Digital') }}</title>
    <link rel="icon" type="image/jpeg" href="/images/sao-sebastiao.jpeg">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background: #0f1f35;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url('/images/igreja-001.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.20;
            z-index: 0;
            pointer-events: none;
        }

        .login-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 40px 36px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            margin: 24px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-header img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #d4af37;
            margin: 0 auto 12px;
            display: block;
        }

        .login-header h1 {
            font-size: 22px;
            font-weight: 700;
            color: #1a3a5c;
            margin-bottom: 4px;
        }

        .login-header p {
            font-size: 13px;
            color: #64748b;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="login-header">
            <img src="/images/sao-sebastiao.jpeg" alt="São Sebastião">
            <h1>Paróquia Digital</h1>
            <p>Gestão Paroquial</p>
        </div>
        {{ $slot }}
    </div>
</body>

</html>