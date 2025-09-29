<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Charity Platform') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-tight text-gray-800">

    <!-- ✅ Navbar -->
    <nav class="bg-primary text-white px-6 py-4 shadow">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-xl font-bold hover:text-secondary transition">
                {{ config('app.name', 'منصة الخير') }}
            </a>

            <div class="flex space-x-4 space-x-reverse">
                @guest
                    <a href="{{ route('login') }}" class="hover:text-secondary transition">تسجيل الدخول</a>
                    {{-- <a href="{{ route('register') }}" class="hover:text-secondary transition">إنشاء حساب</a> --}}
                @else
                    <span class="font-medium">مرحباً، {{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-secondary transition">تسجيل الخروج</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- ✅ Main Content -->
    <main class="container mx-auto px-4 py-6 min-h-[calc(100vh-120px)]">
        @yield('content')
    </main>

    <!-- ✅ Footer -->
    <footer class="bg-primary text-white py-4 shadow-inner">
        <div class="container mx-auto text-center">
            <p class="text-sm">&copy; {{ date('Y') }} {{ config('app.name', 'Charity Platform') }}. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

</body>
</html>
