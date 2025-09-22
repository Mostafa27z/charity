<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Association;
use Illuminate\Http\Request;

class AssociationController extends Controller
{
    // ✅ عرض جميع الجمعيات
    public function index()
    {
        $associations = Association::all();
        return view('admin.associations.index', compact('associations'));
    }

    // ✅ عرض فورم إنشاء جمعية جديدة
    public function create()
    {
        return view('admin.associations.create');
    }

    // ✅ تخزين جمعية جديدة
    public function store(Request $request)
    {
        $request->validate([
            'name'                => 'required|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'address'             => 'nullable|string',
            'phone'               => 'nullable|string|max:20',
            'email'               => 'required|email|unique:associations,email',
            'status'              => 'required|in:active,inactive',
        ]);

        Association::create($request->only(
            'name',
            'registration_number',
            'address',
            'phone',
            'email',
            'status'
        ));

        return redirect()->route('admin.associations.index')
                         ->with('success', 'تمت إضافة الجمعية بنجاح ✅');
    }

    // ✅ عرض صفحة التعديل
    public function edit(Association $association)
    {
        return view('admin.associations.edit', compact('association'));
    }

    // ✅ تحديث بيانات الجمعية
    public function update(Request $request, Association $association)
    {
        $request->validate([
            'name'                => 'required|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'address'             => 'nullable|string',
            'phone'               => 'nullable|string|max:20',
            'email'               => 'required|email|unique:associations,email,' . $association->id,
            'status'              => 'required|in:active,inactive',
        ]);

        $association->update($request->only(
            'name',
            'registration_number',
            'address',
            'phone',
            'email',
            'status'
        ));

        return redirect()->route('admin.associations.index')
                         ->with('success', 'تم تحديث الجمعية بنجاح ✅');
    }

    // ✅ حذف جمعية
    public function destroy(Association $association)
    {
        $association->delete();

        return redirect()->route('admin.associations.index')
                         ->with('success', 'تم حذف الجمعية بنجاح ❌');
    }
    /**
 * عرض تفاصيل جمعية واحدة مع المستخدمين ومساهماتهم
 */
public function show(Association $association)
{
    // جلب الجمعية مع المستخدمين وكل مساعداتهم
    $association->load([
        'users' => function ($q) {
            $q->withCount('aids')
              ->withSum('aids', 'amount');
        },
        'aids'  // جميع المساعدات الخاصة بالجمعية
    ]);

    return view('admin.associations.show', compact('association'));
}

    
}
