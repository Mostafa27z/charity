<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aid;
use App\Models\Association;
use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AidController extends Controller
{
    /**
     * عرض كل المساعدات.
     */
    public function index(Request $request)
{
    $query = Aid::with(['beneficiary', 'association', 'creator']);

    // 🔍 Search by aid type, beneficiary, association, or creator name
    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('aid_type', 'like', "%{$search}%")
              ->orWhereHas('beneficiary', fn($b) => $b->where('first_name', 'like', "%{$search}%"))
              ->orWhereHas('association', fn($a) => $a->where('name', 'like', "%{$search}%"))
              ->orWhereHas('creator', fn($c) => $c->where('name', 'like', "%{$search}%"));
        });
    }

    // 🏷️ Filter by aid type
    if ($type = $request->input('type')) {
        $query->where('aid_type', $type);
    }

    // 📅 Filter by date range
    if ($from = $request->input('date_from')) {
        $query->whereDate('aid_date', '>=', $from);
    }
    if ($to = $request->input('date_to')) {
        $query->whereDate('aid_date', '<=', $to);
    }

    $aids = $query->latest()->paginate(10)->appends($request->query());

    return view('admin.aids.index', compact('aids'));
}


    /**
     * فورم إضافة مساعدة جديدة.
     */
    public function create()
    {
        $beneficiaries = Beneficiary::all();
        $associations  = Association::all();
        return view('admin.aids.create', compact('beneficiaries', 'associations'));
    }

    /**
     * تخزين مساعدة جديدة.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'beneficiary_id' => 'required|exists:beneficiaries,id',
            'association_id' => 'required|exists:associations,id',
            'aid_type'       => 'required|in:financial,food,medical,education,clothing,other',
            'amount'         => 'nullable|numeric|min:0',
            'description'    => 'nullable|string',
            'aid_date'       => 'required|date',
        ]);

        $validated['created_by'] = Auth::id();

        $aid = Aid::create($validated);

        return redirect()->route('admin.aids.index')
            ->with('success', '✅ تم إضافة المساعدة بنجاح');
    }

    /**
     * عرض مساعدة واحدة.
     */
    public function show(Aid $aid)
    {
        $aid->load(['beneficiary', 'association', 'creator']);
        return view('admin.aids.show', compact('aid'));
    }

    /**
     * فورم تعديل مساعدة.
     */
    public function edit(Aid $aid)
    {
        $beneficiaries = Beneficiary::all();
        $associations  = Association::all();
        return view('admin.aids.edit', compact('aid', 'beneficiaries', 'associations'));
    }

    /**
     * تحديث بيانات مساعدة.
     */
    public function update(Request $request, Aid $aid)
{
    $validated = $request->validate([
        'beneficiary_id' => 'sometimes|required|exists:beneficiaries,id',
        'association_id' => 'sometimes|required|exists:associations,id',
        'aid_type'       => 'required|in:financial,food,medical,education,clothing,other',
        'amount'         => 'nullable|numeric|min:0',
        'description'    => 'nullable|string',
        'aid_date'       => 'required|date',
    ]);

    $aid->update($validated);

    return redirect()->route('admin.aids.index') // Changed to index
        ->with('success', '✏️ تم تحديث بيانات المساعدة');
}

    /**
     * حذف مساعدة.
     */
    public function destroy(Aid $aid)
    {
        $aid->delete();
        return redirect()->route('admin.aids.index')
            ->with('success', '🗑️ تم حذف المساعدة بنجاح');
    }
}
