@extends('layouts.admin')
@section('title','إدارة المستفيدين')

@section('content')
<div class="container mx-auto" dir="rtl">
    <h1 class="text-2xl font-bold mb-6">📋 المستفيدون</h1>

    {{-- 🔍 نموذج البحث والفلترة --}}
    <form method="GET" action="{{ route('admin.beneficiaries.index') }}" class="mb-6 grid md:grid-cols-4 gap-4 bg-white p-4 rounded shadow">
        <input type="text" name="search" value="{{ request('search') }}" 
               placeholder="بحث بالاسم أو الرقم القومي"
               class="border p-2 rounded col-span-2">

        <select name="association_id" class="border p-2 rounded">
            <option value="">كل الجمعيات</option>
            @foreach($associations as $id=>$name)
                <option value="{{ $id }}" @selected(request('association_id')==$id)>{{ $name }}</option>
            @endforeach
        </select>

        <select name="gender" class="border p-2 rounded">
            <option value="">النوع</option>
            <option value="male" @selected(request('gender')=='male')>ذكر</option>
            <option value="female" @selected(request('gender')=='female')>أنثى</option>
        </select>

        <div class="md:col-span-4 flex gap-2 mt-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                🔍 بحث
            </button>
            <a href="{{ route('admin.beneficiaries.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">إعادة تعيين</a>
        </div>
    </form>

    <a href="{{ route('admin.beneficiaries.create') }}"
       class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        ➕ إضافة مستفيد
    </a>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    {{-- جدول المستفيدين --}}
    <div class="overflow-x-auto">
    <table class="w-full border text-sm bg-white shadow rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">الرقم القومي</th>
                <th class="p-2 border">الاسم</th>
                <th class="p-2 border">الجمعية</th>
                <th class="p-2 border">الهاتف</th>
                <th class="p-2 border">الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($beneficiaries as $b)
                <tr>
                    <td class="p-2 border">{{ $b->national_id }}</td>
                    <td class="p-2 border">{{ $b->first_name }} {{ $b->last_name }}</td>
                    <td class="p-2 border">{{ $b->association?->name ?? '—' }}</td>
                    <td class="p-2 border">{{ $b->phone ?? '—' }}</td>
                    <td class="p-2 border">
                        <a href="{{ route('admin.beneficiaries.show',$b) }}" class="text-blue-600 hover:underline">عرض</a> |
                        <a href="{{ route('admin.beneficiaries.edit',$b) }}" class="text-yellow-600 hover:underline">تعديل</a> |
                        <form action="{{ route('admin.beneficiaries.destroy',$b) }}" method="POST" class="inline"
                              onsubmit="return confirm('هل تريد حذف المستفيد؟')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">حذف</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center p-4">لا توجد نتائج.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <div class="mt-4">{{ $beneficiaries->links() }}</div>
</div>
@endsection
