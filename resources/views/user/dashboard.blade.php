@extends('layouts.user')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">لوحة التحكم</h1>

    <div class="grid grid-cols-2 gap-4 mb-10">
        <div class="bg-white rounded-lg p-4 shadow">
            <p class="font-semibold">عدد المستفيدين</p>
            <h2 class="text-xl">{{ $stats['beneficiaries_count'] }}</h2>
        </div>
        <div class="bg-white rounded-lg p-4 shadow">
            <p class="font-semibold">عدد المساعدات</p>
            <h2 class="text-xl">{{ $stats['aids_count'] }}</h2>
        </div>
        <div class="bg-white rounded-lg p-4 shadow">
            <p class="font-semibold">عدد المستخدمين</p>
            <h2 class="text-xl">{{ $stats['users_count'] }}</h2>
        </div>
        <div class="bg-white rounded-lg p-4 shadow">
            <p class="font-semibold">إجمالي قيمة المساعدات</p>
            <h2 class="text-xl">{{ number_format($stats['total_aid_amount'], 2) }}</h2>
        </div>
    </div>

    <h2 class="text-xl font-bold mb-4">إضافة مستخدم جديد للجمعية</h2>

    <form method="POST" action="{{ route('user.dashboard.add-user') }}" class="space-y-4 max-w-md">
        @csrf
        <div>
            <label class="block mb-1">الاسم</label>
            <input type="text" name="name" class="border rounded w-full p-2" required>
        </div>

        <div>
            <label class="block mb-1">البريد الإلكتروني</label>
            <input type="email" name="email" class="border rounded w-full p-2" required>
        </div>

        <div>
            <label class="block mb-1">كلمة المرور</label>
            <input type="password" name="password" class="border rounded w-full p-2" required>
        </div>

        <div>
            <label class="block mb-1">تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" class="border rounded w-full p-2" required>
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            إضافة المستخدم
        </button>
    </form>
</div>
@endsection
