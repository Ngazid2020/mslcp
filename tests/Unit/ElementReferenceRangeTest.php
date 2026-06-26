<?php

namespace Tests\Unit;

use App\Models\Element;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ElementReferenceRangeTest extends TestCase
{
    use RefreshDatabase;

    private function element(array $attrs = []): Element
    {
        return Element::make(array_merge([
            'nom' => 'Hémoglobine',
            'unite' => 'g/dL',
            'type_valeur' => 'numerique',
            // Adulte homme
            'ref_inf_h' => 13.0,
            'ref_sup_h' => 17.5,
            // Adulte femme
            'ref_inf_f' => 12.0,
            'ref_sup_f' => 16.0,
            // Enfant 5–15 ans
            'ref_inf_enf' => 11.0,
            'ref_sup_enf' => 14.5,
            // Nourrisson 1–4 ans
            'ref_inf_nour' => 10.5,
            'ref_sup_nour' => 13.5,
            // Nouveau-né < 1 an
            'ref_inf_nne' => 14.0,
            'ref_sup_nne' => 20.0,
        ], $attrs));
    }

    private function patient(array $attrs = []): Patient
    {
        return Patient::make(array_merge([
            'nom' => 'Test',
            'sexe' => 'M',
            'age' => 30,
        ], $attrs));
    }

    public function test_normal_value_adult_male_is_not_out_of_range(): void
    {
        $this->assertFalse(
            $this->element()->isResultOutOfRange(15.0, $this->patient(['sexe' => 'M', 'age' => 30]))
        );
    }

    public function test_low_value_adult_male_is_out_of_range(): void
    {
        $this->assertTrue(
            $this->element()->isResultOutOfRange(12.0, $this->patient(['sexe' => 'M', 'age' => 30]))
        );
    }

    public function test_high_value_adult_male_is_out_of_range(): void
    {
        $this->assertTrue(
            $this->element()->isResultOutOfRange(18.0, $this->patient(['sexe' => 'M', 'age' => 30]))
        );
    }

    public function test_female_range_is_used_for_adult_female(): void
    {
        // 12.5 est dans la norme femme (12–16) mais hors norme homme (13–17.5)
        $this->assertFalse(
            $this->element()->isResultOutOfRange(12.5, $this->patient(['sexe' => 'F', 'age' => 30]))
        );
        $this->assertTrue(
            $this->element()->isResultOutOfRange(12.5, $this->patient(['sexe' => 'M', 'age' => 30]))
        );
    }

    public function test_child_range_is_used_for_patient_aged_5_to_15(): void
    {
        // 13.0 est dans la norme enfant (11–14.5) mais hors norme homme adulte (13–17.5) — non
        // En réalité, 13.0 est dans la norme enfant ET dans la norme homme.
        // Testons une valeur hors norme enfant mais normale adulte : 15.0
        $this->assertTrue(
            $this->element()->isResultOutOfRange(15.0, $this->patient(['sexe' => 'M', 'age' => 10]))
        );
    }

    public function test_infant_range_is_used_for_patient_aged_1_to_4(): void
    {
        // 15.0 est hors norme nourrisson (10.5–13.5)
        $this->assertTrue(
            $this->element()->isResultOutOfRange(15.0, $this->patient(['sexe' => 'M', 'age' => 2]))
        );
    }

    public function test_newborn_range_is_used_for_patient_under_1_year(): void
    {
        // 15.0 est dans la norme nouveau-né (14–20)
        $this->assertFalse(
            $this->element()->isResultOutOfRange(15.0, $this->patient(['sexe' => 'M', 'age' => 0]))
        );
    }

    public function test_non_numeric_result_is_never_out_of_range(): void
    {
        $this->assertFalse(
            $this->element()->isResultOutOfRange('positif', $this->patient())
        );
        $this->assertFalse(
            $this->element()->isResultOutOfRange(null, $this->patient())
        );
    }

    public function test_element_without_reference_bounds_is_never_out_of_range(): void
    {
        $el = $this->element([
            'ref_inf_h' => null, 'ref_sup_h' => null,
        ]);

        $this->assertFalse(
            $el->isResultOutOfRange(99.0, $this->patient(['sexe' => 'M', 'age' => 30]))
        );
    }
}
