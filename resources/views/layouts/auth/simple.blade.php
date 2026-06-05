<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Admin Login' }} — Bellara</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bellara-body auth-page">
    <div class="auth-page-wrap">
        <div class="auth-card reveal">
            <div class="auth-brand">
                <a href="{{ route('home') }}" style="text-decoration:none;color:inherit;">
                    <p class="brand-script" style="text-align:center;">Bellara</p>
                    <p class="brand-subtitle" style="text-align:center;margin:0.2rem 0 0;">Beauty &amp; Spa Lounge</p>
                </a>
                <span class="auth-portal-badge">Admin Portal</span>
            </div>
            {{ $slot }}
            <p class="auth-ngome">Powered by <span class="ngome-highlight">Ngome Technologies</span></p>
        </div>
    </div>
    @fluxScripts
</body>
</html>
