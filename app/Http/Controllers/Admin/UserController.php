<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = User::with('association');

    // ✅ البحث بالكلمة (الاسم أو الإيميل أو الهاتف)
    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        });
    }

    // ✅ فلترة الجمعية
    if ($association = $request->input('association_id')) {
        $query->where('association_id', $association);
    }

    // ✅ فلترة الدور
    if ($role = $request->input('role')) {
        $query->where('role', $role);
    }

    // ✅ فلترة الحالة
    if ($status = $request->input('status')) {
        $query->where('status', $status);
    }

    $users = $query->latest()->paginate(10)->withQueryString(); // الحفاظ على الفلاتر مع الصفحات
    $associations = \App\Models\Association::all();

    return view('admin.users.index', compact('users','associations'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $associations = Association::all();
        return view('admin.users.create', compact('associations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'association_id' => 'required|exists:associations,id',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email',
            'phone'          => 'nullable|string|max:20',
            'password'       => 'required|string|min:6',
            'role'           => 'required|in:admin,user,moderator',
            'status'         => 'required|in:active,inactive',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('association');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $associations = Association::all();
        return view('admin.users.edit', compact('user', 'associations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'association_id' => 'required|exists:associations,id',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $user->id,
            'phone'          => 'nullable|string|max:20',
            'password'       => 'nullable|string|min:6',
            'role'           => 'required|in:admin,user,moderator',
            'status'         => 'required|in:active,inactive',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
