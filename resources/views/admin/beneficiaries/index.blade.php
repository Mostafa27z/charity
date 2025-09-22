@extends('layouts.admin')
@section('title','إدارة المستفيدين')

@section('content')
<div class="container mx-auto" dir="rtl">
    <h1 class="text-2xl font-bold mb-6">📋 المستفيدون</h1>

    <a href="{{ route('admin.beneficiaries.create') }}"
       class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        ➕ إضافة مستفيد
    </a>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <table class="w-full border text-sm bg-white shadow rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">الرقم القومي</th>
                <th class="p-2 border">الاسم</th>
                <th class="p-2 border">الجمعية</th>
                <th class="p-2 border">الهاتف</th>
                <th class="p-2 border">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($beneficiaries as $b)
                <tr>
                    <td class="p-2 border">{{ $b->national_id }}</td>
                    <td class="p-2 border">{{ $b->first_name }} {{ $b->last_name }}</td>
                    <td class="p-2 border">{{ $b->association?->name }}</td>
                    <td class="p-2 border">{{ $b->phone ?? '—' }}</td>
                    <td class="p-2 border">
                        <a href="{{ route('admin.beneficiaries.show',$b) }}" class="text-blue-600">عرض</a> |
                        <a href="{{ route('admin.beneficiaries.edit',$b) }}" class="text-yellow-600">تعديل</a> |
                        <form action="{{ route('admin.beneficiaries.destroy',$b) }}" method="POST" class="inline"
                              onsubmit="return confirm('حذف المستفيد؟')">
                            @csrf @method('DELETE')
                            <button class="text-red-600">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $beneficiaries->links() }}</div>
</div>
@endsection
