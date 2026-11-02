<?php

namespace Tests\Feature;

use App\Models\DictWorkParameter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DictWorkParameterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());
    }

    public function test_index_returns_paginated_list(): void
    {
        DictWorkParameter::factory()->count(4)->create();

        $this->getJson('/api/dict-work-parameters')
            ->assertOk()
            ->assertJsonCount(4, 'data')
            ->assertJsonStructure(['data', 'current_page', 'per_page', 'total']);
    }

    public function test_store_creates_parameter(): void
    {
        $response = $this->postJson('/api/dict-work-parameters', [
            'dict_unit_id' => 3,
            'dict_parameter_type_id' => 7,
            'dict_work_parameter_name' => 'Мощность',
            'dict_work_parameter_mult' => 1.5,
            'dict_work_parameter_work_cde' => 'PWR',
            'dict_work_parameter_is_unc' => true,
            'dict_work_order' => 1,
            'dict_is_parametr_value_required' => true,
        ]);

        $response->assertCreated()
            ->assertJsonPath('dict_work_parameter_name', 'Мощность')
            ->assertJsonPath('dict_work_parameter_mult', 1.5)
            ->assertJsonPath('dict_work_parameter_is_unc', true);

        $this->assertDatabaseHas('dict_work_parameters', [
            'dict_work_parameter_name' => 'Мощность',
            'dict_parameter_type_id' => 7,
        ]);
    }

    public function test_store_accepts_empty_payload(): void
    {
        $this->postJson('/api/dict-work-parameters', [])->assertCreated();
    }

    public function test_store_rejects_invalid_types(): void
    {
        $this->postJson('/api/dict-work-parameters', [
            'dict_work_parameter_mult' => 'не число',
            'dict_work_order' => 'abc',
            'dict_unit_id' => 'abc',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['dict_work_parameter_mult', 'dict_work_order', 'dict_unit_id']);
    }

    public function test_show_returns_parameter_or_404(): void
    {
        $parameter = DictWorkParameter::factory()->create();

        $this->getJson("/api/dict-work-parameters/{$parameter->dict_work_parameter_id}")
            ->assertOk()
            ->assertJsonPath('dict_work_parameter_id', $parameter->dict_work_parameter_id);

        $this->getJson('/api/dict-work-parameters/999999')->assertNotFound();
    }

    public function test_update_changes_parameter(): void
    {
        $parameter = DictWorkParameter::factory()->create();

        $this->putJson("/api/dict-work-parameters/{$parameter->dict_work_parameter_id}", [
            'dict_work_parameter_name' => 'Расход',
            'dict_work_parameter_mult' => 2,
            'dict_work_parameter_for_search' => true,
        ])->assertOk()
            ->assertJsonPath('dict_work_parameter_name', 'Расход')
            ->assertJsonPath('dict_work_parameter_for_search', true);

        $this->assertDatabaseHas('dict_work_parameters', [
            'dict_work_parameter_id' => $parameter->dict_work_parameter_id,
            'dict_work_parameter_name' => 'Расход',
        ]);
    }

    public function test_update_validates_input(): void
    {
        $parameter = DictWorkParameter::factory()->create();

        $this->putJson("/api/dict-work-parameters/{$parameter->dict_work_parameter_id}", [
            'dict_work_parameter_mult' => 'abc',
            'dict_is_parametr_value_required' => 'да',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['dict_work_parameter_mult', 'dict_is_parametr_value_required']);
    }

    public function test_destroy_deletes_parameter(): void
    {
        $parameter = DictWorkParameter::factory()->create();

        $this->deleteJson("/api/dict-work-parameters/{$parameter->dict_work_parameter_id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('dict_work_parameters', [
            'dict_work_parameter_id' => $parameter->dict_work_parameter_id,
        ]);
    }
}
