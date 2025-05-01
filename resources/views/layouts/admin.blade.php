<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartSpace 管理後台</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- 自定 CSS --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">


    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">SmartSpace 管理後台</span>
        </div>
    </nav>

    <main class="container-fluid py-4">
        @yield('content')
    </main>

    {{-- Bootstrap & JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- 自定 JS --}}
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    
    @yield('scripts')
</body>
</html>
