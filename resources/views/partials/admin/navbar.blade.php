<nav class="bg-primary text-white px-6 py-3 flex justify-between items-center shadow">
    <a href="{{ route('admin.dashboard') }}" class="font-bold text-lg">
        منصة الجمعيات الخيرية
    </a>
    <ul class="flex space-x-6">
        <li>
           <form action="{{ route('logout') }}" method="POST" class="inline">
    @csrf
    <button type="submit" class="hover:text-yellow-300">
        <i class="fa-solid fa-right-from-bracket"></i> خروج
    </button>
</form>

        </li>
    </ul>
</nav>
