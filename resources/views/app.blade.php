<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @routes
        @viteReactRefresh
        @vite(['resources/js/app.tsx', "resources/js/pages/{$page['component']}.tsx"])
        @inertiaHead
        <div>Hello obada</div>
    </head>
    <body class="font-sans antialiased">
         <div class="actions" style="margin-bottom: 16px;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-danger">تسجيل الخروج</button>
            </form>
        </div>
        @inertia
    </body>
</html>
