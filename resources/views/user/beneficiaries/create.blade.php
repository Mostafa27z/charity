@extends('layouts.user')
@section('title','إضافة مستفيد')
@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">إضافة مستفيد جديد</h1>

    <form method="POST" action="{{ route('user.beneficiaries.store') }}">
        @csrf

        @include('user.beneficiaries.partials.form-fields')

        <button class="bg-blue-500 text-white px-4 py-2 rounded">حفظ</button>
    </form>
</div>
@endsection
