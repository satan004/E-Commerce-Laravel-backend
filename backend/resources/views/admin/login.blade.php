<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin Login - {{ config('app.name', 'Commerce') }}</title>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="admin-body auth-page">
        <main class="auth-panel">
            <p class="eyebrow">Blade admin</p>
            <h1>Commerce Admin</h1>
            <form method="POST" action="{{ route('admin.login.store') }}" class="stack">
                @csrf
                <label>
                    Email
                    <input type="email" name="email" value="{{ old('email', 'admin@example.com') }}" required autofocus>
                </label>
                <label>
                    Password
                    <input type="password" name="password" value="password" required>
                </label>
                <label class="check-row">
                    <input type="checkbox" name="remember" value="1">
                    Remember me
                </label>
                @error('email')
                    <p class="field-error">{{ $message }}</p>
                @enderror
                <button class="btn btn-primary full" type="submit">Login</button>
            </form>
        </main>
    </body>
</html>
