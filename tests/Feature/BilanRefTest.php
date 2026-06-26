<?php

namespace Tests\Feature;

use App\Models\Bilan;
use App\Models\Patient;
use App\Models\Prescripteur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BilanRefTest extends TestCase
{
    use RefreshDatabase;

    private function makePatient(): Patient
    {
        return Patient::factory()->create();
    }

    private function makePrescripteur(): Prescripteur
    {
        return Prescripteur::factory()->create();
    }

    public function test_bilan_ref_is_auto_generated_on_create(): void
    {
        $bilan = Bilan::create([
            'patient_id' => $this->makePatient()->id,
            'prescripteur_id' => $this->makePrescripteur()->id,
        ]);

        $this->assertNotNull($bilan->ref);
        $this->assertMatchesRegularExpression('/^LAB-\d{4}-\d{2}-\d{3}$/', $bilan->ref);
    }

    public function test_bilan_ref_contains_current_year_and_month(): void
    {
        $bilan = Bilan::create([
            'patient_id' => $this->makePatient()->id,
        ]);

        $year = date('Y');
        $month = date('m');

        $this->assertStringStartsWith("LAB-{$year}-{$month}-", $bilan->ref);
    }

    public function test_sequential_bilans_have_incrementing_ref(): void
    {
        $patient = $this->makePatient();

        $first = Bilan::create(['patient_id' => $patient->id]);
        $second = Bilan::create(['patient_id' => $patient->id]);

        $firstSeq = (int) substr($first->ref, -3);
        $secondSeq = (int) substr($second->ref, -3);

        $this->assertGreaterThan($firstSeq, $secondSeq);
    }

    public function test_bilan_belongs_to_patient(): void
    {
        $patient = $this->makePatient();
        $bilan = Bilan::create(['patient_id' => $patient->id]);

        $this->assertEquals($patient->id, $bilan->patient->id);
    }

    public function test_bilan_ref_is_not_regenerated_on_update(): void
    {
        $bilan = Bilan::create([
            'patient_id' => $this->makePatient()->id,
        ]);

        $originalRef = $bilan->ref;
        $bilan->update(['type' => 'general']);

        $this->assertEquals($originalRef, $bilan->fresh()->ref);
    }
}
