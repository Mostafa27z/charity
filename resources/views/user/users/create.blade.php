@extends('layouts.user')
@section('title', isset($user) ? 'تعديل مستخدم' : 'إضافة مستخدم')
@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">
        {{ isset($user) ? 'تعديل مستخدم' : 'إضافة مستخدم' }}
    </h1>

    <form method="POST" action="{{ isset($user) ? route('user.users.update',$user) : route('user.users.store') }}">
        @csrf
        @if(isset($user)) @method('PUT') @endif

        <div class="mb-4">
            <label class="block">الاسم</label>
            <input type="text" name="name" value="{{ old('name',$user->name ?? '') }}" class="border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label class="block">البريد الإلكتروني</label>
            <input type="email" name="email" value="{{ old('email',$user->email ?? '') }}" class="border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label class="block">الهاتف</label>
            <input type="text" name="phone" value="{{ old('phone',$user->phone ?? '') }}" class="border p-2 w-full">
        </div>

        <div class="mb-4">
            <label class="block">كلمة المرور {{ isset($user) ? '(اتركها فارغة لعدم التغيير)' : '' }}</label>
            <input type="password" name="password" class="border p-2 w-full" {{ isset($user)?'':'required' }}>
            <input type="password" name="password_confirmation" placeholder="تأكيد كلمة المرور" class="border p-2 w-full mt-2" {{ isset($user)?'':'required' }}>
        </div>

        <div class="mb-4">
            <label class="block">الدور</label>
            <select name="role" class="border p-2 w-full" required>
                <option value="user" {{ old('role',$user->role ?? '')=='user'?'selected':'' }}>مستخدم</option>
                <option value="moderator" {{ old('role',$user->role ?? '')=='moderator'?'selected':'' }}>مشرف</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block">الحالة</label>
            <select name="status" class="border p-2 w-full" required>
                <option value="active" {{ old('status',$user->status ?? '')=='active'?'selected':'' }}>نشط</option>
                <option value="inactive" {{ old('status',$user->status ?? '')=='inactive'?'selected':'' }}>غير نشط</option>
            </select>
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            {{ isset($user) ? 'تحديث' : 'حفظ' }}
        </button>
    </form>
</div>
@endsection
