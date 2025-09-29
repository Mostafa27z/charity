<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - @yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite('resources/css/app.css')
    <style>
        /* Sidebar toggle animations */
        .user-sidebar {
            transition: transform 0.3s ease-in-out;
        }
        
        @media (max-width: 1024px) {
            .user-sidebar {
                transform: translateX(100%);
            }
            .user-sidebar.active {
                transform: translateX(0);
            }
        }

        /* Overlay for mobile sidebar */
        .user-sidebar-overlay {
            transition: opacity 0.3s ease-in-out;
        }

        /* Prevent body scroll when sidebar is open on mobile */
        body.sidebar-open {
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 font-sans min-h-screen flex flex-col">

    {{-- Navbar --}}
    @include('partials.user.navbar')

    <div class="flex flex-1 relative">
        {{-- Mobile Sidebar Overlay --}}
        <div id="userSidebarOverlay" class="user-sidebar-overlay fixed inset-0 bg-black opacity-50 z-40 hidden lg:hidden"></div>

        {{-- Sidebar --}}
        <aside id="userSidebar" class="user-sidebar fixed lg:sticky top-0 right-0 h-full w-64 lg:w-64 bg-white shadow-lg z-50 lg:z-auto lg:h-screen overflow-y-auto">
            @include('partials.user.sidebar')
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 w-full lg:w-auto p-4 md:p-6 bg-gray-50 overflow-x-hidden min-h-screen">
            {{-- Mobile Menu Button --}}
            <button id="userMobileMenuBtn" class="lg:hidden fixed bottom-6 left-6 bg-blue-600 text-white w-14 h-14 rounded-full shadow-lg z-30 flex items-center justify-center hover:bg-blue-700 transition-all hover:scale-110">
                <i class="fas fa-bars text-xl"></i>
            </button>

            @yield('content')
        </main>
    </div>

    {{-- Footer --}}
    @include('partials.user.footer')

    <script>
        // Mobile Sidebar Toggle for User Layout
        const userSidebar = document.getElementById('userSidebar');
        const userOverlay = document.getElementById('userSidebarOverlay');
        const userMenuBtn = document.getElementById('userMobileMenuBtn');

        function toggleUserSidebar() {
            userSidebar.classList.toggle('active');
            userOverlay.classList.toggle('hidden');
            document.body.classList.toggle('sidebar-open');
        }

        userMenuBtn?.addEventListener('click', toggleUserSidebar);
        userOverlay?.addEventListener('click', toggleUserSidebar);

        // Close sidebar when clicking on sidebar links (mobile only)
        if (window.innerWidth < 1024) {
            const sidebarLinks = userSidebar?.querySelectorAll('a');
            sidebarLinks?.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 1024) {
                        toggleUserSidebar();
                    }
                });
            });
        }

        // Close sidebar on window resize to desktop
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                userSidebar.classList.remove('active');
                userOverlay.classList.add('hidden');
                document.body.classList.remove('sidebar-open');
            }
        });

        // Handle orientation change on mobile devices
        window.addEventListener('orientationchange', () => {
            if (window.innerWidth >= 1024) {
                userSidebar.classList.remove('active');
                userOverlay.classList.add('hidden');
                document.body.classList.remove('sidebar-open');
            }
        });
    </script>
</body>
</html>