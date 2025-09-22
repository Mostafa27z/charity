@extends('layouts.admin')
@section('title','إضافة جمعية')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4 flex items-center gap-2">
        <i class="fa fa-plus text-primary"></i> إضافة جمعية جديدة
    </h1>

    <form action="{{ route('admin.associations.store') }}" method="POST" class="space-y-4">
        @csrf
        <x-input name="name" label="اسم الجمعية" required/>
        <x-input name="registration_number" label="رقم التسجيل"/>
        <x-input name="address" label="العنوان"/>
        <x-input name="phone" label="الهاتف"/>
        <x-input type="email" name="email" label="البريد الإلكتروني" required/>

        <div>
            <label class="block mb-1">الحالة</label>
            <select name="status" class="w-full border rounded p-2">
                <option value="active">نشطة</option>
                <option value="inactive">غير نشطة</option>
            </select>
        </div>

        <button class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            حفظ <i class="fa fa-save"></i>
        </button>
    </form>
</div>
@endsection
