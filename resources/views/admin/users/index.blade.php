@extends('layouts.admin')
@section('title','إدارة المستخدمين')

@section('content')
<div class="container mx-auto px-3 sm:px-6 lg:px-8 py-4 sm:py-6" dir="rtl">

    {{-- 🏷️ Page Title --}}
    <div class="mb-6">
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold flex items-center gap-2 flex-wrap">
            <i class="fa-solid fa-users text-blue-600 text-2xl sm:text-3xl"></i>
            <span>إدارة المستخدمين</span>
        </h1>
    </div>

    {{-- ✅ Success Message --}}
    @if(session('success'))
        <div class="mb-4 p-3 sm:p-4 rounded-lg bg-green-100 text-green-800 text-sm sm:text-base text-center sm:text-right shadow-sm animate-pulse">
            <i class="fa fa-check-circle ml-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- 🔎 Filters --}}
    <form method="GET" action="{{ route('admin.users.index') }}"
          class="mb-6 bg-white p-4 rounded-lg shadow flex flex-wrap gap-3 items-end text-sm sm:text-base">
        
        <div class="flex-1 min-w-[200px]">
            <label class="block mb-1 text-gray-700 font-medium">بحث</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="بحث بالاسم أو البريد أو الهاتف"
                   class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="min-w-[150px]">
            <label class="block mb-1 text-gray-700 font-medium">الجمعية</label>
            <select name="association_id"
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                <option value="">كل الجمعيات</option>
                @foreach($associations as $a)
                    <option value="{{ $a->id }}" @selected(request('association_id')==$a->id)>
                        {{ $a->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="min-w-[130px]">
            <label class="block mb-1 text-gray-700 font-medium">الدور</label>
            <select name="role"
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                <option value="">كل الأدوار</option>
                <option value="admin" @selected(request('role')=='admin')>مدير</option>
                <option value="moderator" @selected(request('role')=='moderator')>مشرف</option>
                <option value="user" @selected(request('role')=='user')>مستخدم</option>
            </select>
        </div>

        <div class="min-w-[130px]">
            <label class="block mb-1 text-gray-700 font-medium">الحالة</label>
            <select name="status"
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                <option value="">كل الحالات</option>
                <option value="active" @selected(request('status')=='active')>نشط</option>
                <option value="inactive" @selected(request('status')=='inactive')>غير نشط</option>
            </select>
        </div>

        <div class="flex gap-2 w-full sm:w-auto">
            <button type="submit"
                    class="flex-1 sm:flex-none px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow">
                <i class="fa fa-search"></i> تصفية
            </button>
            <a href="{{ route('admin.users.index') }}"
               class="flex-1 sm:flex-none px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                إعادة ضبط
            </a>
        </div>
    </form>

    {{-- ➕ Add Button --}}
    <div class="mb-4 flex justify-center sm:justify-start">
        <a href="{{ route('admin.users.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2.5 sm:py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all shadow-md hover:shadow-lg text-sm sm:text-base font-semibold w-full sm:w-auto">
           <i class="fa fa-plus"></i>
           <span>إضافة مستخدم جديد</span>
        </a>
    </div>

    {{-- 📱 Mobile Card View --}}
    <div class="block lg:hidden space-y-3">
        @forelse($users as $u)
        <div class="bg-white rounded-lg shadow-md p-4 border-r-4 border-blue-500">
            <div class="flex justify-between items-start mb-3 pb-3 border-b">
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 text-base mb-1">{{ $u->name }}</h3>
                    <p class="text-sm text-gray-600">{{ $u->email }}</p>
                </div>
                <div class="flex flex-col gap-1 items-end">
                    @if($u->role=='admin')
                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-semibold">مدير</span>
                    @elseif($u->role=='moderator')
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">مشرف</span>
                    @else
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs font-semibold">مستخدم</span>
                    @endif
                    <span class="px-2 py-1 rounded text-xs font-semibold {{ $u->status=='active'?'bg-green-100 text-green-700':'bg-gray-100 text-gray-600' }}">
                        {{ $u->status=='active'?'نشط':'غير نشط' }}
                    </span>
                </div>
            </div>

            <div class="space-y-2 text-sm mb-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">الهاتف:</span>
                    <span class="font-semibold text-gray-800">{{ $u->phone ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">الجمعية:</span>
                    <span class="font-semibold text-gray-800">{{ $u->association?->name ?? '—' }}</span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-2 pt-3 border-t">
                <a href="{{ route('admin.users.show',$u) }}"
                   class="flex-1 text-center py-2 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition text-sm font-semibold">
                    <i class="fa fa-eye ml-1"></i> عرض
                </a>
                <a href="{{ route('admin.users.edit',$u) }}"
                   class="flex-1 text-center py-2 bg-yellow-50 text-yellow-600 rounded hover:bg-yellow-100 transition text-sm font-semibold">
                    <i class="fa fa-edit ml-1"></i> تعديل
                </a>
                <form action="{{ route('admin.users.destroy',$u) }}" method="POST" class="flex-1"
                      onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                    @csrf @method('DELETE')
                    <button class="w-full py-2 bg-red-50 text-red-600 rounded hover:bg-red-100 transition text-sm font-semibold">
                        <i class="fa fa-trash ml-1"></i> حذف
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
            <i class="fa fa-inbox text-4xl mb-3 text-gray-300"></i>
            <p>لا توجد نتائج مطابقة</p>
        </div>
        @endforelse
    </div>

    {{-- 💻 Desktop Table View --}}
    <div class="hidden lg:block overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-full text-sm text-right">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 text-sm border-b-2 border-gray-200">
                <tr class="text-gray-700">
                    <th class="p-4 font-bold whitespace-nowrap">الاسم</th>
                    <th class="p-4 font-bold whitespace-nowrap">البريد الإلكتروني</th>
                    <th class="p-4 font-bold whitespace-nowrap">الهاتف</th>
                    <th class="p-4 font-bold whitespace-nowrap">الجمعية</th>
                    <th class="p-4 font-bold whitespace-nowrap">الدور</th>
                    <th class="p-4 font-bold whitespace-nowrap">الحالة</th>
                    <th class="p-4 font-bold whitespace-nowrap text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">
                @forelse($users as $u)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 font-semibold text-gray-800">{{ $u->name }}</td>
                    <td class="p-4 text-gray-700">{{ $u->email }}</td>
                    <td class="p-4 text-gray-700">{{ $u->phone ?? '—' }}</td>
                    <td class="p-4 text-gray-700">{{ $u->association?->name ?? '—' }}</td>
                    <td class="p-4">
                        @if($u->role=='admin')
                            <span class="inline-block px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-semibold">
                                <i class="fa fa-shield-alt ml-1"></i> مدير
                            </span>
                        @elseif($u->role=='moderator')
                            <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-semibold">
                                <i class="fa fa-user-shield ml-1"></i> مشرف
                            </span>
                        @else
                            <span class="inline-block px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs font-semibold">
                                <i class="fa fa-user ml-1"></i> مستخدم
                            </span>
                        @endif
                    </td>
                    <td class="p-4">
                        <span class="inline-block px-2 py-1 rounded text-xs font-semibold {{ $u->status=='active'?'bg-green-100 text-green-700':'bg-gray-100 text-gray-600' }}">
                            <i class="fa fa-circle text-[8px] ml-1"></i>
                            {{ $u->status=='active'?'نشط':'غير نشط' }}
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('admin.users.show',$u) }}"
                               class="text-blue-600 hover:text-blue-800 transition p-2 hover:bg-blue-50 rounded"
                               title="عرض">
                                <i class="fa fa-eye text-lg"></i>
                            </a>
                            <a href="{{ route('admin.users.edit',$u) }}"
                               class="text-yellow-600 hover:text-yellow-800 transition p-2 hover:bg-yellow-50 rounded"
                               title="تعديل">
                                <i class="fa fa-edit text-lg"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy',$u) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:text-red-800 transition p-2 hover:bg-red-50 rounded"
                                        title="حذف">
                                    <i class="fa fa-trash text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">
                        <i class="fa fa-inbox text-4xl mb-3 text-gray-300 block"></i>
                        <p>لا توجد نتائج مطابقة</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6 flex justify-center">
        {{ $users->links() }}
    </div>
</div>
@endsection