<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Association;
use App\Models\Beneficiary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BeneficiaryControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a user and login
        $this->actingAs(User::factory()->create());
    }

    /** @test */
    public function it_can_list_beneficiaries(): void
    {
        Beneficiary::factory()->count(3)->create();

        $response = $this->get(route('admin.beneficiaries.index'));

        $response->assertStatus(200)
                 ->assertViewIs('admin.beneficiaries.index')
                 ->assertViewHas('beneficiaries');
    }

    /** @test */
    public function it_can_create_a_beneficiary(): void
    {
        $association = Association::factory()->create();
        $data = Beneficiary::factory()->make([
            'association_id' => $association->id,
        ])->toArray();

        $response = $this->post(route('admin.beneficiaries.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('beneficiaries', [
            'national_id'   => $data['national_id'],
            'first_name'    => $data['first_name'],
            'association_id'=> $association->id,
        ]);
    }

    /** @test */
    public function it_can_update_a_beneficiary(): void
    {
        $association = Association::factory()->create();
        $beneficiary = Beneficiary::factory()->create(['association_id' => $association->id]);

        $payload = [
            'association_id' => $association->id,
            'national_id'    => $beneficiary->national_id,
            'first_name'     => 'Updated',
            'last_name'      => 'Name',
            'gender'         => $beneficiary->gender,
            'birth_date'     => $beneficiary->birth_date,
            'phone'          => $beneficiary->phone,
            'address'        => $beneficiary->address,
            'family_size'    => $beneficiary->family_size,
            'income'         => $beneficiary->income,
            'notes'          => $beneficiary->notes,
        ];

        $response = $this->put(route('admin.beneficiaries.update', $beneficiary), $payload);

        $response->assertRedirect();
        $this->assertDatabaseHas('beneficiaries', [
            'id'          => $beneficiary->id,
            'first_name'  => 'Updated',
            'last_name'   => 'Name',
            'association_id' => $association->id,
        ]);
    }

    /** @test */
    public function it_can_delete_a_beneficiary(): void
    {
        $beneficiary = Beneficiary::factory()->create();

        $response = $this->delete(route('admin.beneficiaries.destroy', $beneficiary));

        $response->assertRedirect();
        $this->assertDatabaseMissing('beneficiaries', [
            'id' => $beneficiary->id,
        ]);
    }
}
