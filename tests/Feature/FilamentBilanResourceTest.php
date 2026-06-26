<?php

namespace Tests\Feature;

use App\Filament\Resources\BilanResource\Pages\ListBilans;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class FilamentBilanResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Permissions requises par BilanPolicy
        Permission::create(['name' => 'view-any Bilan', 'guard_name' => 'web']);
        Permission::create(['name' => 'view Bilan', 'guard_name' => 'web']);
    }

    public function test_bilan_list_page_can_be_rendered(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->givePermissionTo(['view-any Bilan', 'view Bilan']);

        $this->actingAs($user);

        Livewire::test(ListBilans::class)
            ->assertStatus(200)
            ->assertSee('Référence');
    }

    public function test_unauthenticated_user_cannot_access_bilan_list(): void
    {
        $response = $this->get('/admin/bilans');

        $response->assertRedirect();
    }

    public function test_user_without_permission_cannot_see_bilans(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/admin/bilans');

        // Filament renvoie 403 si la policy interdit l'accès
        $response->assertStatus(403);
    }
}
