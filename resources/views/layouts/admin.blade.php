<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite('resources/css/app.css')
</head>
<body class="bg-bg text-dark font-sans min-h-screen flex flex-col">

    {{-- Navbar --}}
    @include('partials.admin.navbar')

    <div class="flex flex-1">
        {{-- Sidebar --}}
        @include('partials.admin.sidebar')

        {{-- Main Content --}}
        <main class="flex-1 p-6 bg-bg">
            @yield('content')
        </main>
    </div>

    {{-- Footer --}}
    @include('partials.admin.footer')

</body>
</html>
