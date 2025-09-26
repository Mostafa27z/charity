@extends('layouts.admin')
@section('title','تفاصيل المستخدم')

@section('content')
<div class="container mx-auto" dir="rtl">
    <h1 class="text-2xl font-bold mb-6">👤 تفاصيل المستخدم</h1>

    <div class="bg-white p-6 shadow rounded">
        <p><strong>الاسم:</strong> {{ $user->name }}</p>
        <p><strong>البريد:</strong> {{ $user->email }}</p>
        <p><strong>الهاتف:</strong> {{ $user->phone ?? '—' }}</p>
        <p><strong>الجمعية:</strong> {{ $user->association?->name ?? '—' }}</p>
        <p><strong>الدور:</strong>
            @if($user->role=='admin') مدير
            @elseif($user->role=='moderator') مشرف
            @else مستخدم
            @endif
        </p>
        <p><strong>الحالة:</strong> {{ $user->status=='active'?'نشط':'غير نشط' }}</p>
    </div>

    <div class="mt-4 flex gap-3">
        <a href="{{ route('admin.users.edit',$user) }}"
           class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">تعديل</a>
        <a href="{{ route('admin.users.index') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">رجوع</a>
    </div>
</div>
@endsection
