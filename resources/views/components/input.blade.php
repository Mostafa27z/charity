@props([
    'label' => '',      // اسم الحقل (الذي يظهر للمستخدم)
    'name' => '',       // اسم الـ input (مطلوب)
    'type' => 'text',   // نوع الحقل (text, email, password...)
    'value' => '',      // القيمة الافتراضية
    'required' => false // هل الحقل مطلوب
])

<div class="mb-4">
    {{-- Label --}}
    @if($label)
        <label for="{{ $name }}" class="block mb-1 text-gray-700 font-medium">
            {{ $label }}
        </label>
    @endif

    {{-- Input --}}
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge([
            'class' => 'w-full border rounded p-2 focus:outline-none focus:ring focus:border-blue-400'
        ]) }}
    >

    {{-- Validation Error --}}
    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
