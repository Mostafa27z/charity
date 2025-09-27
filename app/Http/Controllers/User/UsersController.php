<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of users in the same association.
     */
    public function index(Request $request)
    {
        $query = User::where('association_id', Auth::user()->association_id)
            ->where('role', '!=', 'admin'); // 🚫 prevent showing admins

        // 🔍 Optional search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(10)->appends($request->query());

        return view('user.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('user.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:user,moderator', // ✅ only user/moderator
            'status'   => 'required|in:active,inactive',
        ]);

        $validated['association_id'] = Auth::user()->association_id;
        $validated['password']       = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('user.users.index')
            ->with('success', 'تم إنشاء المستخدم بنجاح ✅');
    }

    /**
     * Show a specific user (same association).
     */
    public function show(User $user)
    {
        $this->authorizeUser($user);
        return view('user.users.show', compact('user'));
    }

    /**
     * Edit a user.
     */
    public function edit(User $user)
    {
        $this->authorizeUser($user);
        return view('user.users.edit', compact('user'));
    }

    /**
     * Update a user.
     */
    public function update(Request $request, User $user)
    {
        $this->authorizeUser($user);

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'role'     => 'required|in:user,moderator',
            'status'   => 'required|in:active,inactive',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('user.users.index')
            ->with('success', 'تم تحديث بيانات المستخدم ✅');
    }

    /**
     * Remove a user.
     */
    public function destroy(User $user)
    {
        $this->authorizeUser($user);
        $user->delete();

        return redirect()
            ->route('user.users.index')
            ->with('success', 'تم حذف المستخدم بنجاح ❌');
    }

    /**
     * Ensure the user belongs to the moderator's association and is not admin.
     */
    private function authorizeUser(User $user)
    {
        if ($user->association_id !== Auth::user()->association_id || $user->role === 'admin') {
            abort(403, 'غير مسموح');
        }
    }
}
