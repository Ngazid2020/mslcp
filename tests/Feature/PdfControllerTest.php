<?php

namespace Tests\Feature;

use App\Models\Bilan;
use App\Models\BilanUrinaire;
use App\Models\Patient;
use App\Models\Prescripteur;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PdfControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::create(['name' => 'download Bilan', 'guard_name' => 'web']);
    }

    private function authenticatedUser(): User
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->givePermissionTo('download Bilan');
        $this->actingAs($user);

        return $user;
    }

    public function test_bilan_pdf_returns_404_for_nonexistent_record(): void
    {
        $this->authenticatedUser();

        $response = $this->get(route('pdf.bilan', 99999));

        $response->assertStatus(404);
    }

    public function test_hormonal_pdf_returns_404_for_nonexistent_record(): void
    {
        $this->authenticatedUser();

        $response = $this->get(route('pdf.hormonal', 99999));

        $response->assertStatus(404);
    }

    public function test_bilanurinaire_pdf_returns_404_for_nonexistent_record(): void
    {
        $this->authenticatedUser();

        $response = $this->get(route('pdf.bilanurinaire', 99999));

        $response->assertStatus(404);
    }

    public function test_bilan_pdf_returns_200_for_valid_bilan(): void
    {
        $this->authenticatedUser();

        $patient = Patient::factory()->create();
        $bilan = Bilan::create(['patient_id' => $patient->id]);

        $response = $this->get(route('pdf.bilan', $bilan->id));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_bilanurinaire_pdf_returns_200_for_valid_record(): void
    {
        $this->authenticatedUser();

        $patient = Patient::factory()->create();
        $bilan = BilanUrinaire::create(['patient_id' => $patient->id]);

        $response = $this->get(route('pdf.bilanurinaire', $bilan->id));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }
}
