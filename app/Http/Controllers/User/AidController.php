<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Aid;
use App\Models\Beneficiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AidController extends Controller
{
    /**
     * عرض جميع المساعدات الخاصة بالمستخدم الحالي
     */
    public function index()
    {
        $aids = Aid::where('created_by', Auth::id())
            ->with(['beneficiary', 'association'])
            ->latest()
            ->paginate(10);

        return view('user.aids.index', compact('aids'));
    }

    /**
     * صفحة إنشاء مساعدة جديدة
     */
    public function create()
    {
        $beneficiaries = Beneficiary::all();
        return view('user.aids.create', compact('beneficiaries'));
    }

    /**
     * حفظ مساعدة جديدة
     */
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

        return redirect()
            ->route('user.aids.index')
            ->with('success', 'تم إنشاء المساعدة بنجاح');
    }
}
