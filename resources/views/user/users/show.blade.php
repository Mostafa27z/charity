@extends('layouts.user')
@section('title','بيانات المستخدم')
@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">بيانات المستخدم</h1>

    <div class="bg-white p-4 rounded shadow">
        <p><strong>الاسم:</strong> {{ $user->name }}</p>
        <p><strong>البريد:</strong> {{ $user->email }}</p>
        <p><strong>الهاتف:</strong> {{ $user->phone }}</p>
        <p><strong>الدور:</strong> {{ $user->role === 'moderator' ? 'مشرف' : 'مستخدم' }}</p>
        <p><strong>الحالة:</strong> {{ $user->status === 'active' ? 'نشط' : 'غير نشط' }}</p>
    </div>

    <a href="{{ route('user.users.index') }}" class="mt-4 inline-block text-blue-600">⬅ العودة للقائمة</a>
</div>
@endsection
