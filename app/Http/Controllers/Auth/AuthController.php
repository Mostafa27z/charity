<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Association;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ✅ فورم التسجيل
    public function showRegisterForm()
    {
        // لو حابب تعرض الجمعيات في الفورم
        $associations = Association::all();
        return view('auth.register', compact('associations'));
    }

    // ✅ تنفيذ التسجيل
    public function register(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|string|email|unique:users',
            'password'       => 'required|string|min:6|confirmed',
            'association_id' => 'required|exists:associations,id', // جمعية موجودة
        ]);

        $user = User::create([
            'association_id' => $request->association_id,
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'role'           => 'user',
            'status'         => 'active',
        ]);

        Auth::login($user);

        // 🔀 توجيه حسب نوع المستخدم
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')
                             ->with('success', 'تم التسجيل والدخول بنجاح 🎉');
        }

        return redirect()->route('user.dashboard.index')
                         ->with('success', 'تم التسجيل والدخول بنجاح 🎉');
    }

    // ✅ فورم تسجيل الدخول
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ✅ تنفيذ تسجيل الدخول
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            // 🔀 توجيه حسب الدور
            return $user->role === 'admin'
                ? redirect()->intended(route('admin.dashboard'))
                : redirect()->intended(route('user.dashboard.index'));
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ])->onlyInput('email');
    }

    // ✅ تسجيل الخروج
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'تم تسجيل الخروج بنجاح');
    }
}
