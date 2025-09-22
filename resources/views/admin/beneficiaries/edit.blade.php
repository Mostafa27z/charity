@extends('layouts.admin')
@section('title','تعديل مستفيد')

@section('content')
<div class="container mx-auto" dir="rtl">
    <h1 class="text-2xl font-bold mb-6">✏️ تعديل مستفيد</h1>

    <form method="POST" action="{{ route('admin.beneficiaries.update',$beneficiary) }}">
        @csrf @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <x-input name="national_id" label="الرقم القومي" value="{{ $beneficiary->national_id }}" required/>
            <x-input name="first_name" label="الاسم الأول" value="{{ $beneficiary->first_name }}" required/>
            <x-input name="last_name" label="اسم العائلة" value="{{ $beneficiary->last_name }}" required/>
            <x-select name="association_id" label="الجمعية" :options="$associations->pluck('name','id')" selected="{{ $beneficiary->association_id }}" required/>
            <x-select name="gender" label="النوع" :options="['male'=>'ذكر','female'=>'أنثى']" selected="{{ $beneficiary->gender }}"/>
            <x-input name="birth_date" type="date" label="تاريخ الميلاد" value="{{ $beneficiary->birth_date }}"/>
            <x-input name="phone" label="الهاتف" value="{{ $beneficiary->phone }}"/>
            <x-input name="address" label="العنوان" value="{{ $beneficiary->address }}"/>
            <x-input name="family_size" type="number" label="حجم الأسرة" value="{{ $beneficiary->family_size }}"/>
            <x-input name="income" type="number" label="الدخل" value="{{ $beneficiary->income }}"/>
            <x-textarea name="notes" label="ملاحظات">{{ $beneficiary->notes }}</x-textarea>
        </div>

        <h2 class="text-lg font-semibold mt-6 mb-2">👨‍👩‍👧‍👦 الأقارب</h2>
        <div id="relatives-wrapper" class="space-y-4">
            @foreach($beneficiary->relatives as $i=>$rel)
                <div class="grid grid-cols-2 gap-4 border p-3 rounded bg-gray-50">
                    <input name="relatives[{{ $i }}][name]" value="{{ $rel->name }}" class="border p-2 rounded">
                    <input name="relatives[{{ $i }}][national_id]" value="{{ $rel->national_id }}" class="border p-2 rounded">
                    <select name="relatives[{{ $i }}][gender]" class="border p-2 rounded">
                        <option value="">النوع</option>
                        <option value="male" @selected($rel->gender=='male')>ذكر</option>
                        <option value="female" @selected($rel->gender=='female')>أنثى</option>
                    </select>
                    <input type="date" name="relatives[{{ $i }}][birth_date]" value="{{ $rel->birth_date }}" class="border p-2 rounded">
                    <input name="relatives[{{ $i }}][phone]" value="{{ $rel->phone }}" class="border p-2 rounded">
                    <input name="relatives[{{ $i }}][relation_type]" value="{{ $rel->relation_type }}" class="border p-2 rounded">
                    <textarea name="relatives[{{ $i }}][notes]" class="border p-2 rounded">{{ $rel->notes }}</textarea>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-relative"
                class="mt-2 px-3 py-1 bg-blue-600 text-white rounded">➕ إضافة قريب</button>

        <button type="submit"
                class="block mt-6 bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">تحديث</button>
    </form>
</div>

<script>
document.getElementById('add-relative').addEventListener('click', function(){
    const wrapper = document.getElementById('relatives-wrapper');
    const index = wrapper.children.length;
    wrapper.insertAdjacentHTML('beforeend', `
        <div class="grid grid-cols-2 gap-4 border p-3 rounded bg-gray-50">
            <input name="relatives[${index}][name]" class="border p-2 rounded" placeholder="اسم القريب">
            <input name="relatives[${index}][national_id]" class="border p-2 rounded" placeholder="رقم قومي">
            <select name="relatives[${index}][gender]" class="border p-2 rounded">
                <option value="">النوع</option>
                <option value="male">ذكر</option>
                <option value="female">أنثى</option>
            </select>
            <input type="date" name="relatives[${index}][birth_date]" class="border p-2 rounded">
            <input name="relatives[${index}][phone]" class="border p-2 rounded" placeholder="هاتف">
            <input name="relatives[${index}][relation_type]" class="border p-2 rounded" placeholder="صلة القرابة">
            <textarea name="relatives[${index}][notes]" class="border p-2 rounded" placeholder="ملاحظات"></textarea>
        </div>
    `);
});
</script>
@endsection
