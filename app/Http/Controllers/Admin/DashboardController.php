<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Association;
use App\Models\Beneficiary;
use App\Models\Aid;

class DashboardController extends Controller
{
    /**
     * Display an overview with statistics.
     */
    public function index()
    {
        // إحصائيات أساسية
        $totalAssociations  = Association::count();
        $totalUsers         = User::count();
        $totalBeneficiaries = Beneficiary::count();
        $totalAids          = Aid::count();

        // تقسيم المستخدمين حسب الدور
        $adminCount = User::where('role', 'admin')->count();
        $userCount  = User::where('role', 'user')->count();

        // إجمالي المساعدات المالية
        $totalAidAmount = Aid::where('aid_type', 'financial')->sum('amount');

        // أحدث 5 مساعدات لعرضها في لوحة التحكم
        $recentAids = Aid::with(['beneficiary', 'association'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalAssociations',
            'totalUsers',
            'totalBeneficiaries',
            'totalAids',
            'adminCount',
            'userCount',
            'totalAidAmount',
            'recentAids'
        ));
    }
}
