<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - @yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900 font-sans min-h-screen flex flex-col">

    {{-- ✅ Navbar --}}
    @include('partials.user.navbar')

    <div class="flex flex-1">
        {{-- ✅ Sidebar --}}
        @include('partials.user.sidebar')

        {{-- ✅ Main Content --}}
        <main class="flex-1 p-6 bg-gray-50">
            @yield('content')
        </main>
    </div>

    {{-- ✅ Footer --}}
    @include('partials.user.footer')

</body>
</html>
