<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Beneficiary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserBeneficiaryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_beneficiaries_list()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Beneficiary::factory()->count(2)->create([
            'association_id' => $user->association_id
        ]);

        $this->get(route('user.beneficiaries.index'))
            ->assertStatus(200)
            ->assertViewIs('user.beneficiaries.index');
    }

    /** @test */
    public function user_can_create_a_beneficiary()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = Beneficiary::factory()->make()->toArray();
        unset($data['association_id']); // association يضاف أوتوماتيك

        $this->post(route('user.beneficiaries.store'), $data)
            ->assertRedirect(route('user.beneficiaries.index'));

        $this->assertDatabaseHas('beneficiaries', [
            'national_id'   => $data['national_id'],
            'association_id'=> $user->association_id
        ]);
    }

    /** @test */
    public function user_can_view_single_beneficiary()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $beneficiary = Beneficiary::factory()->create([
            'association_id' => $user->association_id
        ]);

        $this->get(route('user.beneficiaries.show', $beneficiary))
            ->assertStatus(200)
            ->assertViewIs('user.beneficiaries.show');
    }
}
