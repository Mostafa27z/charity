<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BeneficiaryController extends Controller
{
    /**
     * عرض قائمة المستفيدين المرتبطين بجمعية المستخدم
     */
    public function index()
    {
        $beneficiaries = Beneficiary::where('association_id', Auth::user()->association_id)
            ->latest()
            ->paginate(10);

        return view('user.beneficiaries.index', compact('beneficiaries'));
    }

    /**
     * عرض فورم إضافة مستفيد
     */
    public function create()
    {
        return view('user.beneficiaries.create');
    }

    /**
     * تخزين مستفيد جديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'national_id' => 'required|string|max:20|unique:beneficiaries,national_id',
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

        $validated['association_id'] = Auth::user()->association_id;

        Beneficiary::create($validated);

        return redirect()
            ->route('user.beneficiaries.index')
            ->with('success', 'تم إضافة المستفيد بنجاح ✅');
    }

    /**
     * عرض بيانات مستفيد واحد
     */
    public function show(Beneficiary $beneficiary)
    {
        $this->authorizeBeneficiary($beneficiary);
        return view('user.beneficiaries.show', compact('beneficiary'));
    }

    /**
     * التحقق من أن المستفيد يخص نفس الجمعية
     */
    private function authorizeBeneficiary(Beneficiary $beneficiary)
    {
        if ($beneficiary->association_id !== Auth::user()->association_id) {
            abort(403, 'غير مسموح لك بعرض هذا المستفيد');
        }
    }
}
