@extends('layouts.user')
@section('title','تعديل مستفيد')
@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">تعديل بيانات المستفيد</h1>

    <form method="POST" action="{{ route('user.beneficiaries.update',$beneficiary) }}">
        @csrf
        @method('PUT')

        @include('user.beneficiaries.partials.form-fields',['beneficiary'=>$beneficiary])

        <button class="bg-blue-500 text-white px-4 py-2 rounded">تحديث</button>
    </form>
</div>
@endsection
