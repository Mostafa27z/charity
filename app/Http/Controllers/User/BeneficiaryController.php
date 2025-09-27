<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\Aid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BeneficiaryController extends Controller
{
    /** 📋 Show all beneficiaries (public view, but editable only if same association) */
    public function index(Request $request)
    {
        $query = Beneficiary::query();

        // 🔍 Search by National ID or Full Name
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('national_id', 'like', "%{$search}%")
                  ->orWhereRaw("CONCAT(first_name,' ',last_name) LIKE ?", ["%{$search}%"]);
            });
        }

        // ♂️♀️ Filter by gender
        if ($gender = $request->input('gender')) {
            $query->where('gender', $gender);
        }

        // 💵 Filter by income range
        if ($minIncome = $request->input('min_income')) {
            $query->where('income', '>=', $minIncome);
        }
        if ($maxIncome = $request->input('max_income')) {
            $query->where('income', '<=', $maxIncome);
        }

        $beneficiaries = $query->latest()->paginate(10)->appends($request->query());

        return view('user.beneficiaries.index', compact('beneficiaries'));
    }

    /** ➕ Create */
    public function create()
    {
        return view('user.beneficiaries.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);
        $validated['association_id'] = Auth::user()->association_id;

        Beneficiary::create($validated);

        return redirect()->route('user.beneficiaries.index')
            ->with('success', 'تم إضافة المستفيد بنجاح ✅');
    }

    /** 👁 Show Beneficiary + related aids (popup) */
    public function show(Beneficiary $beneficiary)
    {
        // No association restriction here (view allowed for all)
        $aids = Aid::where('beneficiary_id', $beneficiary->id)
            ->with('association')
            ->latest()
            ->get();

        return view('user.beneficiaries.show', compact('beneficiary','aids'));
    }

    /** ✏️ Edit only if same association */
    public function edit(Beneficiary $beneficiary)
    {
        $this->authorizeAssociation($beneficiary);
        return view('user.beneficiaries.edit', compact('beneficiary'));
    }

    public function update(Request $request, Beneficiary $beneficiary)
    {
        $this->authorizeAssociation($beneficiary);

        $validated = $this->validateData($request, $beneficiary->id);
        $beneficiary->update($validated);

        return redirect()->route('user.beneficiaries.index')
            ->with('success', 'تم تحديث بيانات المستفيد ✅');
    }

    /** 🔒 Check association */
    private function authorizeAssociation(Beneficiary $beneficiary)
    {
        if ($beneficiary->association_id !== Auth::user()->association_id) {
            abort(403, 'غير مسموح لك بتعديل هذا المستفيد');
        }
    }

    private function validateData(Request $request, $id = null)
    {
        return $request->validate([
            'national_id' => 'required|string|max:20|unique:beneficiaries,national_id,' . $id,
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'gender'      => 'nullable|in:male,female',
            'birth_date'  => 'nullable|date',
            'phone'       => 'nullable|string|max:20',
            'address'     => 'nullable|string',
            'family_size' => 'nullable|integer',
            'income'      => 'nullable|numeric',
            'notes'       => 'nullable|string',
        ]);
    }
}
