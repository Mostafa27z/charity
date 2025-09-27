@extends('layouts.user')
@section('title','المستفيدون')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">قائمة المستفيدين</h1>

    {{-- 🔎 البحث والتصفية --}}
    <form method="GET" action="{{ route('user.beneficiaries.index') }}"
          class="mb-4 grid grid-cols-1 md:grid-cols-5 gap-4 bg-gray-50 p-4 rounded shadow">
        {{-- Search --}}
        <div class="md:col-span-2">
            <label class="block mb-1 text-sm font-medium">بحث (اسم / رقم قومي)</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="أدخل الاسم أو الرقم القومي"
                   class="border p-2 w-full rounded">
        </div>

        {{-- Gender --}}
        <div>
            <label class="block mb-1 text-sm font-medium">الجنس</label>
            <select name="gender" class="border p-2 w-full rounded">
                <option value="">الكل</option>
                <option value="male"   {{ request('gender')=='male'?'selected':'' }}>ذكر</option>
                <option value="female" {{ request('gender')=='female'?'selected':'' }}>أنثى</option>
            </select>
        </div>

        {{-- Min Income --}}
        <div>
            <label class="block mb-1 text-sm font-medium">حد أدنى للدخل</label>
            <input type="number" step="0.01" name="min_income" value="{{ request('min_income') }}"
                   class="border p-2 w-full rounded">
        </div>

        {{-- Max Income --}}
        <div>
            <label class="block mb-1 text-sm font-medium">حد أقصى للدخل</label>
            <input type="number" step="0.01" name="max_income" value="{{ request('max_income') }}"
                   class="border p-2 w-full rounded">
        </div>

        {{-- Actions --}}
        <div class="md:col-span-5 flex items-end space-x-2 space-x-reverse">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">تصفية</button>
            <a href="{{ route('user.beneficiaries.index') }}"
               class="px-4 py-2 border rounded text-gray-700 hover:bg-gray-100">إعادة تعيين</a>
        </div>
    </form>

    {{-- Add Button --}}
    <div class="mb-4">
        <a href="{{ route('user.beneficiaries.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">
           ➕ إضافة مستفيد
        </a>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="table-auto w-full text-sm border">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-right">الرقم القومي</th>
                    <th class="px-4 py-2 text-right">الاسم</th>
                    <th class="px-4 py-2 text-right">الجنس</th>
                    <th class="px-4 py-2 text-right">الدخل</th>
                    <th class="px-4 py-2 text-right">الهاتف</th>
                    <th class="px-4 py-2 text-center">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($beneficiaries as $b)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $b->national_id }}</td>
                    <td class="px-4 py-2">{{ $b->first_name }} {{ $b->last_name }}</td>
                    <td class="px-4 py-2">
                        {{ $b->gender === 'male' ? 'ذكر' : ($b->gender === 'female' ? 'أنثى' : 'غير محدد') }}
                    </td>
                    <td class="px-4 py-2">
                        {{ $b->income !== null ? number_format($b->income,2) : '-' }}
                    </td>
                    <td class="px-4 py-2">{{ $b->phone ?? '-' }}</td>
                    <td class="px-4 py-2 text-center space-x-1 space-x-reverse">
                        <a href="{{ route('user.beneficiaries.show',$b) }}"
                           class="text-blue-600 hover:underline">عرض</a>
                        @if(auth()->user()->association_id === $b->association_id)
                            | <a href="{{ route('user.beneficiaries.edit',$b) }}"
                                 class="text-green-600 hover:underline">تعديل</a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">لا توجد بيانات</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $beneficiaries->links() }}
    </div>
</div>
@endsection
