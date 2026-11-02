<?php

namespace Tests\Feature;

use App\Models\DictCalcMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DictCalcMethodTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()->create());
    }

    public function test_index_returns_paginated_list(): void
    {
        DictCalcMethod::factory()->count(3)->create();

        $response = $this->getJson('/api/dict-calc-methods');

        $response->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure(['data', 'current_page', 'per_page', 'total']);
    }

    public function test_store_creates_method(): void
    {
        $response = $this->postJson('/api/dict-calc-methods', [
            'dict_calc_method_sname' => 'SUM',
            'dict_calc_method_name' => 'Сумма',
            'dict_calc_method_allowed_for_adding' => true,
        ]);

        $response->assertCreated()
            ->assertJsonPath('dict_calc_method_sname', 'SUM')
            ->assertJsonPath('dict_calc_method_allowed_for_adding', true);

        $this->assertDatabaseHas('dict_calc_methods', [
            'dict_calc_method_name' => 'Сумма',
        ]);
    }

    public function test_store_accepts_explicit_id(): void
    {
        $this->postJson('/api/dict-calc-methods', [
            'dict_calc_method_id' => 77,
            'dict_calc_method_sname' => 'AVG',
            'dict_calc_method_name' => 'Среднее',
        ])->assertCreated()->assertJsonPath('dict_calc_method_id', 77);

        $this->assertDatabaseHas('dict_calc_methods', ['dict_calc_method_id' => 77]);
    }

    public function test_store_requires_names(): void
    {
        $this->postJson('/api/dict-calc-methods', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['dict_calc_method_sname', 'dict_calc_method_name']);
    }

    public function test_store_rejects_duplicate_id(): void
    {
        DictCalcMethod::factory()->create(['dict_calc_method_id' => 5]);

        $this->postJson('/api/dict-calc-methods', [
            'dict_calc_method_id' => 5,
            'dict_calc_method_sname' => 'X',
            'dict_calc_method_name' => 'Y',
        ])->assertUnprocessable()->assertJsonValidationErrors(['dict_calc_method_id']);
    }

    public function test_show_returns_method_or_404(): void
    {
        $method = DictCalcMethod::factory()->create();

        $this->getJson("/api/dict-calc-methods/{$method->dict_calc_method_id}")
            ->assertOk()
            ->assertJsonPath('dict_calc_method_id', $method->dict_calc_method_id);

        $this->getJson('/api/dict-calc-methods/999999')->assertNotFound();
    }

    public function test_update_changes_method(): void
    {
        $method = DictCalcMethod::factory()->create();

        $this->putJson("/api/dict-calc-methods/{$method->dict_calc_method_id}", [
            'dict_calc_method_name' => 'Обновлено',
            'dict_calc_method_allowed_for_adding' => true,
        ])->assertOk()->assertJsonPath('dict_calc_method_name', 'Обновлено');

        $this->assertDatabaseHas('dict_calc_methods', [
            'dict_calc_method_id' => $method->dict_calc_method_id,
            'dict_calc_method_name' => 'Обновлено',
        ]);
    }

    public function test_update_validates_input(): void
    {
        $method = DictCalcMethod::factory()->create();

        $this->putJson("/api/dict-calc-methods/{$method->dict_calc_method_id}", [
            'dict_calc_method_name' => '',
            'dict_calc_method_allowed_for_adding' => 'не булево',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['dict_calc_method_name', 'dict_calc_method_allowed_for_adding']);
    }

    public function test_destroy_deletes_method(): void
    {
        $method = DictCalcMethod::factory()->create();

        $this->deleteJson("/api/dict-calc-methods/{$method->dict_calc_method_id}")->assertNoContent();

        $this->assertDatabaseMissing('dict_calc_methods', [
            'dict_calc_method_id' => $method->dict_calc_method_id,
        ]);
    }
}
