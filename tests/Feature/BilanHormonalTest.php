<?php

namespace Tests\Feature;

use App\Models\Bilan;
use App\Models\BilanHormonal;
use App\Models\Patient;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BilanHormonalTest extends TestCase
{
    use RefreshDatabase;

    private function makePatient(): Patient
    {
        return Patient::factory()->create();
    }

    public function test_bilan_hormonal_is_created_with_type_hormonal(): void
    {
        $hormonal = BilanHormonal::create([
            'patient_id' => $this->makePatient()->id,
        ]);

        $this->assertEquals('hormonal', $hormonal->fresh()->type);
    }

    public function test_bilan_hormonal_global_scope_excludes_general_bilans(): void
    {
        $patient = $this->makePatient();

        Bilan::create(['patient_id' => $patient->id, 'type' => 'general']);
        BilanHormonal::create(['patient_id' => $patient->id]);

        $hormonaux = BilanHormonal::all();

        $this->assertCount(1, $hormonaux);
        $this->assertEquals('hormonal', $hormonaux->first()->type);
    }

    public function test_bilan_general_is_not_returned_by_bilan_hormonal(): void
    {
        $patient = $this->makePatient();
        $general = Bilan::create(['patient_id' => $patient->id]);

        // Sans le scope, BilanHormonal::find($id) doit retourner null
        // car le type n'est pas 'hormonal'
        $result = BilanHormonal::find($general->id);

        $this->assertNull($result);
    }

    public function test_ref_is_auto_generated_for_bilan_hormonal(): void
    {
        $hormonal = BilanHormonal::create([
            'patient_id' => $this->makePatient()->id,
        ]);

        $this->assertMatchesRegularExpression('/^LAB-\d{4}-\d{2}-\d{3}$/', $hormonal->ref);
    }
}
