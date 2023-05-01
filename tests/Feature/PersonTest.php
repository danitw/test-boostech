<?php

namespace Tests\Feature;

use App\Models\Person;
use Database\Seeders\PersonSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_create(): void
    {
        $name = $this->faker->name();
        $email = $this->faker->safeEmail();

        $response = $this->post('/api/person/create', [
            'name' => $name,
            'email' => $email
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['message', 'person']);
        $response->assertJson(['message' => 'Person Created Successfully', 'person' => [
            'name' => $name,
            'email' => $email
        ]]);

        $this->assertDatabaseHas('persons', [
            'name' => $name,
            'email' => $email
        ]);
    }

    public function test_read(): void
    {
        $person = Person::factory()->create();
        $response = $this->get("/api/person/read/$person->id");

        $response->assertStatus(200);
        $response->assertJsonStructure(['person']);
    }

    public function test_list(): void
    {
        $this->seed(PersonSeeder::class);

        $response = $this->get('/api/person/list');

        $response->assertStatus(200);
        $response->assertJsonStructure(['persons']);
    }

    public function test_update(): void
    {
        $person = Person::factory()->create();

        $name = $this->faker->name();
        $email = $this->faker->safeEmail();

        $response = $this->put("/api/person/update/$person->id", [
            'name' => $name,
            'email' => $email
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['status']);
        $response->assertJson(['status' => 'successfully updated person']);

        $this->assertDatabaseHas('persons', [
            'name' => $name,
            'email' => $email
        ]);
    }

    public function test_delete(): void
    {
        $person = Person::factory()->create();

        $response = $this->delete("/api/person/delete/$person->id");

        $response->assertStatus(200);
        $response->assertJsonStructure(['status']);

        $this->assertDatabaseMissing('persons', [
            'id' => $person->id
        ]);
    }
}
