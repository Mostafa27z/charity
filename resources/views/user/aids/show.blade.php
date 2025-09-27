@extends('layouts.user')
@section('title','عرض مساعدة')
@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">تفاصيل المساعدة</h1>

    <div class="bg-white shadow rounded p-4 mb-4">
        <h2 class="font-bold text-lg mb-2">بيانات المساعدة</h2>
        <p><strong>النوع:</strong> {{ $aid->aid_type }}</p>
        <p><strong>القيمة:</strong> {{ $aid->amount }}</p>
        <p><strong>التاريخ:</strong> {{ $aid->aid_date }}</p>
        <p><strong>الوصف:</strong> {{ $aid->description }}</p>
    </div>

    <div class="bg-white shadow rounded p-4">
        <h2 class="font-bold text-lg mb-2">بيانات المستفيد</h2>
        <p><strong>الاسم:</strong> {{ $aid->beneficiary->first_name }} {{ $aid->beneficiary->last_name }}</p>
        <p><strong>الرقم القومي:</strong> {{ $aid->beneficiary->national_id }}</p>
        <p><strong>الهاتف:</strong> {{ $aid->beneficiary->phone }}</p>
        <p><strong>العنوان:</strong> {{ $aid->beneficiary->address }}</p>
        <p><strong>عدد أفراد الأسرة:</strong> {{ $aid->beneficiary->family_size }}</p>
        <p><strong>الدخل:</strong> {{ $aid->beneficiary->income }}</p>
        <p><strong>ملاحظات:</strong> {{ $aid->beneficiary->notes }}</p>
    </div>

    <a href="{{ route('user.aids.index') }}" class="inline-block mt-4 bg-gray-500 text-white px-4 py-2 rounded">رجوع</a>
</div>
@endsection
