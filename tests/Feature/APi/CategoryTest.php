<?php

namespace Tests\Feature\APi;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_return_categories_list(): void
    {
        $user = User::factory()->create();

        $category = Category::factory()->create();

        $response = $this->actingAs($user)
            ->getJson(route('categories.index'));

        $response->assertStatus(200)
        ->assertJsonCount(1, 'data')
        ->assertJson([
            'data' => [ Arr::only($category->toArray(), ['id', 'name']) ]
        ]);
    }

    public function test_api_category_store_successful(): void
    {
        $user = User::factory()->create();

        $category = ['id'=> 1, 'name' => 'Category 1', 'description' => 'Description 1'];

        $response = $this->actingAs($user)
            ->postJson(route('categories.store'), $category);

        $response->assertStatus(201)
            ->assertJson(['data' => Arr::only($category, ['id', 'name'])]);
    }
}
