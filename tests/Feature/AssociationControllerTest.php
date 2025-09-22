<?php

namespace Tests\Feature;

use App\Models\Association;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Database\Factories\AssociationFactory;

use Database\Factories\UserFactory;
class AssociationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // إنشاء مستخدم وتسجيل دخوله
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_displays_associations_index()
    {
        Association::factory()->count(3)->create();

        $response = $this->get(route('admin.associations.index'));

        $response->assertStatus(200);
        $response->assertViewHas('associations');
    }

    /** @test */
    public function it_can_store_a_new_association()
    {
        $data = [
            'name' => 'جمعية البر',
            'registration_number' => 'REG-001',
            'address' => 'القاهرة',
            'phone' => '01000000000',
            'email' => 'bar@example.com',
            'status' => 'active',
        ];

        $response = $this->post(route('admin.associations.store'), $data);

        $response->assertRedirect(route('admin.associations.index'));
        $this->assertDatabaseHas('associations', ['name' => 'جمعية البر']);
    }

    /** @test */
    public function it_can_update_an_association()
    {
        $association = Association::factory()->create();

        $response = $this->put(route('admin.associations.update', $association->id), [
            'name' => 'جمعية الخير',
            'registration_number' => 'REG-999',
            'address' => 'الجيزة',
            'phone' => '01011111111',
            'email' => 'updated@example.com',
            'status' => 'inactive',
        ]);

        $response->assertRedirect(route('admin.associations.index'));
        $this->assertDatabaseHas('associations', ['name' => 'جمعية الخير']);
    }

    /** @test */
    public function it_can_delete_an_association()
    {
        $association = Association::factory()->create();

        $response = $this->delete(route('admin.associations.destroy', $association->id));

        $response->assertRedirect(route('admin.associations.index'));
        $this->assertDatabaseMissing('associations', ['id' => $association->id]);
    }
}
