@props([
    'name',
    'label' => '',
    'options' => [],   // ['value'=>'label']
    'selected' => '',
    'required' => false,
])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block mb-1 font-medium text-gray-700">{{ $label }}</label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class'=>'border rounded w-full p-2 focus:outline-none focus:ring focus:border-blue-300']) }}
    >
        <option value="">-- اختر --</option>
        @foreach($options as $value => $text)
            <option value="{{ $value }}" @selected(old($name, $selected) == $value)>
                {{ $text }}
            </option>
        @endforeach
    </select>

    @error($name)
        <span class="text-red-600 text-sm">{{ $message }}</span>
    @enderror
</div>
