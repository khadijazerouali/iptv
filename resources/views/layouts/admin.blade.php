<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    @livewireStyles
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-3">
                @include('partials.admin-sidebar')
            </div>
            <div class="col-md-9">
                @yield('content')
            </div>
        </div>
    </div>
    @livewireScripts
</body>
</html> 