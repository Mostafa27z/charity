@extends('layouts.user')
@section('title','إدارة المستخدمين')
@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">مستخدمي الجمعية</h1>

    {{-- Search --}}
    <form method="GET" class="mb-4 flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث بالاسم أو البريد"
               class="border p-2 flex-1">
        <button class="bg-blue-500 text-white px-4 py-2 rounded">بحث</button>
        <a href="{{ route('user.users.index') }}" class="px-4 py-2 bg-gray-300 rounded">إعادة</a>
    </form>

    <a href="{{ route('user.users.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">إضافة مستخدم</a>

    <table class="table-auto w-full mt-4 border">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2">الاسم</th>
                <th class="px-4 py-2">البريد</th>
                <th class="px-4 py-2">الهاتف</th>
                <th class="px-4 py-2">الدور</th>
                <th class="px-4 py-2">الحالة</th>
                <th class="px-4 py-2">إجراءات</th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $u)
            <tr>
                <td class="border px-4 py-2">{{ $u->name }}</td>
                <td class="border px-4 py-2">{{ $u->email }}</td>
                <td class="border px-4 py-2">{{ $u->phone }}</td>
                <td class="border px-4 py-2">{{ $u->role === 'moderator' ? 'مشرف' : 'مستخدم' }}</td>
                <td class="border px-4 py-2">{{ $u->status === 'active' ? 'نشط' : 'غير نشط' }}</td>
                <td class="border px-4 py-2 text-center">
                    <a href="{{ route('user.users.show',$u) }}" class="text-blue-600">عرض</a> |
                    <a href="{{ route('user.users.edit',$u) }}" class="text-green-600">تعديل</a>
                    <form action="{{ route('user.users.destroy',$u) }}" method="POST" class="inline"
                          onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                        @csrf @method('DELETE')
                        | <button class="text-red-600">حذف</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection
