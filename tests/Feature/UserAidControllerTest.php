<?php

namespace Tests\Feature;

use App\Models\Aid;
use App\Models\User;
use App\Models\Beneficiary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserAidControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_aids_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Aid::factory()->count(2)->create(['created_by' => $user->id]);

        $this->get(route('user.aids.index'))
             ->assertStatus(200)->assertViewIs('user.aids.index');;
    }

    /** @test */
    public function user_can_create_aid()
    {
        $user = User::factory()->create();
        $beneficiary = Beneficiary::factory()->create();

        $this->actingAs($user);

        $data = [
            'beneficiary_id' => $beneficiary->id,
            'aid_type'       => 'food',
            'amount'         => 150,
            'description'    => 'Monthly help',
            'aid_date'       => now()->toDateString(),
        ];

        $this->post(route('user.aids.store'), $data)
             ->assertRedirect(route('user.aids.index'));

        $this->assertDatabaseHas('aids', [
            'beneficiary_id' => $beneficiary->id,
            'aid_type' => 'food',
            'created_by' => $user->id
        ]);
    }
}
