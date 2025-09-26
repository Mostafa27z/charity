@extends('layouts.admin')
@section('title','إدارة المستخدمين')

@section('content')
<div class="container mx-auto" dir="rtl">
    <h1 class="text-2xl font-bold mb-6">👥 إدارة المستخدمين</h1>

    {{-- ✅ شريط البحث والفلاتر --}}
    <form method="GET" action="{{ route('admin.users.index') }}"
          class="mb-4 grid grid-cols-1 md:grid-cols-5 gap-3 bg-white p-4 rounded shadow">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="🔎 بحث بالاسم أو البريد أو الهاتف"
               class="border p-2 rounded col-span-2">

        <select name="association_id" class="border p-2 rounded">
            <option value="">كل الجمعيات</option>
            @foreach($associations as $a)
                <option value="{{ $a->id }}" @selected(request('association_id')==$a->id)>
                    {{ $a->name }}
                </option>
            @endforeach
        </select>

        <select name="role" class="border p-2 rounded">
            <option value="">كل الأدوار</option>
            <option value="admin" @selected(request('role')=='admin')>مدير</option>
            <option value="moderator" @selected(request('role')=='moderator')>مشرف</option>
            <option value="user" @selected(request('role')=='user')>مستخدم</option>
        </select>

        <select name="status" class="border p-2 rounded">
            <option value="">كل الحالات</option>
            <option value="active" @selected(request('status')=='active')>نشط</option>
            <option value="inactive" @selected(request('status')=='inactive')>غير نشط</option>
        </select>

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">تصفية</button>
    </form>

    {{-- زر الإضافة --}}
    <a href="{{ route('admin.users.create') }}"
       class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        ➕ إضافة مستخدم
    </a>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    {{-- ✅ جدول المستخدمين --}}
    <div class="overflow-x-auto">
        <table class="w-full border text-sm bg-white shadow rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">الاسم</th>
                    <th class="p-2 border">البريد</th>
                    <th class="p-2 border">الهاتف</th>
                    <th class="p-2 border">الجمعية</th>
                    <th class="p-2 border">الدور</th>
                    <th class="p-2 border">الحالة</th>
                    <th class="p-2 border">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                    <tr>
                        <td class="p-2 border">{{ $u->name }}</td>
                        <td class="p-2 border">{{ $u->email }}</td>
                        <td class="p-2 border">{{ $u->phone ?? '—' }}</td>
                        <td class="p-2 border">{{ $u->association?->name ?? '—' }}</td>
                        <td class="p-2 border">
                            @if($u->role=='admin')
                                <span class="text-red-600">مدير</span>
                            @elseif($u->role=='moderator')
                                <span class="text-blue-600">مشرف</span>
                            @else
                                مستخدم
                            @endif
                        </td>
                        <td class="p-2 border">
                            <span class="{{ $u->status=='active'?'text-green-600':'text-gray-500' }}">
                                {{ $u->status=='active'?'نشط':'غير نشط' }}
                            </span>
                        </td>
                        <td class="p-2 border">
                            <a href="{{ route('admin.users.show',$u) }}" class="text-blue-600 hover:underline">عرض</a> |
                            <a href="{{ route('admin.users.edit',$u) }}" class="text-yellow-600 hover:underline">تعديل</a> |
                            <form action="{{ route('admin.users.destroy',$u) }}" method="POST" class="inline"
                                  onsubmit="return confirm('حذف هذا المستخدم؟')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center p-4">لا توجد نتائج مطابقة.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ✅ روابط الصفحات --}}
    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection
