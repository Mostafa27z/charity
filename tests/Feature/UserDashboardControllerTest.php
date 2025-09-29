<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Association;
use App\Models\Beneficiary;
use App\Models\Aid;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserDashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_dashboard_overview()
    {
        // If running on SQLite, create a DATE_FORMAT function so controller's query works.
        // PDO for sqlite exposes sqliteCreateFunction — we map "%Y-%m" -> "Y-m", etc.
        $pdo = DB::getPdo();
        if (method_exists($pdo, 'sqliteCreateFunction')) {
            $pdo->sqliteCreateFunction('DATE_FORMAT', function ($date, $format) {
                try {
                    // Normalize input to string
                    $dateStr = is_string($date) ? $date : (string) $date;
                    $dt = new \DateTime($dateStr);

                    // map common strftime-like tokens to PHP date tokens used in your query
                    $map = [
                        '%Y' => 'Y',
                        '%m' => 'm',
                        '%d' => 'd',
                        '%H' => 'H',
                        '%i' => 'i', // minutes
                        '%s' => 's',
                    ];

                    $phpFormat = strtr($format, $map);

                    return $dt->format($phpFormat);
                } catch (\Throwable $e) {
                    // If parsing fails return null so SQL can handle it gracefully
                    return null;
                }
            });
        }

        $association = Association::factory()->create();
        $user = User::factory()->create(['association_id' => $association->id]);

        Beneficiary::factory()->count(5)->create([
            'association_id' => $association->id,
        ]);

        // ensure aid_date is within last 6 months so monthly query includes them
        $dateString = Carbon::now()->subMonths(1)->toDateString();
        Aid::factory()->count(3)->create([
            'association_id' => $association->id,
            'aid_date'       => $dateString,
            'amount'         => 500,
        ]);

        $this->actingAs($user, 'web');

        $response = $this->get(route('user.dashboard.index'));

        $response->assertStatus(200)
            ->assertViewIs('user.dashboard')
            ->assertViewHasAll([
                'stats',
                'aidTypes',
                'monthlyAids',
                'userStatus',
                'recentAids',
                'recentBeneficiaries',
                'association',
            ]);

        $stats = $response->viewData('stats');
        $this->assertEquals(5, $stats['beneficiaries_count']);
        $this->assertEquals(3, $stats['aids_count']);
    }
}
