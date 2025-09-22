@extends('layouts.admin')

@section('title','تعديل الجمعية')

@section('content')
<div class="container mx-auto" dir="rtl">
    <h1 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <i class="fa-solid fa-pen-to-square text-yellow-600"></i>
        تعديل بيانات الجمعية
    </h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <strong>⚠️ حدثت بعض الأخطاء:</strong>
            <ul class="list-disc mr-5 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow rounded p-6">
        <form action="{{ route('admin.associations.update', $association) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            {{-- اسم الجمعية --}}
            <div>
                <label class="block font-semibold text-gray-700 mb-1">
                    <i class="fa fa-building text-purple-600"></i> اسم الجمعية
                </label>
                <input type="text" name="name"
                       value="{{ old('name', $association->name) }}"
                       class="w-full border rounded p-2 focus:outline-none focus:ring focus:border-blue-400" required>
            </div>

            {{-- رقم التسجيل --}}
            <div>
                <label class="block font-semibold text-gray-700 mb-1">
                    <i class="fa fa-id-card text-blue-600"></i> رقم التسجيل
                </label>
                <input type="text" name="registration_number"
                       value="{{ old('registration_number', $association->registration_number) }}"
                       class="w-full border rounded p-2 focus:outline-none focus:ring focus:border-blue-400">
            </div>

            {{-- البريد الإلكتروني --}}
            <div>
                <label class="block font-semibold text-gray-700 mb-1">
                    <i class="fa fa-envelope text-red-600"></i> البريد الإلكتروني
                </label>
                <input type="email" name="email"
                       value="{{ old('email', $association->email) }}"
                       class="w-full border rounded p-2 focus:outline-none focus:ring focus:border-blue-400" required>
            </div>

            {{-- الهاتف --}}
            <div>
                <label class="block font-semibold text-gray-700 mb-1">
                    <i class="fa fa-phone text-green-600"></i> الهاتف
                </label>
                <input type="text" name="phone"
                       value="{{ old('phone', $association->phone) }}"
                       class="w-full border rounded p-2 focus:outline-none focus:ring focus:border-blue-400">
            </div>

            {{-- العنوان --}}
            <div>
                <label class="block font-semibold text-gray-700 mb-1">
                    <i class="fa fa-map-marker-alt text-orange-600"></i> العنوان
                </label>
                <textarea name="address"
                          class="w-full border rounded p-2 focus:outline-none focus:ring focus:border-blue-400"
                          rows="3">{{ old('address', $association->address) }}</textarea>
            </div>

            {{-- الحالة --}}
            <div>
                <label class="block font-semibold text-gray-700 mb-1">
                    <i class="fa fa-toggle-on text-teal-600"></i> الحالة
                </label>
                <select name="status"
                        class="w-full border rounded p-2 focus:outline-none focus:ring focus:border-blue-400" required>
                    <option value="active" {{ old('status', $association->status) === 'active' ? 'selected' : '' }}>
                        نشطة
                    </option>
                    <option value="inactive" {{ old('status', $association->status) === 'inactive' ? 'selected' : '' }}>
                        غير نشطة
                    </option>
                </select>
            </div>

            {{-- أزرار التحكم --}}
            <div class="flex gap-3 pt-4">
                <a href="{{ route('admin.associations.index') }}"
                   class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    <i class="fa fa-arrow-right"></i> إلغاء
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                    <i class="fa fa-save"></i> حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
