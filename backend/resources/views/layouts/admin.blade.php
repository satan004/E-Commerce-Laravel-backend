<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Admin') - {{ config('app.name', 'Commerce') }}</title>
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="admin-body">
        <div class="admin-shell">
            <aside class="admin-sidebar">
                <a class="admin-brand" href="{{ route('admin.dashboard') }}">Commerce Admin</a>
                <nav class="admin-nav">
                    <a href="{{ route('admin.dashboard') }}" @class(['active' => request()->routeIs('admin.dashboard')])>Dashboard</a>
                    <a href="{{ route('admin.categories.index') }}" @class(['active' => request()->routeIs('admin.categories.*')])>Categories</a>
                    <a href="{{ route('admin.products.index') }}" @class(['active' => request()->routeIs('admin.products.*')])>Products</a>
                    <a href="{{ route('admin.orders.index') }}" @class(['active' => request()->routeIs('admin.orders.*')])>Orders</a>
                    <a href="{{ route('admin.users.index') }}" @class(['active' => request()->routeIs('admin.users.*')])>Users</a>
                </nav>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="btn btn-muted full" type="submit">Logout</button>
                </form>
            </aside>

            <main class="admin-main">
                <header class="admin-topbar">
                    <div>
                        <p class="eyebrow">Admin panel</p>
                        <h1>@yield('title', 'Dashboard')</h1>
                    </div>
                    <a class="btn btn-muted" href="{{ route('store') }}">Storefront</a>
                </header>

                @if (session('status'))
                    <div class="notice">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="notice danger">
                        <strong>Please check the form.</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </body>
</html>
