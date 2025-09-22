<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Association;
use App\Models\Beneficiary;
use App\Models\Aid;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserDashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_dashboard_overview()
    {
        // Create an association and a user
        $association = Association::factory()->create();
        $user = User::factory()->create(['association_id' => $association->id]);

        // Create related data
        Beneficiary::factory()->count(5)->create(['association_id' => $association->id]);
        Aid::factory()->count(3)->create(['association_id' => $association->id]);

        $this->actingAs($user, 'web'); // login user

        $response = $this->get(route('user.dashboard.index'));

        $response->assertStatus(200)
         ->assertViewIs('user.dashboard')
         ->assertViewHas('stats')
         ->assertViewHas('association');
    }

    /** @test */
    public function user_can_add_new_user_to_same_charity()
    {
        $association = Association::factory()->create();
        $user = User::factory()->create(['association_id' => $association->id]);

        $this->actingAs($user, 'web');

        $payload = [
            'name' => 'New Charity User',
            'email' => 'newuser@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->post(route('user.dashboard.add-user'), $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
            'association_id' => $association->id
        ]);
    }
}
