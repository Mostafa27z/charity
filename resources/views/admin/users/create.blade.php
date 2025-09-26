@extends('layouts.admin')
@section('title','إضافة مستخدم')

@section('content')
<div class="container mx-auto" dir="rtl">
    <h1 class="text-2xl font-bold mb-6">➕ إضافة مستخدم</h1>

    <form method="POST" action="{{ route('admin.users.store') }}" class="grid grid-cols-2 gap-4 bg-white p-6 rounded shadow">
        @csrf
        <x-input name="name" label="الاسم" required/>
        <x-input name="email" label="البريد الإلكتروني" type="email" required/>
        <x-input name="phone" label="الهاتف"/>
        <x-input name="password" label="كلمة المرور" type="password" required/>
        <x-select name="association_id" label="الجمعية" :options="$associations->pluck('name','id')" required/>
        <x-select name="role" label="الدور" :options="['admin'=>'مدير','moderator'=>'مشرف','user'=>'مستخدم']" required/>
        <x-select name="status" label="الحالة" :options="['active'=>'نشط','inactive'=>'غير نشط']" required/>
        <button type="submit" class="col-span-2 mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            حفظ
        </button>
    </form>
</div>
@endsection
