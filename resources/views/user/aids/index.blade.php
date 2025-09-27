@extends('layouts.user')
@section('title', "المساعدات")
@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">قائمة المساعدات</h1>

    {{-- 🔎 Search + Filters --}}
    <form method="GET" class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4 bg-gray-100 p-4 rounded">
        <div>
            <label class="block mb-1">بحث (اسم / رقم قومي)</label>
            <input type="text" name="search" value="{{ request('search') }}" class="border p-2 w-full">
        </div>

        <div>
            <label class="block mb-1">نوع المساعدة</label>
            <select name="type" class="border p-2 w-full">
                <option value="">الكل</option>
                @foreach($types as $key => $label)
                    <option value="{{ $key }}" @selected(request('type')==$key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1">أدنى قيمة</label>
            <input type="number" name="min_amount" step="0.01" value="{{ request('min_amount') }}" class="border p-2 w-full">
        </div>

        <div>
            <label class="block mb-1">أقصى قيمة</label>
            <input type="number" name="max_amount" step="0.01" value="{{ request('max_amount') }}" class="border p-2 w-full">
        </div>

        <div class="md:col-span-4 text-center">
            <button class="bg-blue-500 text-white px-4 py-2 rounded">تصفية</button>
            <a href="{{ route('user.aids.index') }}" class="ml-2 text-gray-600 underline">إعادة تعيين</a>
        </div>
    </form>

    <a href="{{ route('user.aids.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">إضافة مساعدة</a>

    <table class="table-auto w-full mt-4 border">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">المستفيد</th>
                <th class="px-4 py-2">النوع</th>
                <th class="px-4 py-2">القيمة</th>
                <th class="px-4 py-2">التاريخ</th>
                <th class="px-4 py-2">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($aids as $aid)
            <tr>
                <td class="border px-4 py-2">
                    {{ $aid->beneficiary->first_name ?? '' }} {{ $aid->beneficiary->last_name ?? '' }}
                </td>
                <td class="border px-4 py-2">
                    {{ $types[$aid->aid_type] ?? $aid->aid_type }}
                </td>
                <td class="border px-4 py-2">{{ $aid->amount }}</td>
                <td class="border px-4 py-2">{{ $aid->aid_date }}</td>
                <td class="border px-4 py-2 text-center">
                    <a href="{{ route('user.aids.show',$aid) }}" class="text-blue-600 hover:underline">عرض</a> |
                    <a href="{{ route('user.aids.edit',$aid) }}" class="text-green-600 hover:underline">تعديل</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-4">لا توجد نتائج</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $aids->links() }}
</div>
@endsection
