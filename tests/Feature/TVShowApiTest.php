<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class TVShowApiTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function testSearchWithValidQuery()
    {
        $response = $this->get('/?q=Deadwood');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                // Add other expected fields here
            ],
        ]);
    }

    public function testSearchWithInvalidQuery()
    {
        $response = $this->get('/');

        $response->assertStatus(400);
        $response->assertJson(['error' => 'Query parameter "q" is required.']);
    }
}
