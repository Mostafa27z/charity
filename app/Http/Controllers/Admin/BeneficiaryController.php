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
    public function index()
    {
        $beneficiaries = Beneficiary::with(['relatives','association'])->paginate(10);
        return view('admin.beneficiaries.index', compact('beneficiaries'));
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
    $validated = $request->validate([
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
        // relatives is array
        'relatives.*.name'         => 'nullable|string|max:255',
        'relatives.*.national_id'  => 'nullable|string|max:20',
        'relatives.*.gender'       => 'nullable|in:male,female',
        'relatives.*.birth_date'   => 'nullable|date',
        'relatives.*.phone'        => 'nullable|string|max:20',
        'relatives.*.relation_type'=> 'nullable|string|max:100',
        'relatives.*.notes'        => 'nullable|string',
    ]);

    $beneficiary = Beneficiary::create($validated);

    if($request->has('relatives')){
        foreach ($request->relatives as $rel) {
            if (!empty($rel['name'])) {
                $beneficiary->relatives()->create($rel);
            }
        }
    }

    return redirect()
        ->route('admin.beneficiaries.show', $beneficiary->id)
        ->with('success', 'تم إضافة المستفيد بنجاح ✅');
}

// ✅ تحديث مع الأقارب
public function update(Request $request, Beneficiary $beneficiary)
{
    $validated = $request->validate([
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
        'relatives.*.name'         => 'nullable|string|max:255',
        'relatives.*.national_id'  => 'nullable|string|max:20',
        'relatives.*.gender'       => 'nullable|in:male,female',
        'relatives.*.birth_date'   => 'nullable|date',
        'relatives.*.phone'        => 'nullable|string|max:20',
        'relatives.*.relation_type'=> 'nullable|string|max:100',
        'relatives.*.notes'        => 'nullable|string',
    ]);

    $beneficiary->update($validated);

    // احذف الأقارب القدامى ثم أضف الجدد
    $beneficiary->relatives()->delete();
    if($request->has('relatives')){
        foreach ($request->relatives as $rel) {
            if (!empty($rel['name'])) {
                $beneficiary->relatives()->create($rel);
            }
        }
    }

    return redirect()
        ->route('admin.beneficiaries.show', $beneficiary->id)
        ->with('success', 'تم تحديث المستفيد بنجاح ✏️');
}
public function show(Beneficiary $beneficiary)
    {
        $beneficiary->load(['relatives','association']);
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
