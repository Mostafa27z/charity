@extends('layouts.admin')

@section('title','إدارة المساعدات')

@section('content')
<div class="container mx-auto" dir="rtl">
    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <i class="fa-solid fa-hand-holding-heart text-green-600"></i>
        إدارة المساعدات
    </h1>

    {{-- رسائل نجاح --}}
    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- زر إضافة --}}
    <div class="mb-4">
        <a href="{{ route('admin.aids.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
           <i class="fa fa-plus"></i> إضافة مساعدة جديدة
        </a>
    </div>

    {{-- جدول المساعدات --}}
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm text-right">
            <thead class="bg-gray-100">
                <tr class="text-gray-700">
                    <th class="p-3">#</th>
                    <th class="p-3">نوع المساعدة</th>
                    <th class="p-3">المستفيد</th>
                    <th class="p-3">الجمعية</th>
                    <th class="p-3">المبلغ</th>
                    <th class="p-3">التاريخ</th>
                    <th class="p-3">تم الإنشاء بواسطة</th>
                    <th class="p-3">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aids as $aid)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $aid->id }}</td>
                    <td class="p-3">{{ $aid->aid_type }}</td>
                    <td class="p-3">{{ $aid->beneficiary?->first_name ?? '—' }}</td>
                    <td class="p-3">{{ $aid->association?->name ?? '—' }}</td>
                    <td class="p-3">{{ $aid->amount ?? '-' }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($aid->aid_date)->format('Y-m-d') }}</td>
                    <td class="p-3">{{ $aid->creator?->name ?? '—' }}</td>
                    <td class="p-3 space-x-2 space-x-reverse">
                        {{-- عرض --}}
                        <a href="{{ route('admin.aids.show',$aid) }}"
                           class="inline-block text-blue-600 hover:text-blue-800">
                            <i class="fa fa-eye"></i>
                        </a>
                        {{-- تعديل (يفتح مودال) --}}
                        <button type="button"
                                onclick="openEditModal({{ $aid->id }}, '{{ $aid->aid_type }}', '{{ $aid->amount }}', '{{ $aid->description }}', '{{ $aid->aid_date }}', '{{ $aid->beneficiary_id }}', '{{ $aid->association_id }}')"
                                class="inline-block text-yellow-600 hover:text-yellow-800">
                            <i class="fa fa-edit"></i>
                        </button>
                        {{-- حذف --}}
                        <form action="{{ route('admin.aids.destroy',$aid) }}" method="POST" class="inline-block"
                              onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:text-red-800">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="p-4 text-center text-gray-500">لا توجد بيانات</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $aids->links() }}
    </div>
</div>

{{-- ✅ مودال التعديل --}}
<div id="editModal" class="fixed inset-0 hidden items-center justify-center bg-black/40 z-50">
    <div class="bg-white rounded-lg w-full max-w-lg p-6 relative">
        <button onclick="closeEditModal()" class="absolute top-2 left-2 text-gray-600">
            <i class="fa fa-times"></i>
        </button>
        <h2 class="text-xl font-bold mb-4">تعديل المساعدة</h2>

        <form id="editForm" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label class="block mb-1">نوع المساعدة</label>
                <select name="aid_type" id="edit_aid_type"
                        class="w-full border rounded p-2">
                    <option value="financial">مالية</option>
                    <option value="food">غذائية</option>
                    <option value="medical">طبية</option>
                    <option value="education">تعليمية</option>
                    <option value="clothing">ملابس</option>
                    <option value="other">أخرى</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="block mb-1">المبلغ</label>
                <input type="number" step="0.01" name="amount" id="edit_amount"
                       class="w-full border rounded p-2">
            </div>

            <div class="mb-3">
                <label class="block mb-1">الوصف</label>
                <textarea name="description" id="edit_description"
                          class="w-full border rounded p-2"></textarea>
            </div>

            <div class="mb-3">
                <label class="block mb-1">تاريخ المساعدة</label>
                <input type="date" name="aid_date" id="edit_aid_date"
                       class="w-full border rounded p-2">
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-400 text-white rounded">
                    إلغاء
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    حفظ التغييرات
                </button>
            </div>
        </form>
    </div>
</div>

{{-- JS Modal --}}
<script>
function openEditModal(id, type, amount, desc, date) {
    const modal = document.getElementById('editModal');
    modal.classList.remove('hidden','opacity-0');

    document.getElementById('edit_aid_type').value = type;
    document.getElementById('edit_amount').value = amount;
    document.getElementById('edit_description').value = desc;
    document.getElementById('edit_aid_date').value = date;

    document.getElementById('editForm').action =
        "{{ url('admin/aids') }}/" + id;
}
function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>
@endsection
