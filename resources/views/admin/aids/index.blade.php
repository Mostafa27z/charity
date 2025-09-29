@extends('layouts.admin')

@section('title','إدارة المساعدات')

@section('content')
@php
    // 🟢 Map DB values → Arabic names
    $types = [
        'financial' => 'مالية',
        'food'      => 'غذائية',
        'medical'   => 'طبية',
        'education' => 'تعليمية',
        'clothing'  => 'ملابس',
        'other'     => 'أخرى',
    ];
@endphp

<div class="container mx-auto px-3 sm:px-6 lg:px-8 py-4 sm:py-6" dir="rtl">

    {{-- 🏷️ Page Title --}}
    <div class="mb-6">
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold flex items-center gap-2 flex-wrap">
            <i class="fa-solid fa-hand-holding-heart text-green-600 text-2xl sm:text-3xl"></i>
            <span>إدارة المساعدات</span>
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
    <form method="GET" action="{{ route('admin.aids.index') }}"
          class="mb-6 bg-white p-4 rounded-lg shadow flex flex-wrap gap-3 items-end text-sm sm:text-base">
        <div class="flex-1 min-w-[150px]">
            <label class="block mb-1 text-gray-700">🔍 بحث</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="ابحث عن نوع أو مستفيد أو جمعية"
                   class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-green-500">
        </div>

        <div class="min-w-[150px]">
            <label class="block mb-1 text-gray-700">نوع المساعدة</label>
            <select name="type"
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-green-500">
                <option value="">الكل</option>
                @foreach($types as $key=>$val)
                    <option value="{{ $key }}" @selected(request('type')==$key)>{{ $val }}</option>
                @endforeach
            </select>
        </div>

        <div class="min-w-[150px]">
            <label class="block mb-1 text-gray-700">من تاريخ</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
                   class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-green-500">
        </div>

        <div class="min-w-[150px]">
            <label class="block mb-1 text-gray-700">إلى تاريخ</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}"
                   class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-green-500">
        </div>

        <div class="flex gap-2 w-full sm:w-auto">
            <button type="submit"
                    class="flex-1 sm:flex-none px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 shadow">
                <i class="fa fa-search"></i> تصفية
            </button>
            <a href="{{ route('admin.aids.index') }}"
               class="flex-1 sm:flex-none px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                إعادة ضبط
            </a>
        </div>
    </form>

    {{-- ➕ Add Button --}}
    <div class="mb-4 flex justify-center sm:justify-start">
        <a href="{{ route('admin.aids.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2.5 sm:py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all shadow-md hover:shadow-lg text-sm sm:text-base font-semibold w-full sm:w-auto">
           <i class="fa fa-plus"></i>
           <span>إضافة مساعدة جديدة</span>
        </a>
    </div>

    {{-- 📱 Mobile Card View --}}
    <div class="block lg:hidden space-y-3">
        @forelse($aids as $aid)
        <div class="bg-white rounded-lg shadow-md p-4 border-r-4 border-green-500">
            <div class="flex justify-between items-start mb-3 pb-3 border-b">
                <div class="flex-1">
                    <span class="inline-block px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold mb-2">
                        {{ $types[$aid->aid_type] ?? $aid->aid_type }}
                    </span>
                    <h3 class="font-bold text-gray-800 text-sm">
                        المستفيد: {{ $aid->beneficiary?->first_name ?? '—' }}
                    </h3>
                </div>
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">#{{ $aid->id }}</span>
            </div>

            <div class="space-y-2 text-sm mb-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">الجمعية:</span>
                    <span class="font-semibold text-gray-800">{{ $aid->association?->name ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">المبلغ:</span>
                    <span class="font-semibold text-green-600">{{ $aid->amount ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">التاريخ:</span>
                    <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($aid->aid_date)->format('Y-m-d') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">أنشأ بواسطة:</span>
                    <span class="font-semibold text-gray-800">{{ $aid->creator?->name ?? '—' }}</span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex gap-2 pt-3 border-t">
                <a href="{{ route('admin.aids.show',$aid) }}"
                   class="flex-1 text-center py-2 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 transition text-sm font-semibold">
                    <i class="fa fa-eye ml-1"></i> عرض
                </a>
                <button type="button"
                        onclick="openEditModal({{ $aid->id }}, '{{ $aid->aid_type }}', '{{ $aid->amount }}', '{{ addslashes($aid->description ?? '') }}', '{{ $aid->aid_date }}')"
                        class="flex-1 text-center py-2 bg-yellow-50 text-yellow-600 rounded hover:bg-yellow-100 transition text-sm font-semibold">
                    <i class="fa fa-edit ml-1"></i> تعديل
                </button>
                <form action="{{ route('admin.aids.destroy',$aid) }}" method="POST" class="flex-1"
                      onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
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
            <p>لا توجد بيانات</p>
        </div>
        @endforelse
    </div>

    {{-- 💻 Desktop Table View --}}
    <div class="hidden lg:block overflow-x-auto bg-white rounded-lg shadow-md">
        <table class="min-w-full text-sm text-right">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100 text-sm border-b-2 border-gray-200">
                <tr class="text-gray-700">
                    <th class="p-4 font-bold whitespace-nowrap">#</th>
                    <th class="p-4 font-bold whitespace-nowrap">نوع المساعدة</th>
                    <th class="p-4 font-bold whitespace-nowrap">المستفيد</th>
                    <th class="p-4 font-bold whitespace-nowrap">الجمعية</th>
                    <th class="p-4 font-bold whitespace-nowrap">المبلغ</th>
                    <th class="p-4 font-bold whitespace-nowrap">التاريخ</th>
                    <th class="p-4 font-bold whitespace-nowrap">تم الإنشاء بواسطة</th>
                    <th class="p-4 font-bold whitespace-nowrap text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="text-sm divide-y divide-gray-100">
                @forelse($aids as $aid)
                <tr class="hover:bg-gray-50 transition">
                    <td class="p-4 font-semibold text-gray-600">{{ $aid->id }}</td>
                    <td class="p-4">
                        <span class="inline-block px-2 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">
                            {{ $types[$aid->aid_type] ?? $aid->aid_type }}
                        </span>
                    </td>
                    <td class="p-4 font-medium text-gray-800">{{ $aid->beneficiary?->first_name ?? '—' }}</td>
                    <td class="p-4 text-gray-700">{{ $aid->association?->name ?? '—' }}</td>
                    <td class="p-4 font-semibold text-green-600">{{ $aid->amount ?? '-' }}</td>
                    <td class="p-4 text-gray-700">{{ \Carbon\Carbon::parse($aid->aid_date)->format('Y-m-d') }}</td>
                    <td class="p-4 text-gray-700">{{ $aid->creator?->name ?? '—' }}</td>
                    <td class="p-4">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('admin.aids.show',$aid) }}"
                               class="text-blue-600 hover:text-blue-800 transition p-2 hover:bg-blue-50 rounded"
                               title="عرض">
                                <i class="fa fa-eye text-lg"></i>
                            </a>
                            <button type="button"
                                    onclick="openEditModal({{ $aid->id }}, '{{ $aid->aid_type }}', '{{ $aid->amount }}', '{{ addslashes($aid->description ?? '') }}', '{{ $aid->aid_date }}')"
                                    class="text-yellow-600 hover:text-yellow-800 transition p-2 hover:bg-yellow-50 rounded"
                                    title="تعديل">
                                <i class="fa fa-edit text-lg"></i>
                            </button>
                            <form action="{{ route('admin.aids.destroy',$aid) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
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
                    <td colspan="8" class="p-8 text-center text-gray-500">
                        <i class="fa fa-inbox text-4xl mb-3 text-gray-300 block"></i>
                        <p>لا توجد بيانات</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6 flex justify-center">
        {{ $aids->links() }}
    </div>
</div>

{{-- ✅ Edit Modal --}}
<div id="editModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50 p-4 backdrop-blur-sm">
    <div class="bg-white rounded-xl w-full max-w-lg max-h-[90vh] lg:max-h-[95vh] overflow-y-auto relative shadow-2xl animate-fadeIn">
        <button onclick="closeEditModal()" 
                class="absolute top-3 left-3 w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition z-10">
            <i class="fa fa-times text-lg"></i>
        </button>

        <div class="bg-gradient-to-r from-green-600 to-teal-500 text-white p-4 sm:p-6 rounded-t-xl">
            <h2 class="text-lg sm:text-xl font-bold flex items-center gap-2">
                <i class="fa fa-edit"></i>
                <span>تعديل المساعدة</span>
            </h2>
        </div>

        <form id="editForm" method="POST" class="p-4 sm:p-6 space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="fa fa-list ml-1 text-green-600"></i>
                    نوع المساعدة
                </label>
                <select name="aid_type" id="edit_aid_type"
                        class="w-full border border-gray-300 rounded-lg p-2.5 sm:p-3 text-sm sm:text-base focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                    @foreach($types as $key=>$val)
                        <option value="{{ $key }}">{{ $val }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="fa fa-dollar-sign ml-1 text-green-600"></i>
                    المبلغ
                </label>
                <input type="number" step="0.01" name="amount" id="edit_amount"
                       class="w-full border border-gray-300 rounded-lg p-2.5 sm:p-3 text-sm sm:text-base focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                       placeholder="أدخل المبلغ">
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="fa fa-align-right ml-1 text-green-600"></i>
                    الوصف
                </label>
                <textarea name="description" id="edit_description" rows="3"
                          class="w-full border border-gray-300 rounded-lg p-2.5 sm:p-3 text-sm sm:text-base focus:ring-2 focus:ring-green-500 focus:border-transparent transition resize-none"
                          placeholder="أدخل وصف المساعدة"></textarea>
            </div>

            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    <i class="fa fa-calendar ml-1 text-green-600"></i>
                    تاريخ المساعدة
                </label>
                <input type="date" name="aid_date" id="edit_aid_date"
                       class="w-full border border-gray-300 rounded-lg p-2.5 sm:p-3 text-sm sm:text-base focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
            </div>

            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-4 border-t">
                <button type="button" onclick="closeEditModal()"
                        class="w-full sm:w-auto px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm sm:text-base font-semibold">
                    <i class="fa fa-times ml-1"></i>
                    إلغاء
                </button>
                <button type="submit"
                        class="w-full sm:w-auto px-5 py-2.5 bg-gradient-to-r from-green-600 to-teal-500 text-white rounded-lg hover:from-green-700 hover:to-teal-600 transition text-sm sm:text-base font-semibold shadow-md">
                    <i class="fa fa-save ml-1"></i>
                    حفظ التغييرات
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, type, amount, desc, date) {
    const modal = document.getElementById('editModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';

    // Set form values
    document.getElementById('edit_aid_type').value = type || '';
    document.getElementById('edit_amount').value = amount || '';
    document.getElementById('edit_description').value = desc || '';
    document.getElementById('edit_aid_date').value = date || '';

    // CRITICAL FIX: Properly construct the update route with the ID
    // Laravel expects: PUT /admin/aids/{id}
    const form = document.getElementById('editForm');
    form.action = '/admin/aids/' + id;  // This creates /admin/aids/123
    
    console.log('✅ Form action set to:', form.action);
}

function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

// Close modal on Escape key
document.addEventListener('keydown', e => { 
    if (e.key === 'Escape') closeEditModal(); 
});

// Close modal on backdrop click
document.getElementById('editModal')?.addEventListener('click', e => { 
    if (e.target === e.currentTarget) closeEditModal(); 
});
function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeEditModal(); });
document.getElementById('editModal')?.addEventListener('click', e => { if (e.target === e.currentTarget) closeEditModal(); });
</script>

<style>
@keyframes fadeIn { from {opacity:0; transform:scale(0.95);} to {opacity:1; transform:scale(1);} }
.animate-fadeIn { animation: fadeIn 0.2s ease-out; }
</style>
@endsection
