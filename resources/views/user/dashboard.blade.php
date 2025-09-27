@extends('layouts.user')
@section('title','لوحة التحكم')
@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6">إحصائيات الجمعية: {{ $association->name }}</h1>

    {{-- ✅ Summary Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
        <div class="bg-white rounded-lg p-4 shadow text-center">
            <p class="font-semibold">عدد المستفيدين</p>
            <h2 class="text-xl">{{ $stats['beneficiaries_count'] }}</h2>
        </div>
        <div class="bg-white rounded-lg p-4 shadow text-center">
            <p class="font-semibold">عدد المساعدات</p>
            <h2 class="text-xl">{{ $stats['aids_count'] }}</h2>
        </div>
        <div class="bg-white rounded-lg p-4 shadow text-center">
            <p class="font-semibold">عدد المستخدمين</p>
            <h2 class="text-xl">{{ $stats['users_count'] }}</h2>
        </div>
        <div class="bg-white rounded-lg p-4 shadow text-center">
            <p class="font-semibold">إجمالي المساعدات (ج.م)</p>
            <h2 class="text-xl">{{ number_format($stats['total_aid_amount'],2) }}</h2>
        </div>
    </div>

    {{-- ✅ Aid Type Breakdown --}}
    <div class="bg-white p-4 rounded shadow mb-10">
        <h2 class="text-xl font-semibold mb-4">توزيع المساعدات حسب النوع</h2>
        <table class="table-auto w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">النوع</th>
                    <th class="px-4 py-2">العدد</th>
                    <th class="px-4 py-2">إجمالي القيمة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($aidTypes as $type)
                @php
                    $typeLabels = [
                        'financial' => 'مالية',
                        'food'      => 'غذائية',
                        'medical'   => 'طبية',
                        'education' => 'تعليمية',
                        'clothing'  => 'ملابس',
                        'other'     => 'أخرى',
                    ];
                @endphp
                <tr>
                    <td class="border px-4 py-2">{{ $typeLabels[$type->aid_type] ?? $type->aid_type }}</td>
                    <td class="border px-4 py-2">{{ $type->count }}</td>
                    <td class="border px-4 py-2">{{ number_format($type->total_amount,2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ✅ Monthly Trend --}}
    <div class="bg-white p-4 rounded shadow mb-10">
        <h2 class="text-xl font-semibold mb-4">قيمة المساعدات آخر 6 أشهر</h2>
        <ul>
            @foreach($monthlyAids as $month => $total)
            <li class="py-1 flex justify-between border-b">
                <span>{{ $month }}</span>
                <span>{{ number_format($total,2) }}</span>
            </li>
            @endforeach
        </ul>
    </div>

    {{-- ✅ Users Status --}}
    <div class="bg-white p-4 rounded shadow mb-10">
        <h2 class="text-xl font-semibold mb-4">حالة المستخدمين</h2>
        <p>نشطون: {{ $userStatus['active'] ?? 0 }}</p>
        <p>غير نشطين: {{ $userStatus['inactive'] ?? 0 }}</p>
    </div>

    {{-- ✅ Recent Activities --}}
    <div class="grid md:grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">أحدث 5 مساعدات</h3>
            <ul>
                @foreach($recentAids as $a)
                <li class="border-b py-1">
                    {{ $a->beneficiary->first_name ?? '' }}
                    - {{ $typeLabels[$a->aid_type] ?? $a->aid_type }}
                    ({{ number_format($a->amount,2) }})
                </li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">أحدث 5 مستفيدين</h3>
            <ul>
                @foreach($recentBeneficiaries as $b)
                <li class="border-b py-1">{{ $b->first_name }} {{ $b->last_name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
