<?php

namespace Tests\Feature;

use App\Models\DictCalcMethod;
use App\Models\DictTechPlaceParameter;
use App\Models\DictWorkParameter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DictionaryUiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    public function test_root_redirects_to_first_dictionary(): void
    {
        $this->get('/')->assertRedirect(route('dict.index', 'calc-methods'));
    }

    public function test_index_renders_records(): void
    {
        DictCalcMethod::factory()->create(['dict_calc_method_name' => 'Сумма']);

        $this->get('/dict/calc-methods')
            ->assertOk()
            ->assertSee('Методы расчёта')
            ->assertSee('Сумма')
            ->assertSee('+ Создать', false);
    }

    public function test_index_renders_records_of_other_dictionaries(): void
    {
        DictTechPlaceParameter::factory()->create(['dict_tech_place_parameter_name' => 'Давление']);
        DictWorkParameter::factory()->create(['dict_work_parameter_name' => 'Мощность']);

        $this->get('/dict/tech-place-parameters')->assertOk()->assertSee('Давление');
        $this->get('/dict/work-parameters')->assertOk()->assertSee('Мощность');
    }

    public function test_unknown_dictionary_returns_404(): void
    {
        $this->get('/dict/unknown')->assertNotFound();
        $this->get('/dict/unknown/create')->assertNotFound();
    }

    public function test_create_form_renders(): void
    {
        $this->get('/dict/calc-methods/create')
            ->assertOk()
            ->assertSee('создание', false)
            ->assertSee('dict_calc_method_sname', false);
    }

    public function test_store_creates_record_and_redirects(): void
    {
        $response = $this->post('/dict/calc-methods', [
            'dict_calc_method_sname' => 'AVG',
            'dict_calc_method_name' => 'Среднее',
            'dict_calc_method_allowed_for_adding' => '1',
        ]);

        $response->assertRedirect(route('dict.index', 'calc-methods'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('dict_calc_methods', [
            'dict_calc_method_sname' => 'AVG',
            'dict_calc_method_allowed_for_adding' => true,
        ]);
    }

    public function test_store_redirects_back_with_validation_errors(): void
    {
        $response = $this->from('/dict/calc-methods/create')
            ->post('/dict/calc-methods', [
                'dict_calc_method_sname' => '',
                'dict_calc_method_name' => '',
            ]);

        $response->assertRedirect(route('dict.create', 'calc-methods'))
            ->assertSessionHasErrors(['dict_calc_method_sname', 'dict_calc_method_name']);

        $this->assertDatabaseCount('dict_calc_methods', 0);
    }

    public function test_edit_form_renders_current_values(): void
    {
        $method = DictCalcMethod::factory()->create([
            'dict_calc_method_name' => 'Минимум',
            'dict_calc_method_allowed_for_adding' => true,
        ]);

        $this->get("/dict/calc-methods/{$method->dict_calc_method_id}/edit")
            ->assertOk()
            ->assertSee('редактирование', false)
            ->assertSee('Минимум')
            ->assertSee('dict_calc_method_allowed_for_adding', false);
    }

    public function test_update_changes_record(): void
    {
        $method = DictCalcMethod::factory()->create();

        $response = $this->put("/dict/calc-methods/{$method->dict_calc_method_id}", [
            'dict_calc_method_sname' => 'MAX',
            'dict_calc_method_name' => 'Максимум',
            'dict_calc_method_allowed_for_adding' => '0',
        ]);

        $response->assertRedirect(route('dict.index', 'calc-methods'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('dict_calc_methods', [
            'dict_calc_method_id' => $method->dict_calc_method_id,
            'dict_calc_method_name' => 'Максимум',
            'dict_calc_method_allowed_for_adding' => false,
        ]);
    }

    public function test_update_redirects_back_with_validation_errors(): void
    {
        $method = DictCalcMethod::factory()->create();

        $this->from("/dict/calc-methods/{$method->dict_calc_method_id}/edit")
            ->put("/dict/calc-methods/{$method->dict_calc_method_id}", [
                'dict_calc_method_name' => '',
            ])
            ->assertSessionHasErrors(['dict_calc_method_name']);
    }

    public function test_destroy_deletes_record(): void
    {
        $method = DictCalcMethod::factory()->create();

        $this->delete("/dict/calc-methods/{$method->dict_calc_method_id}")
            ->assertRedirect(route('dict.index', 'calc-methods'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('dict_calc_methods', [
            'dict_calc_method_id' => $method->dict_calc_method_id,
        ]);
    }

    public function test_missing_record_returns_404(): void
    {
        $this->get('/dict/calc-methods/999999/edit')->assertNotFound();
        $this->put('/dict/calc-methods/999999', [])->assertNotFound();
        $this->delete('/dict/calc-methods/999999')->assertNotFound();
    }
}
