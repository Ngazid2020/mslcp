<?php

namespace Tests\Feature;

use App\Filament\Resources\BilanResource\Pages\ListBilans;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FilamentBilanResourceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_bilan_list_page_can_be_rendered(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->assignRole('admin');
        $user->givePermissionTo('view Bilan');
        $user->guard(['web'])->login($user);

        Livewire::test(ListBilans::class)
        ->assertStatus(200)
        ->assertSee('Référence');
    }
}
