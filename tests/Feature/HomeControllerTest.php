<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Taba\Crm\Models\PostCategory;

uses(RefreshDatabase::class);

it('returns home sections', function () {
    $response = $this->getJson('/api/v1/home');
    $response->assertOk()
             ->assertJsonStructure(['metaTitle', 'sections']);
});

it('returns navigation categories', function () {
    $response = $this->getJson('/api/v1/navigation');
    $response->assertOk()
             ->assertJsonStructure(['categories', 'settings', 'locale']);
});

it('returns posts for a valid category slug', function () {
    PostCategory::create(['name' => 'Products', 'slug' => 'products']);
    $response = $this->getJson('/api/v1/categories/products');
    $response->assertOk()
             ->assertJsonStructure(['category', 'posts']);
});

it('returns 404 for unknown category slug', function () {
    $this->getJson('/api/v1/categories/nonexistent')->assertNotFound();
});

it('stores a contact entry', function () {
    $response = $this->postJson('/api/v1/contact', [
        'name'    => 'أحمد',
        'phone'   => '+966500000000',
        'message' => 'استفسار عن المنتجات',
    ]);
    $response->assertOk()->assertJson(['success' => true]);
    $this->assertDatabaseHas('contact_entries', ['phone' => '+966500000000']);
});

it('rejects contact without required fields', function () {
    $this->postJson('/api/v1/contact', [])->assertUnprocessable();
});
