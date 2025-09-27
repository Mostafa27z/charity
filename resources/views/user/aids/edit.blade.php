@extends('layouts.user')
@section('title','تعديل مساعدة')
@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">تعديل مساعدة</h1>

    <form method="POST" action="{{ route('user.aids.update', $aid) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block">المستفيد</label>
            <select name="beneficiary_id" class="border p-2 w-full">
                @foreach($beneficiaries as $b)
                    <option value="{{ $b->id }}" {{ $aid->beneficiary_id == $b->id ? 'selected' : '' }}>
                        {{ $b->first_name }} {{ $b->last_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
    <label class="block">نوع المساعدة</label>
    <select name="aid_type" class="border p-2 w-full" required>
        @php
            $types = [
                'financial' => 'مالية',
                'food'      => 'غذائية',
                'medical'   => 'طبية',
                'education' => 'تعليمية',
                'clothing'  => 'ملابس',
                'other'     => 'أخرى',
            ];
        @endphp
        @foreach($types as $value => $label)
            <option value="{{ $value }}" {{ old('aid_type', $aid->aid_type) == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
</div>


        <div class="mb-4">
            <label class="block">القيمة</label>
            <input type="number" step="0.01" name="amount" value="{{ old('amount',$aid->amount) }}" class="border p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label class="block">الوصف</label>
            <textarea name="description" class="border p-2 w-full">{{ old('description',$aid->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block">تاريخ المساعدة</label>
            <input type="date" name="aid_date" value="{{ old('aid_date',$aid->aid_date) }}" class="border p-2 w-full" required>
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">تحديث</button>
    </form>
</div>
@endsection
