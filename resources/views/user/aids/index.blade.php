@extends('layouts.user')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">قائمة المساعدات </h1>

    <a href="{{ route('user.aids.create') }}" class="bg-green-500 text-white px-4 py-2 rounded">إضافة مساعدة</a>

    <table class="table-auto w-full mt-4 border">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">المستفيد</th>
                <th class="px-4 py-2">النوع</th>
                <th class="px-4 py-2">القيمة</th>
                <th class="px-4 py-2">التاريخ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($aids as $aid)
            <tr>
                <td class="border px-4 py-2">{{ $aid->beneficiary->first_name ?? '' }}</td>
                <td class="border px-4 py-2">{{ $aid->aid_type }}</td>
                <td class="border px-4 py-2">{{ $aid->amount }}</td>
                <td class="border px-4 py-2">{{ $aid->aid_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $aids->links() }}
</div>
@endsection
