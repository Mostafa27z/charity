@extends('layouts.admin')
@section('title','إدارة الجمعيات')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <i class="fa-solid fa-building text-primary"></i> قائمة الجمعيات
    </h1>

    <a href="{{ route('admin.associations.create') }}"
       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded mb-4 inline-block">
        <i class="fa fa-plus"></i> إضافة جمعية جديدة
    </a>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    <table class="w-full border border-gray-300 text-right bg-white shadow rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">#</th>
                <th class="p-2">الاسم</th>
                <th class="p-2">الهاتف</th>
                <th class="p-2">الحالة</th>
                <th class="p-2">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($associations as $assoc)
                <tr class="border-t">
                    <td class="p-2">{{ $assoc->id }}</td>
                    <td class="p-2">{{ $assoc->name }}</td>
                    <td class="p-2">{{ $assoc->phone ?? '-' }}</td>
                    <td class="p-2">
                        <span class="px-2 py-1 rounded text-white {{ $assoc->status=='active'?'bg-green-600':'bg-red-600' }}">
                            {{ $assoc->status=='active'?'نشطة':'غير نشطة' }}
                        </span>
                    </td>
                    <td class="p-2 flex gap-2">
                        <a href="{{ route('admin.associations.show',$assoc->id) }}"
                           class="text-blue-600 hover:underline"><i class="fa fa-eye"></i></a>

                        <a href="{{ route('admin.associations.edit',$assoc->id) }}"
                           class="text-yellow-600 hover:underline"><i class="fa fa-edit"></i></a>

                        <form method="POST" action="{{ route('admin.associations.destroy',$assoc->id) }}"
                              onsubmit="return confirm('تأكيد الحذف؟')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
