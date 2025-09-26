<aside class="bg-primary text-white w-64 min-h-screen p-5 shadow-md">
    <nav class="space-y-4">
        <a href="{{ route('admin.dashboard') }}" class="block hover:text-secondary transition">لوحة التحكم</a>
        <a href="{{ route('admin.associations.index') }}" class="block hover:text-secondary transition">الجمعيات</a>
        <a href="{{ route('admin.beneficiaries.index') }}" class="block hover:text-secondary transition">المستفيدون</a>
        <a href="{{ route('admin.aids.index') }}" class="block hover:text-secondary transition">المساعدات</a>
        <a href="{{ route('admin.users.index') }}" class="block hover:text-secondary transition">المستخدمون</a>
    </nav>
</aside>
