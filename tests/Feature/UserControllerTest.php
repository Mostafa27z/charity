<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Association;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class UserControllerTest extends TestCase
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
    public function it_can_list_users()
    {
        User::factory()->count(3)->create();

        $response = $this->get(route('admin.users.index'));
        $response->assertStatus(200);
        $response->assertViewHas('users');
    }

    /** @test */
    public function it_can_create_user()
    {
        $association = Association::factory()->create();

        $data = [
            'association_id' => $association->id,
            'name'           => 'Test User',
            'email'          => 'newuser@example.com',
            'phone'          => '01012345678',
            'password'       => 'secret123',
            'role'           => 'user',
            'status'         => 'active',
        ];

        $response = $this->post(route('admin.users.store'), $data);

        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
            'role'  => 'user',
        ]);

        $response->assertRedirect(route('admin.users.index'));
    }

    /** @test */
    public function it_can_update_user()
    {
        $user = User::factory()->create();
        $association = Association::factory()->create();

        $updateData = [
            'association_id' => $association->id,
            'name'           => 'Updated Name',
            'email'          => $user->email,
            'phone'          => '0100000000',
            'role'           => 'admin',
            'status'         => 'inactive',
        ];

        $response = $this->put(route('admin.users.update', $user), $updateData);

        $this->assertDatabaseHas('users', [
            'id'     => $user->id,
            'name'   => 'Updated Name',
            'status' => 'inactive',
        ]);

        $response->assertRedirect(route('admin.users.index'));
    }

    /** @test */
    public function it_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->delete(route('admin.users.destroy', $user));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $response->assertRedirect(route('admin.users.index'));
    }
}
