@extends('layouts.user')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">إضافة مساعدة</h1>

    <form method="POST" action="{{ route('user.aids.store') }}">
        @csrf
        <div class="mb-4">
            <label class="block">المستفيد</label>
            <select name="beneficiary_id" class="border p-2 w-full">
                @foreach($beneficiaries as $b)
                    <option value="{{ $b->id }}">{{ $b->first_name }} {{ $b->last_name }}</option>
                @endforeach
            </select>
        </div>

       <div class="mb-4">
    <label class="block">نوع المساعدة</label>
    <select name="aid_type" class="border p-2 w-full" required>
        <option value="">-- اختر النوع --</option>
        <option value="financial">مالية</option>
        <option value="food">غذائية</option>
        <option value="medical">طبية</option>
        <option value="education">تعليمية</option>
        <option value="clothing">ملابس</option>
        <option value="other">أخرى</option>
    </select>
</div>


        <div class="mb-4">
            <label class="block">القيمة</label>
            <input type="number" step="0.01" name="amount" class="border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label class="block">الوصف</label>
            <textarea name="description" class="border p-2 w-full"></textarea>
        </div>

        <div class="mb-4">
            <label class="block">تاريخ المساعدة</label>
            <input type="date" name="aid_date" class="border p-2 w-full" required>
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">حفظ</button>
    </form>
</div>
@endsection
