<?php

namespace Tests\Feature;

use App\Models\Aid;
use App\Models\Association;
use App\Models\Beneficiary;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AidControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // إنشاء مستخدم وتسجيل دخوله
        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'sanctum');
    }

    /** @test */
    public function it_can_list_aids()
    {
        Aid::factory()->count(3)->create();

        $response = $this->get(route('admin.aids.index'));

        $response->assertStatus(200);
        $response->assertViewHas('aids');
    }

    /** @test */
    public function it_can_create_an_aid()
    {
        $beneficiary = Beneficiary::factory()->create();
        $association = Association::factory()->create();

        $data = [
            'beneficiary_id' => $beneficiary->id,
            'association_id' => $association->id,
            'aid_type'       => 'financial',
            'amount'         => 1500.50,
            'description'    => 'Financial help',
            'aid_date'       => now()->format('Y-m-d'),
        ];

        $response = $this->post(route('admin.aids.store'), $data);

        $this->assertDatabaseHas('aids', [
            'beneficiary_id' => $beneficiary->id,
            'association_id' => $association->id,
            'aid_type'       => 'financial',
            'amount'         => 1500.50,
        ]);

        $response->assertRedirect(); // يجب التحويل بعد الإنشاء
    }

    /** @test */
    public function it_can_update_an_aid()
    {
        $aid = Aid::factory()->create();

        $updateData = [
            'beneficiary_id' => $aid->beneficiary_id,
            'association_id' => $aid->association_id,
            'aid_type'       => 'medical',
            'amount'         => 2000,
            'description'    => 'Updated medical aid',
            'aid_date'       => now()->format('Y-m-d'),
        ];

        $response = $this->put(route('admin.aids.update', $aid), $updateData);

        $this->assertDatabaseHas('aids', [
            'id'      => $aid->id,
            'aid_type'=> 'medical',
            'amount'  => 2000,
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function it_can_delete_an_aid()
    {
        $aid = Aid::factory()->create();

        $response = $this->delete(route('admin.aids.destroy', $aid));

        $this->assertDatabaseMissing('aids', ['id' => $aid->id]);
        $response->assertRedirect();
    }
}
