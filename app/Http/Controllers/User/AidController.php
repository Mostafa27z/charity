<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Aid;
use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AidController extends Controller
{
    public function index(Request $request)
{
    $query = Aid::where('association_id', Auth::user()->association_id)
    ->with(['beneficiary', 'association'])
    ->latest();

    // 🔎 Search by beneficiary name or national_id
    if ($search = $request->input('search')) {
    $query->whereHas('beneficiary', function ($q) use ($search) {
        $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
          ->orWhere('first_name', 'like', "%{$search}%")
          ->orWhere('last_name', 'like', "%{$search}%")
          ->orWhere('national_id', 'like', "%{$search}%");
    });
}


    // ⚙️ Filter by aid_type
    if ($type = $request->input('type')) {
        $query->where('aid_type', $type);
    }

    // 💰 Filter by amount range
    if ($min = $request->input('min_amount')) {
        $query->where('amount', '>=', $min);
    }
    if ($max = $request->input('max_amount')) {
        $query->where('amount', '<=', $max);
    }

    $aids = $query->paginate(10)->withQueryString();

    // Types (with Arabic translations)
    $types = [
        'financial' => 'مالية',
        'food'      => 'غذائية',
        'medical'   => 'طبية',
        'education' => 'تعليمية',
        'clothing'  => 'ملابس',
        'other'     => 'أخرى',
    ];

    return view('user.aids.index', compact('aids','types'));
}


    public function create()
    {
        $beneficiaries = Beneficiary::all();
        return view('user.aids.create', compact('beneficiaries'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'beneficiary_id' => 'required|exists:beneficiaries,id',
            'aid_type'       => 'required|string|max:255',
            'amount'         => 'required|numeric|min:0',
            'description'    => 'nullable|string',
            'aid_date'       => 'required|date'
        ]);

        $data['created_by'] = Auth::id();
        $data['association_id'] = Auth::user()->association_id ?? null;

        Aid::create($data);

        return redirect()->route('user.aids.index')->with('success', 'تم إنشاء المساعدة بنجاح');
    }

    /** ✅ Show a single aid + beneficiary details */
    public function show(Aid $aid)
    {
        $this->authorizeOwner($aid);

        $aid->load('beneficiary', 'association');
        return view('user.aids.show', compact('aid'));
    }

    /** ✅ Edit form */
    public function edit(Aid $aid)
    {
        $this->authorizeOwner($aid);

        $beneficiaries = Beneficiary::all();
        return view('user.aids.edit', compact('aid', 'beneficiaries'));
    }

    /** ✅ Update record */
    public function update(Request $request, Aid $aid)
    {
        $this->authorizeOwner($aid);

        $data = $request->validate([
            'beneficiary_id' => 'required|exists:beneficiaries,id',
            'aid_type'       => 'required|string|max:255',
            'amount'         => 'required|numeric|min:0',
            'description'    => 'nullable|string',
            'aid_date'       => 'required|date'
        ]);

        $aid->update($data);

        return redirect()->route('user.aids.index')->with('success', 'تم تعديل المساعدة بنجاح');
    }

    /** ✅ Security: ensure user owns the record */
    private function authorizeOwner(Aid $aid)
    {
        if ($aid->created_by !== Auth::id() && $aid->association_id !== Auth::user()->association_id) {
            abort(403, 'غير مسموح بالوصول');
        }
    }
}
