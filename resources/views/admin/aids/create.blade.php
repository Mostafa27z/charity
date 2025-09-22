@extends('layouts.admin')

@section('title','إضافة مساعدة جديدة')

@section('content')
<div class="container mx-auto" dir="rtl">
    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <i class="fa fa-plus text-blue-600"></i>
        إضافة مساعدة جديدة
    </h1>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.aids.store') }}" method="POST" class="bg-white shadow p-6 rounded">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">المستفيد</label>
            <select name="beneficiary_id" class="w-full border rounded p-2" required>
                <option value="">اختر مستفيد</option>
                @foreach($beneficiaries as $b)
                    <option value="{{ $b->id }}">{{ $b->first_name }} {{ $b->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">الجمعية</label>
            <select name="association_id" class="w-full border rounded p-2" required>
                <option value="">اختر جمعية</option>
                @foreach($associations as $a)
                    <option value="{{ $a->id }}">{{ $a->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">نوع المساعدة</label>
            <select name="aid_type" class="w-full border rounded p-2" required>
                <option value="financial">مالية</option>
                <option value="food">غذائية</option>
                <option value="medical">طبية</option>
                <option value="education">تعليمية</option>
                <option value="clothing">ملابس</option>
                <option value="other">أخرى</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block mb-1">المبلغ</label>
            <input type="number" step="0.01" name="amount"
                   class="w-full border rounded p-2" placeholder="اختياري">
        </div>

        <div class="mb-4">
            <label class="block mb-1">الوصف</label>
            <textarea name="description"
                      class="w-full border rounded p-2" placeholder="تفاصيل المساعدة"></textarea>
        </div>

        <div class="mb-4">
            <label class="block mb-1">تاريخ المساعدة</label>
            <input type="date" name="aid_date"
                   class="w-full border rounded p-2" required>
        </div>

        <button type="submit"
                class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            <i class="fa fa-save"></i> حفظ
        </button>
    </form>
</div>
@endsection
