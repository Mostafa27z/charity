@extends('layouts.admin')
@section('title','تفاصيل مستفيد')

@section('content')
<div class="container mx-auto" dir="rtl">
    <h1 class="text-2xl font-bold mb-6">👤 تفاصيل المستفيد</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    {{-- بيانات المستفيد --}}
    <div class="bg-white shadow p-6 rounded mb-6">
        <p><strong>الاسم:</strong> {{ $beneficiary->first_name }} {{ $beneficiary->last_name }}</p>
        <p><strong>الرقم القومي:</strong> {{ $beneficiary->national_id }}</p>
        <p><strong>الجمعية:</strong> {{ $beneficiary->association?->name }}</p>
        <p><strong>الهاتف:</strong> {{ $beneficiary->phone ?? '—' }}</p>
        <p><strong>العنوان:</strong> {{ $beneficiary->address ?? '—' }}</p>
        <p><strong>حجم الأسرة:</strong> {{ $beneficiary->family_size ?? '—' }}</p>
        <p><strong>الدخل:</strong> {{ $beneficiary->income ?? '—' }}</p>
        <p><strong>ملاحظات:</strong> {{ $beneficiary->notes ?? '—' }}</p>
    </div>

    {{-- الأقارب --}}
    <h2 class="text-xl font-semibold mt-6 mb-2">👨‍👩‍👧‍👦 الأقارب</h2>
    <div class="bg-white shadow p-4 rounded mb-6">
        @forelse($beneficiary->relatives as $rel)
            <div class="border-b py-2">
                <strong>{{ $rel->name }}</strong> – {{ $rel->relation_type ?? 'غير محدد' }}
                | هاتف: {{ $rel->phone ?? '—' }}
                | رقم قومي: {{ $rel->national_id ?? '—' }}
            </div>
        @empty
            <p>لا يوجد أقارب مسجلين.</p>
        @endforelse
    </div>

    {{-- 🟢 المساعدات الخاصة بالمستفيد --}}
    <h2 class="text-xl font-semibold mb-2">💰 المساعدات</h2>
    <div class="bg-white shadow p-4 rounded">
        @php
            $aidTypeLabels = [
                'financial' => 'مالية',
                'food'      => 'غذائية',
                'medical'   => 'طبية',
                'education' => 'تعليمية',
                'clothing'  => 'ملابس',
                'other'     => 'أخرى',
            ];
        @endphp

        @forelse($beneficiary->aids as $aid)
            <div class="border-b py-3 flex justify-between items-center">
                <div>
                    <strong>نوع:</strong>
                    {{ $aidTypeLabels[$aid->aid_type] ?? $aid->aid_type }}
                    | <strong>المبلغ:</strong> {{ $aid->amount ?? '—' }}
                    | <strong>تاريخ:</strong> {{ \Carbon\Carbon::parse($aid->aid_date)->format('Y-m-d') }}
                    | <strong>الجمعية:</strong> {{ $aid->association?->name ?? '—' }}
                </div>
                <a href="{{ route('admin.aids.show',$aid->id) }}"
                   class="text-blue-600 hover:underline">عرض التفاصيل</a>
            </div>
        @empty
            <p>لا توجد مساعدات مسجلة لهذا المستفيد.</p>
        @endforelse
    </div>

    {{-- أزرار --}}
    <div class="mt-6 flex gap-3">
        <a href="{{ route('admin.beneficiaries.edit',$beneficiary) }}"
           class="px-4 py-2 bg-yellow-500 text-white rounded">✏️ تعديل</a>

        <a href="{{ route('admin.beneficiaries.index') }}"
           class="px-4 py-2 bg-gray-500 text-white rounded">🔙 رجوع</a>
    </div>
</div>
@endsection
