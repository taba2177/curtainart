<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns 200 for editorial-premium variant', function () {
    $response = $this->get('/preview/home/editorial-premium');

    $response->assertStatus(200);
    $response->assertViewIs('preview.home.show');
    $response->assertViewHas('variant');
    $response->assertViewHas('sections');
});

it('returns 200 for bold-modular variant', function () {
    $response = $this->get('/preview/home/bold-modular');

    $response->assertStatus(200);
});

it('returns 200 for calm-storytelling variant', function () {
    $response = $this->get('/preview/home/calm-storytelling');

    $response->assertStatus(200);
});

it('redirects for unknown variant due to route constraint', function () {
    $response = $this->get('/preview/home/non-existent');

    $response->assertRedirect('/');
});

it('passes contact data to the view', function () {
    $response = $this->get('/preview/home/editorial-premium');

    $response->assertStatus(200);
    $response->assertViewHas('contactPhone');
    $response->assertViewHas('contactWhatsapp');
    $response->assertViewHas('headerCategories');
    $response->assertViewHas('footerData');
});
