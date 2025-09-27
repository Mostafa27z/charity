@php
    $b = $beneficiary ?? null;
@endphp

<div class="mb-4">
    <label class="block">الرقم القومي</label>
    <input type="text" name="national_id" value="{{ old('national_id', $b->national_id ?? '') }}"
           class="border p-2 w-full" required>
</div>

<div class="mb-4">
    <label class="block">الاسم الأول</label>
    <input type="text" name="first_name" value="{{ old('first_name', $b->first_name ?? '') }}"
           class="border p-2 w-full" required>
</div>

<div class="mb-4">
    <label class="block">اسم العائلة</label>
    <input type="text" name="last_name" value="{{ old('last_name', $b->last_name ?? '') }}"
           class="border p-2 w-full" required>
</div>

<div class="mb-4">
    <label class="block">الجنس</label>
    <select name="gender" class="border p-2 w-full">
        <option value="">-- اختر --</option>
        <option value="male" {{ old('gender',$b->gender ?? '')=='male'?'selected':'' }}>ذكر</option>
        <option value="female" {{ old('gender',$b->gender ?? '')=='female'?'selected':'' }}>أنثى</option>
    </select>
</div>

<div class="mb-4">
    <label class="block">تاريخ الميلاد</label>
    <input type="date" name="birth_date" value="{{ old('birth_date', $b->birth_date ?? '') }}"
           class="border p-2 w-full">
</div>

<div class="mb-4">
    <label class="block">الهاتف</label>
    <input type="text" name="phone" value="{{ old('phone', $b->phone ?? '') }}"
           class="border p-2 w-full">
</div>

<div class="mb-4">
    <label class="block">العنوان</label>
    <textarea name="address" class="border p-2 w-full">{{ old('address', $b->address ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label class="block">حجم الأسرة</label>
    <input type="number" name="family_size" value="{{ old('family_size', $b->family_size ?? '') }}"
           class="border p-2 w-full">
</div>

<div class="mb-4">
    <label class="block">الدخل</label>
    <input type="number" step="0.01" name="income" value="{{ old('income', $b->income ?? '') }}"
           class="border p-2 w-full">
</div>

<div class="mb-4">
    <label class="block">ملاحظات</label>
    <textarea name="notes" class="border p-2 w-full">{{ old('notes', $b->notes ?? '') }}</textarea>
</div>
