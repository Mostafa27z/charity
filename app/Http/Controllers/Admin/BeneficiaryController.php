<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\Beneficiary;
use Illuminate\Http\Request;

class BeneficiaryController extends Controller
{
    /**
     * عرض كل المستفيدين.
     */
    public function index(Request $request)
{
    // استعلام أساسي
    $query = \App\Models\Beneficiary::with(['relatives', 'association']);

    // ✅ البحث بالنص (الرقم القومي أو الاسم)
    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('national_id', 'like', "%{$search}%")
              ->orWhere('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%");
        });
    }

    // ✅ فلترة الجمعية
    if ($associationId = $request->input('association_id')) {
        $query->where('association_id', $associationId);
    }

    // ✅ فلترة الجنس
    if ($gender = $request->input('gender')) {
        $query->where('gender', $gender);
    }

    $beneficiaries = $query->paginate(10)->withQueryString();
    $associations  = \App\Models\Association::pluck('name','id');

    return view('admin.beneficiaries.index', compact('beneficiaries','associations'));
}

    /**
     * عرض فورم الإضافة.
     */
    public function create()
    {
        $associations = Association::all();
        return view('admin.beneficiaries.create', compact('associations'));
    }

    /**
     * تخزين مستفيد جديد.
     */
    // ✅ تخزين مستفيد جديد مع أقارب
public function store(Request $request)
{
    // ✅ نفصل التحقق بين بيانات المستفيد والأقارب
    $validatedBeneficiary = $request->validate([
        'association_id' => 'required|exists:associations,id',
        'national_id'    => 'required|string|max:20|unique:beneficiaries,national_id',
        'first_name'     => 'required|string|max:255',
        'last_name'      => 'required|string|max:255',
        'gender'         => 'nullable|in:male,female',
        'birth_date'     => 'nullable|date',
        'phone'          => 'nullable|string|max:20',
        'address'        => 'nullable|string',
        'family_size'    => 'nullable|integer',
        'income'         => 'nullable|numeric',
        'notes'          => 'nullable|string',
    ]);

    // ننشئ المستفيد أولاً
    $beneficiary = Beneficiary::create($validatedBeneficiary);

    // ✅ تحقق من الأقارب (لو فيه بيانات)
    if ($request->has('relatives')) {
        foreach ($request->relatives as $rel) {
    $relData = validator($rel, [
        'name'          => 'required|string|max:255',
        'national_id'   => 'nullable|string|max:20',
        'gender'        => 'nullable|in:male,female',
        'birth_date'    => 'nullable|date',
        'phone'         => 'nullable|string|max:20',
        'relation_type' => 'required|string|max:100',
        'notes'         => 'nullable|string',
    ])->validate();

    if (!empty($relData['national_id']) &&
        \App\Models\BeneficiaryRelative::where('national_id',$relData['national_id'])->exists()) {
        return back()->withErrors([
            'relatives' => "⚠️ الرقم القومي {$relData['national_id']} مستخدم بالفعل."
        ])->withInput();
    }

    $beneficiary->relatives()->create($relData);
}

    }

    return redirect()
        ->route('admin.beneficiaries.index')
        ->with('success', '✅ تم إضافة المستفيد والأقارب بنجاح');
}

// ✅ تحديث مع الأقارب
public function update(Request $request, Beneficiary $beneficiary)
{
    // 1️⃣ تحقق من بيانات المستفيد
    $validatedBeneficiary = $request->validate([
        'association_id' => 'required|exists:associations,id',
        'national_id'    => 'required|string|max:20|unique:beneficiaries,national_id,' . $beneficiary->id,
        'first_name'     => 'required|string|max:255',
        'last_name'      => 'required|string|max:255',
        'gender'         => 'nullable|in:male,female',
        'birth_date'     => 'nullable|date',
        'phone'          => 'nullable|string|max:20',
        'address'        => 'nullable|string',
        'family_size'    => 'nullable|integer',
        'income'         => 'nullable|numeric',
        'notes'          => 'nullable|string',
    ]);

    // 2️⃣ تحديث بيانات المستفيد
    $beneficiary->update($validatedBeneficiary);

    // 3️⃣ إدارة الأقارب
    $existingIds = [];
    if ($request->has('relatives')) {
        foreach ($request->relatives as $rel) {

            $relData = validator($rel, [
                'id'            => 'nullable|integer|exists:beneficiary_relatives,id',
                'name'          => 'required|string|max:255',
                'national_id'   => 'nullable|string|max:20',
                'gender'        => 'nullable|in:male,female',
                'birth_date'    => 'nullable|date',
                'phone'         => 'nullable|string|max:20',
                'relation_type' => 'required|string|max:100',
                'notes'         => 'nullable|string',
            ])->validate();

            // تحديث لو id موجود
            if (!empty($relData['id'])) {
                $relative = $beneficiary->relatives()->find($relData['id']);
                if ($relative) {
                    $relative->update($relData);
                    $existingIds[] = $relative->id;
                }
            } else {
                // إنشاء جديد
                $new = $beneficiary->relatives()->create($relData);
                $existingIds[] = $new->id;
            }
        }
    }

    // 4️⃣ حذف الأقارب الذين لم يتم إرسالهم (تم حذفهم من الفورم)
    $beneficiary->relatives()->whereNotIn('id', $existingIds)->delete();

    return redirect()
        ->route('admin.beneficiaries.show', $beneficiary->id)
        ->with('success', '✅ تم تحديث المستفيد والأقارب بنجاح');
}

public function show(Beneficiary $beneficiary)
{
    $beneficiary->load(['relatives','association','aids.association']);
    return view('admin.beneficiaries.show', compact('beneficiary'));
}

    public function edit(Beneficiary $beneficiary)
    {
        $associations = Association::all();
        return view('admin.beneficiaries.edit', compact('beneficiary','associations'));
    }

    /**
     * حذف مستفيد.
     */
    public function destroy(Beneficiary $beneficiary)
    {
        $beneficiary->delete();

        return redirect()
            ->route('admin.beneficiaries.index')
            ->with('success', 'تم حذف المستفيد 🗑️');
    }
}
