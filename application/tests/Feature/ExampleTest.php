<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
	use RefreshDatabase;

    public function testURL() {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testURLUserAccessAllowed() {
    	$user = factory(User::class)->create();
    	$response = $this->actingAs($user)->get('/admin');
    	$response->assertOk();
    }

    public function testURLUserAccessNotAllowed() {
    	$user = factory(User::class)->create();
    	$response = $this->actingAs($user)->get('/admin');
    	$response->assertNotFound();
    }

    public function testNonAdminAccessUsersList() {
    	$user = factory(User::class)->create();
    	$response = $this->actingAs($user)->get('/admin/users');
    	$response->assertStatus(403);
    }

    public function testValuesAreEqual() {
        $this->assertEquals(600, $value);
    }

}
