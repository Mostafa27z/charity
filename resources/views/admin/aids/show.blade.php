@extends('layouts.admin')

@section('title','تفاصيل المساعدة')

@section('content')
<div class="container mx-auto" dir="rtl">
    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <i class="fa-solid fa-circle-info text-blue-600"></i>
        تفاصيل المساعدة
    </h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow rounded p-6">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm">
            <div>
                <dt class="font-semibold text-gray-600 flex items-center gap-1">
                    <i class="fa fa-hands-helping text-teal-600"></i> نوع المساعدة
                </dt>
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

                <dd class="mt-1 text-gray-900">
                    {{ $aidTypeLabels[$aid->aid_type] ?? $aid->aid_type }}
                </dd>

            </div>

            <div>
                <dt class="font-semibold text-gray-600 flex items-center gap-1">
                    <i class="fa fa-user text-indigo-600"></i> المستفيد
                </dt>
                <dd class="mt-1">
                    {{ $aid->beneficiary?->first_name }} {{ $aid->beneficiary?->last_name }}
                </dd>
            </div>

            <div>
                <dt class="font-semibold text-gray-600 flex items-center gap-1">
                    <i class="fa fa-building text-purple-600"></i> الجمعية
                </dt>
                <dd class="mt-1">{{ $aid->association?->name ?? '—' }}</dd>
            </div>

            <div>
                <dt class="font-semibold text-gray-600 flex items-center gap-1">
                    <i class="fa fa-money-bill-wave text-green-600"></i> المبلغ
                </dt>
                <dd class="mt-1">{{ $aid->amount ?? '—' }}</dd>
            </div>

            <div>
                <dt class="font-semibold text-gray-600 flex items-center gap-1">
                    <i class="fa fa-calendar-days text-orange-600"></i> تاريخ المساعدة
                </dt>
                <dd class="mt-1">{{ \Carbon\Carbon::parse($aid->aid_date)->format('Y-m-d') }}</dd>
            </div>

            <div>
                <dt class="font-semibold text-gray-600 flex items-center gap-1">
                    <i class="fa fa-user-shield text-gray-600"></i> أنشأ بواسطة
                </dt>
                <dd class="mt-1">{{ $aid->creator?->name ?? '—' }}</dd>
            </div>
        </dl>

        <div class="mt-6">
            <h2 class="font-semibold text-gray-700 mb-2 flex items-center gap-1">
                <i class="fa fa-align-left text-gray-500"></i> الوصف
            </h2>
            <p class="bg-gray-50 border rounded p-3 text-gray-800">
                {{ $aid->description ?? 'لا يوجد وصف' }}
            </p>
        </div>

        {{-- Actions --}}
        <div class="mt-8 flex gap-3">
            <a href="{{ route('admin.aids.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
               <i class="fa fa-arrow-right"></i> رجوع
            </a>

            <a href="{{ route('admin.aids.edit',$aid) }}"
               class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
               <i class="fa fa-edit"></i> تعديل
            </a>

            <form action="{{ route('admin.aids.destroy',$aid) }}" method="POST"
                  onsubmit="return confirm('هل تريد حذف هذه المساعدة؟')">
                @csrf @method('DELETE')
                <button class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                    <i class="fa fa-trash"></i> حذف
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
