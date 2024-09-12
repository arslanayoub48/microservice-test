<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use App\Models\User;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_product()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $token = $admin->createToken('TestToken')->accessToken;

        $response = $this->postJson('/api/products', [
            'name' => 'New Product',
            'description' => 'Product description',
            'price' => 99.99,
            'quantity' => 5,
        ], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(201);
    }

    public function test_manager_can_view_products()
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $token = $manager->createToken('TestToken')->accessToken;

        $response = $this->getJson('/api/products', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
    }
}
