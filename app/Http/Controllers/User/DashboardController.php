<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Aid;
use App\Models\Association;
use App\Models\Beneficiary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Show dashboard with charity statistics and user-invite form.
     */
    public function index()
    {
        $user = auth()->user();
        $association = $user->association;

        // ✅ Calculate overview stats for this charity
        $stats = [
            'beneficiaries_count' => Beneficiary::where('association_id', $association->id)->count(),
            'aids_count'          => Aid::where('association_id', $association->id)->count(),
            'users_count'         => User::where('association_id', $association->id)->count(),
            'total_aid_amount'    => Aid::where('association_id', $association->id)->sum('amount'),
        ];

        return view('user.dashboard', compact('stats', 'association'));
    }

    /**
     * Store a new user for the same charity.
     */
    public function storeUser(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $newUser = User::create([
        'association_id' => auth()->user()->association_id,
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'role' => 'user',  // or whatever default role
        'status' => 'active'
    ]);

    // ✅ Return 201 JSON instead of redirect
    return response()->json([
        'message' => 'User created successfully',
        'user'    => $newUser
    ], 201);
}

}
