<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{Aid, Beneficiary, User};
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $associationId = auth()->user()->association_id;

        // ✅ Summary statistics
        $stats = [
            'beneficiaries_count' => Beneficiary::where('association_id', $associationId)->count(),
            'aids_count'          => Aid::where('association_id', $associationId)->count(),
            'users_count'         => User::where('association_id', $associationId)->count(),
            'total_aid_amount'    => Aid::where('association_id', $associationId)->sum('amount'),
        ];

        // ✅ Aid breakdown by type
        $aidTypes = Aid::select('aid_type', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total_amount'))
            ->where('association_id', $associationId)
            ->groupBy('aid_type')
            ->orderByDesc('count')
            ->get();

        // ✅ Monthly aid trend (last 6 months)
        $monthlyAids = Aid::select(
                DB::raw('DATE_FORMAT(aid_date, "%Y-%m") as month'),
                DB::raw('SUM(amount) as total')
            )
            ->where('association_id', $associationId)
            ->where('aid_date', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total','month');

        // ✅ Users status
        $userStatus = User::where('association_id', $associationId)
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count','status');

        // ✅ Recent activities
        $recentAids = Aid::with('beneficiary')
            ->where('association_id', $associationId)
            ->latest()
            ->take(5)
            ->get();

        $recentBeneficiaries = Beneficiary::where('association_id', $associationId)
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', [
            'stats'              => $stats,
            'aidTypes'           => $aidTypes,
            'monthlyAids'        => $monthlyAids,
            'userStatus'         => $userStatus,
            'recentAids'         => $recentAids,
            'recentBeneficiaries'=> $recentBeneficiaries,
            'association'        => auth()->user()->association,
        ]);
    }
}
