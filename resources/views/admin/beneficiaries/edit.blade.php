@extends('layouts.admin')
@section('title','تعديل مستفيد')

@section('content')
<div class="container mx-auto" dir="rtl">
    <h1 class="text-2xl font-bold mb-6">✏️ تعديل مستفيد</h1>

    <form method="POST" action="{{ route('admin.beneficiaries.update',$beneficiary) }}">
        @csrf @method('PUT')

        {{-- بيانات المستفيد --}}
        <div class="grid grid-cols-2 gap-4">
            <x-input name="national_id" label="الرقم القومي" value="{{ old('national_id',$beneficiary->national_id) }}" required/>
            <x-input name="first_name" label="الاسم الأول" value="{{ old('first_name',$beneficiary->first_name) }}" required/>
            <x-input name="last_name" label="اسم العائلة" value="{{ old('last_name',$beneficiary->last_name) }}" required/>
            <x-select name="association_id" label="الجمعية" :options="$associations->pluck('name','id')" 
                      selected="{{ old('association_id',$beneficiary->association_id) }}" required/>
            <x-select name="gender" label="النوع" :options="['male'=>'ذكر','female'=>'أنثى']" 
                      selected="{{ old('gender',$beneficiary->gender) }}"/>
            <x-input name="birth_date" type="date" label="تاريخ الميلاد" 
                     value="{{ old('birth_date',$beneficiary->birth_date) }}"/>
            <x-input name="phone" label="الهاتف" value="{{ old('phone',$beneficiary->phone) }}"/>
            <x-input name="address" label="العنوان" value="{{ old('address',$beneficiary->address) }}"/>
            <x-input name="family_size" type="number" label="حجم الأسرة" 
                     value="{{ old('family_size',$beneficiary->family_size) }}"/>
            <x-input name="income" type="number" label="الدخل" 
                     value="{{ old('income',$beneficiary->income) }}"/>
            <x-textarea name="notes" label="ملاحظات">{{ old('notes',$beneficiary->notes) }}</x-textarea>
        </div>

        {{-- الأقارب --}}
        <h2 class="text-lg font-semibold mt-6 mb-2">👨‍👩‍👧‍👦 الأقارب</h2>
        <div id="relatives-wrapper" class="space-y-4">
            @foreach($beneficiary->relatives as $i=>$rel)
                <div class="relative-item grid grid-cols-2 gap-4 border p-3 rounded bg-gray-50">
                    {{-- hidden id لتحديث القريب عند الحفظ --}}
                    <input type="hidden" name="relatives[{{ $i }}][id]" value="{{ $rel->id }}">

                    <input name="relatives[{{ $i }}][name]" value="{{ $rel->name }}" 
                           class="border p-2 rounded" placeholder="اسم القريب" required>
                    <input name="relatives[{{ $i }}][national_id]" value="{{ $rel->national_id }}" 
                           class="border p-2 rounded" placeholder="رقم قومي">
                    <select name="relatives[{{ $i }}][gender]" class="border p-2 rounded">
                        <option value="">النوع</option>
                        <option value="male" @selected($rel->gender=='male')>ذكر</option>
                        <option value="female" @selected($rel->gender=='female')>أنثى</option>
                    </select>
                    <input type="date" name="relatives[{{ $i }}][birth_date]" 
                           value="{{ $rel->birth_date }}" class="border p-2 rounded">
                    <input name="relatives[{{ $i }}][phone]" value="{{ $rel->phone }}" 
                           class="border p-2 rounded" placeholder="هاتف">
                    <input name="relatives[{{ $i }}][relation_type]" value="{{ $rel->relation_type }}" 
                           class="border p-2 rounded" placeholder="صلة القرابة" required>
                    <textarea name="relatives[{{ $i }}][notes]" class="border p-2 rounded" 
                              placeholder="ملاحظات">{{ $rel->notes }}</textarea>

                    {{-- زر حذف القريب من الفورم قبل الإرسال --}}
                    <button type="button" class="remove-relative bg-red-500 text-white px-2 py-1 rounded">❌ حذف</button>
                </div>
            @endforeach
        </div>

        <button type="button" id="add-relative"
                class="mt-2 px-3 py-1 bg-blue-600 text-white rounded">➕ إضافة قريب</button>

        <button type="submit"
                class="block mt-6 bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">💾 تحديث</button>
    </form>
</div>

{{-- سكريبت لإضافة/حذف الأقارب قبل الإرسال --}}
<script>
document.getElementById('add-relative').addEventListener('click', function(){
    const wrapper = document.getElementById('relatives-wrapper');
    const index = wrapper.children.length;
    wrapper.insertAdjacentHTML('beforeend', `
        <div class="relative-item grid grid-cols-2 gap-4 border p-3 rounded bg-gray-50">
            <input name="relatives[${index}][name]" class="border p-2 rounded" placeholder="اسم القريب" required>
            <input name="relatives[${index}][national_id]" class="border p-2 rounded" placeholder="رقم قومي">
            <select name="relatives[${index}][gender]" class="border p-2 rounded">
                <option value="">النوع</option>
                <option value="male">ذكر</option>
                <option value="female">أنثى</option>
            </select>
            <input type="date" name="relatives[${index}][birth_date]" class="border p-2 rounded">
            <input name="relatives[${index}][phone]" class="border p-2 rounded" placeholder="هاتف">
            <input name="relatives[${index}][relation_type]" class="border p-2 rounded" placeholder="صلة القرابة" required>
            <textarea name="relatives[${index}][notes]" class="border p-2 rounded" placeholder="ملاحظات"></textarea>
            <button type="button" class="remove-relative bg-red-500 text-white px-2 py-1 rounded">❌ حذف</button>
        </div>
    `);
});

document.addEventListener('click',function(e){
    if(e.target.classList.contains('remove-relative')){
        e.target.closest('.relative-item').remove();
    }
});
</script>
@endsection
