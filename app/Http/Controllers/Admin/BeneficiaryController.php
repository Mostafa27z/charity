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
        ]);

        $beneficiary = Beneficiary::create($validated);

        return redirect()
            ->route('admin.beneficiaries.show', $beneficiary->id)
            ->with('success', 'تم إضافة المستفيد بنجاح ✅');
    }

    /**
     * عرض مستفيد واحد.
     */
    public function show(Beneficiary $beneficiary)
    {
        $beneficiary->load(['relatives','association']);
        return view('admin.beneficiaries.show', compact('beneficiary'));
    }

    /**
     * عرض فورم التعديل.
     */
    public function edit(Beneficiary $beneficiary)
    {
        $associations = Association::all();
        return view('admin.beneficiaries.edit', compact('beneficiary','associations'));
    }

    /**
     * تحديث مستفيد.
     */
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
        ]);

        $beneficiary->update($validated);

        return redirect()
            ->route('admin.beneficiaries.show', $beneficiary->id)
            ->with('success', 'تم تحديث المستفيد بنجاح ✏️');
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
