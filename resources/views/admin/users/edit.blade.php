@extends('layouts.admin')
@section('title','تعديل مستخدم')

@section('content')
<div class="container mx-auto" dir="rtl">
    <h1 class="text-2xl font-bold mb-6">✏️ تعديل مستخدم</h1>

    <form method="POST" action="{{ route('admin.users.update',$user) }}" class="grid grid-cols-2 gap-4 bg-white p-6 rounded shadow">
        @csrf @method('PUT')
        <x-input name="name" label="الاسم" value="{{ $user->name }}" required/>
        <x-input name="email" label="البريد الإلكتروني" type="email" value="{{ $user->email }}" required/>
        <x-input name="phone" label="الهاتف" value="{{ $user->phone }}"/>
        <x-input name="password" label="كلمة المرور (اتركه فارغاً للإبقاء عليه)" type="password"/>
        <x-select name="association_id" label="الجمعية" :options="$associations->pluck('name','id')" selected="{{ $user->association_id }}" required/>
        <x-select name="role" label="الدور" :options="['admin'=>'مدير','moderator'=>'مشرف','user'=>'مستخدم']" selected="{{ $user->role }}" required/>
        <x-select name="status" label="الحالة" :options="['active'=>'نشط','inactive'=>'غير نشط']" selected="{{ $user->status }}" required/>
        <button type="submit" class="col-span-2 mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            تحديث
        </button>
    </form>
</div>
@endsection
