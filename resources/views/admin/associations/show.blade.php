@extends('layouts.admin')
@section('title','تفاصيل الجمعية')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <i class="fa fa-building text-primary"></i> {{ $association->name }}
    </h1>

    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="text-xl font-semibold mb-4">بيانات الجمعية</h2>
        <ul class="space-y-2">
            <li><strong>رقم التسجيل:</strong> {{ $association->registration_number ?? '-' }}</li>
            <li><strong>العنوان:</strong> {{ $association->address ?? '-' }}</li>
            <li><strong>الهاتف:</strong> {{ $association->phone ?? '-' }}</li>
            <li><strong>البريد الإلكتروني:</strong> {{ $association->email }}</li>
            <li><strong>الحالة:</strong>
                <span class="px-2 py-1 rounded text-white {{ $association->status=='active'?'bg-green-600':'bg-red-600' }}">
                    {{ $association->status=='active'?'نشطة':'غير نشطة' }}
                </span>
            </li>
        </ul>
    </div>

    {{-- Users --}}
    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="text-xl font-semibold mb-4"><i class="fa fa-users"></i> المستخدمون</h2>
        @forelse($association->users as $user)
            <div class="border-b py-3">
                <p class="font-bold">{{ $user->name }} 
                    <span class="text-sm text-gray-500">({{ $user->role=='admin'?'مدير':'مستخدم' }})</span>
                </p>
                <p class="text-sm text-gray-600">البريد: {{ $user->email }} | هاتف: {{ $user->phone ?? '-' }}</p>

                {{-- Contributions --}}
                @if($user->aids->count())
                    <p class="mt-2 text-gray-700">مساهماته:</p>
                    <ul class="list-disc ml-6">
                        @foreach($user->aids as $aid)
                            @php
                                $types = [
                                    'financial'=>'مالية','food'=>'غذائية','medical'=>'طبية',
                                    'education'=>'تعليمية','clothing'=>'ملابس','other'=>'أخرى'
                                ];
                            @endphp
                            <li>{{ $types[$aid->aid_type] ?? $aid->aid_type }}
                                – {{ number_format($aid->amount,2) }} ج.م
                                – {{ optional($aid->beneficiary)->first_name }}
                                ({{ $aid->aid_date }})
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-sm text-gray-500">لا توجد مساهمات</p>
                @endif
            </div>
        @empty
            <p class="text-gray-500">لا يوجد مستخدمون مسجلون</p>
        @endforelse
    </div>

    <a href="{{ route('admin.associations.index') }}"
       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
        <i class="fa fa-arrow-left"></i> رجوع
    </a>
</div>
@endsection
