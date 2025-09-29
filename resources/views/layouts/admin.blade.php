<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite('resources/css/app.css')
    <style>
        /* Sidebar toggle animations */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
        }

        /* Overlay for mobile sidebar */
        .sidebar-overlay {
            transition: opacity 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-bg text-dark font-sans min-h-screen flex flex-col">

    {{-- Navbar --}}
    @include('partials.admin.navbar')

    <div class="flex flex-1 relative">
        {{-- Mobile Sidebar Overlay --}}
        <div id="sidebarOverlay" class="sidebar-overlay fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

        {{-- Sidebar --}}
        <aside id="sidebar" class="sidebar fixed lg:sticky top-0 right-0 h-full w-64 lg:w-64 bg-white shadow-lg z-50 lg:z-auto lg:h-screen overflow-y-auto">
            @include('partials.admin.sidebar')
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 w-full lg:w-auto p-4 md:p-6 bg-bg overflow-x-hidden">
            {{-- Mobile Menu Button --}}
            <button id="mobileMenuBtn" class="lg:hidden fixed bottom-6 left-6 bg-primary text-white w-14 h-14 rounded-full shadow-lg z-30 flex items-center justify-center hover:bg-primary-dark transition">
                <i class="fas fa-bars text-xl"></i>
            </button>

            @yield('content')
        </main>
    </div>

    {{-- Footer --}}
    @include('partials.admin.footer')

    <script>
        // Mobile Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const menuBtn = document.getElementById('mobileMenuBtn');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

        menuBtn?.addEventListener('click', toggleSidebar);
        overlay?.addEventListener('click', toggleSidebar);

        // Close sidebar on window resize to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('active');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        });
    </script>
</body>
</html>