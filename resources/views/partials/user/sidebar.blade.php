<aside class="bg-blue-700 text-white w-64 min-h-screen p-5 shadow-md">
    <nav class="space-y-4">
        <a href="{{ route('user.dashboard.index') }}"
           class="block hover:text-yellow-300 transition">لوحة التحكم</a>

        <a href="{{ route('user.aids.index') }}"
           class="block hover:text-yellow-300 transition">المساعدات</a>

        <a href="{{ route('user.beneficiaries.index') }}"
           class="block hover:text-yellow-300 transition">المستفيدون</a>

        {{-- ✅ يظهر فقط للمشرفين --}}
        @if(auth()->user()->role === 'moderator')
            <a href="{{ route('user.users.index') }}"
               class="block hover:text-yellow-300 transition">إدارة المستخدمين</a>
        @endif
    </nav>
</aside>
