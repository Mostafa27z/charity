<nav class="bg-blue-600 text-white px-6 py-3 flex justify-between items-center shadow">
    <a href="{{ route('user.dashboard.index') }}" class="font-bold text-lg flex items-center gap-2">
        <i class="fa-solid fa-hand-holding-heart"></i> نظام المساعدات
    </a>
    <ul class="flex space-x-6 space-x-reverse">
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
