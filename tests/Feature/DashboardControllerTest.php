<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Association;
use App\Models\Beneficiary;
use App\Models\Aid;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin, 'sanctum');
    }

    /** @test */
    public function it_displays_dashboard_statistics()
    {
        // Arrange: create some data
        $association = Association::factory()->create();
        $beneficiary = Beneficiary::factory()->create();
        Aid::factory()->create([
            'beneficiary_id' => $beneficiary->id,
            'association_id' => $association->id,
            'aid_type'       => 'financial',
            'amount'         => 500,
        ]);

        // Act
        $response = $this->get(route('admin.dashboard'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewHasAll([
            'totalAssociations',
            'totalUsers',
            'totalBeneficiaries',
            'totalAids',
            'adminCount',
            'userCount',
            'totalAidAmount',
            'recentAids'
        ]);
    }
}
