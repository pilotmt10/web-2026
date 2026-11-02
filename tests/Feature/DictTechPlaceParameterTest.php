<?php

namespace Tests\Feature;

use App\Models\DictTechPlaceParameter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DictTechPlaceParameterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());
    }

    public function test_index_returns_paginated_list(): void
    {
        DictTechPlaceParameter::factory()->count(2)->create();

        $this->getJson('/api/dict-tech-place-parameters')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure(['data', 'current_page', 'per_page', 'total']);
    }

    public function test_store_creates_parameter(): void
    {
        $response = $this->postJson('/api/dict-tech-place-parameters', [
            'dict_unit_id' => 10,
            'dict_tech_place_parameter_name' => 'Давление',
            'dict_tech_place_parameter_descr' => 'Рабочее давление',
            'dict_tech_place_is_search' => true,
            'dict_tech_place_search_enabled' => true,
        ]);

        $response->assertCreated()
            ->assertJsonPath('dict_tech_place_parameter_name', 'Давление')
            ->assertJsonPath('dict_tech_place_is_search', true);

        $this->assertDatabaseHas('dict_tech_place_parameters', [
            'dict_tech_place_parameter_name' => 'Давление',
            'dict_unit_id' => 10,
        ]);
    }

    public function test_store_requires_name(): void
    {
        $this->postJson('/api/dict-tech-place-parameters', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['dict_tech_place_parameter_name']);
    }

    public function test_show_returns_parameter_or_404(): void
    {
        $parameter = DictTechPlaceParameter::factory()->create();

        $this->getJson("/api/dict-tech-place-parameters/{$parameter->dict_tech_place_parameter_id}")
            ->assertOk()
            ->assertJsonPath('dict_tech_place_parameter_id', $parameter->dict_tech_place_parameter_id);

        $this->getJson('/api/dict-tech-place-parameters/999999')->assertNotFound();
    }

    public function test_update_changes_parameter(): void
    {
        $parameter = DictTechPlaceParameter::factory()->create([
            'dict_tech_place_search_enabled' => false,
        ]);

        $this->putJson("/api/dict-tech-place-parameters/{$parameter->dict_tech_place_parameter_id}", [
            'dict_tech_place_parameter_name' => 'Температура',
            'dict_tech_place_search_enabled' => true,
        ])->assertOk()
            ->assertJsonPath('dict_tech_place_parameter_name', 'Температура')
            ->assertJsonPath('dict_tech_place_search_enabled', true);

        $this->assertDatabaseHas('dict_tech_place_parameters', [
            'dict_tech_place_parameter_id' => $parameter->dict_tech_place_parameter_id,
            'dict_tech_place_parameter_name' => 'Температура',
        ]);
    }

    public function test_update_validates_input(): void
    {
        $parameter = DictTechPlaceParameter::factory()->create();

        $this->putJson("/api/dict-tech-place-parameters/{$parameter->dict_tech_place_parameter_id}", [
            'dict_tech_place_parameter_name' => '',
            'dict_unit_id' => 'abc',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['dict_tech_place_parameter_name', 'dict_unit_id']);
    }

    public function test_destroy_deletes_parameter(): void
    {
        $parameter = DictTechPlaceParameter::factory()->create();

        $this->deleteJson("/api/dict-tech-place-parameters/{$parameter->dict_tech_place_parameter_id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('dict_tech_place_parameters', [
            'dict_tech_place_parameter_id' => $parameter->dict_tech_place_parameter_id,
        ]);
    }
}
