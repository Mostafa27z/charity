@extends('layouts.app')

@section('content')
<div class="w-1/3 mx-auto mt-12 bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">تسجيل الدخول</h2>

    {{-- ✅ رسائل عامة (نجاح/خروج) --}}
    @if(session('status'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-700">
            {{ session('status') }}
        </div>
    @endif

    {{-- ✅ عرض الأخطاء (Validation / Login Error) --}}
    @if($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-700">
            <ul class="list-disc ps-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="block mb-1">البريد الإلكتروني</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="w-full border rounded p-2 @error('email') border-red-500 @enderror"
                required autofocus
            >
        </div>

        <div class="mb-3">
            <label class="block mb-1">كلمة المرور</label>
            <input
                type="password"
                name="password"
                class="w-full border rounded p-2 @error('password') border-red-500 @enderror"
                required
            >
        </div>

        <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">
            دخول
        </button>
    </form>
</div>
@endsection
