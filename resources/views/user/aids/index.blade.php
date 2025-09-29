@extends('layouts.user')
@section('title', "المساعدات")
@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">قائمة المساعدات</h1>

    {{-- 🔎 Search + Filters --}}
    <form method="GET"
          class="mb-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 bg-gray-100 p-4 rounded shadow">
        <div>
            <label class="block mb-1">بحث (اسم / رقم قومي)</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label class="block mb-1">نوع المساعدة</label>
            <select name="type"
                    class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">الكل</option>
                @foreach($types as $key => $label)
                    <option value="{{ $key }}" @selected(request('type')==$key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1">أدنى قيمة</label>
            <input type="number" name="min_amount" step="0.01"
                   value="{{ request('min_amount') }}"
                   class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label class="block mb-1">أقصى قيمة</label>
            <input type="number" name="max_amount" step="0.01"
                   value="{{ request('max_amount') }}"
                   class="border p-2 w-full rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="sm:col-span-2 md:col-span-4 text-center">
            <button
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded shadow transition">
                تصفية
            </button>
            <a href="{{ route('user.aids.index') }}"
               class="ml-2 text-gray-600 underline hover:text-gray-800">
               إعادة تعيين
            </a>
        </div>
    </form>

    <div class="flex justify-end mb-3">
        <a href="{{ route('user.aids.create') }}"
           class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow transition">
           إضافة مساعدة
        </a>
    </div>

    {{-- Responsive Table --}}
    <div class="overflow-x-auto">
        <table class="table-auto min-w-full border border-gray-200">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="px-4 py-2 text-nowrap">المستفيد</th>
                    <th class="px-4 py-2 text-nowrap">النوع</th>
                    <th class="px-4 py-2 text-nowrap">القيمة</th>
                    <th class="px-4 py-2 text-nowrap">التاريخ</th>
                    <th class="px-4 py-2 text-nowrap">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aids as $aid)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2 whitespace-nowrap">
                        {{ $aid->beneficiary->first_name ?? '' }} {{ $aid->beneficiary->last_name ?? '' }}
                    </td>
                    <td class="border px-4 py-2 whitespace-nowrap">
                        {{ $types[$aid->aid_type] ?? $aid->aid_type }}
                    </td>
                    <td class="border px-4 py-2 whitespace-nowrap">{{ $aid->amount }}</td>
                    <td class="border px-4 py-2 whitespace-nowrap">{{ $aid->aid_date }}</td>
                    <td class="border px-4 py-2 text-center whitespace-nowrap">
                        <a href="{{ route('user.aids.show',$aid) }}"
                           class="text-blue-600 hover:underline">عرض</a> |
                        <a href="{{ route('user.aids.edit',$aid) }}"
                           class="text-green-600 hover:underline">تعديل</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">لا توجد نتائج</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $aids->links() }}
    </div>
</div>
@endsection
