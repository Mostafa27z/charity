@extends('layouts.admin')

@section('content')
<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8" dir="rtl">

    {{-- 🏷️ Page Title --}}
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-8 flex flex-wrap items-center gap-2">
        <i class="fa-solid fa-chart-line text-green-600"></i>
        لوحة تحكم الجمعيات
    </h1>

    {{-- 📊 Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="p-5 bg-white shadow rounded-lg hover:shadow-md transition">
            <div class="flex items-center gap-3 text-lg sm:text-xl text-gray-700">
                <i class="fa-solid fa-building text-indigo-600"></i>
                <span>الجمعيات</span>
            </div>
            <p class="mt-2 text-2xl font-bold text-indigo-700">{{ $totalAssociations }}</p>
        </div>

        <div class="p-5 bg-white shadow rounded-lg hover:shadow-md transition">
            <div class="flex items-center gap-3 text-lg sm:text-xl text-gray-700">
                <i class="fa-solid fa-users text-pink-600"></i>
                <span>المستخدمون</span>
            </div>
            <p class="mt-2 text-2xl font-bold text-pink-700">{{ $totalUsers }}</p>
        </div>

        <div class="p-5 bg-white shadow rounded-lg hover:shadow-md transition">
            <div class="flex items-center gap-3 text-lg sm:text-xl text-gray-700">
                <i class="fa-solid fa-hand-holding-heart text-green-600"></i>
                <span>المستفيدون</span>
            </div>
            <p class="mt-2 text-2xl font-bold text-green-700">{{ $totalBeneficiaries }}</p>
        </div>

        <div class="p-5 bg-white shadow rounded-lg hover:shadow-md transition">
            <div class="flex items-center gap-3 text-lg sm:text-xl text-gray-700">
                <i class="fa-solid fa-gift text-orange-600"></i>
                <span>المساعدات</span>
            </div>
            <p class="mt-2 text-2xl font-bold text-orange-700">{{ $totalAids }}</p>
        </div>
    </div>

    {{-- 🕒 Recent Aids --}}
    <div class="mt-10 bg-white rounded-lg shadow p-4 sm:p-6">
        <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-clock-rotate-left text-blue-600"></i>
            أحدث المساعدات
        </h2>

        @php
            // 🔑 Mapping database values to Arabic labels
            $aidTypes = [
                'financial' => 'مالية',
                'food'      => 'غذائية',
                'medical'   => 'طبية',
                'education' => 'تعليمية',
                'clothing'  => 'ملابس',
                'other'     => 'أخرى',
            ];
        @endphp

        @if($recentAids->count())
            <div class="max-h-[400px] overflow-y-auto">
                <ul class="space-y-3">
                    @foreach($recentAids as $aid)
                        <li class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 bg-gray-50 rounded hover:bg-gray-100 transition">
                            <div class="flex items-center gap-2 text-gray-700">
                                <i class="fa-solid fa-circle text-xs text-blue-500"></i>
                                <span class="font-medium">
                                    {{ $aidTypes[$aid->aid_type] ?? $aid->aid_type }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-600 mt-1 sm:mt-0">
                                المستفيد: {{ $aid->beneficiary?->first_name ?? 'غير محدد' }}
                                &nbsp;|&nbsp;
                                الجمعية: {{ $aid->association?->name ?? 'غير محددة' }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <p class="text-gray-600">لا توجد مساعدات حديثة حالياً.</p>
        @endif
    </div>

</div>
@endsection
