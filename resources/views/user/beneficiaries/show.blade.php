@extends('layouts.user')
@section('title','تفاصيل المستفيد')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">بيانات المستفيد</h1>

    <div class="bg-white rounded shadow p-4 mb-6">
        <p><strong>الاسم:</strong> {{ $beneficiary->first_name }} {{ $beneficiary->last_name }}</p>
        <p><strong>الرقم القومي:</strong> {{ $beneficiary->national_id }}</p>
        <p><strong>الجنس:</strong>
            {{ $beneficiary->gender === 'male' ? 'ذكر' : ($beneficiary->gender === 'female' ? 'أنثى' : 'غير محدد') }}
        </p>
        <p><strong>الهاتف:</strong> {{ $beneficiary->phone ?? '-' }}</p>
        <p><strong>الدخل:</strong> {{ $beneficiary->income !== null ? number_format($beneficiary->income,2) : '-' }}</p>
        <p><strong>العنوان:</strong> {{ $beneficiary->address ?? '-' }}</p>
    </div>

    <h2 class="text-xl font-semibold mb-3">المساعدات المرتبطة</h2>
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="table-auto w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">النوع</th>
                    <th class="px-4 py-2">القيمة</th>
                    <th class="px-4 py-2">التاريخ</th>
                    <th class="px-4 py-2">الجمعية</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aids as $aid)
                <tr class="border-b">
                    <td class="px-4 py-2">{{ $aid->aid_type }}</td>
                    <td class="px-4 py-2">{{ number_format($aid->amount,2) }}</td>
                    <td class="px-4 py-2">{{ $aid->aid_date }}</td>
                    <td class="px-4 py-2">{{ $aid->association->name ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">لا توجد مساعدات لهذا المستفيد</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="{{ route('user.beneficiaries.index') }}"
           class="bg-gray-600 text-white px-4 py-2 rounded">⬅ العودة للقائمة</a>
    </div>
</div>
@endsection
