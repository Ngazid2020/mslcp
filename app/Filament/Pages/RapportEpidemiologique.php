<?php

namespace App\Filament\Pages;

use App\Models\Bilan;
use App\Models\Maladie;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class RapportEpidemiologique extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-document-chart-bar';
    protected static ?string $navigationGroup = 'Rapports';
    protected static ?string $navigationLabel = 'Rapport épidémiologique';
    protected static ?int    $navigationSort  = 1;
    protected static string  $view            = 'filament.pages.rapport-epidemiologique';

    public ?int $maladie_id = null;
    public int  $annee;

    public static function canAccess(): bool
    {
        return auth()->user()?->can('view Rapports') ?? false;
    }

    public function mount(): void
    {
        $this->annee = (int) now()->year;
    }

    public function getMaladies(): array
    {
        return Maladie::query()
            ->where('actif', true)
            ->orderBy('nom')
            ->pluck('nom', 'id')
            ->toArray();
    }

    public function getYears(): array
    {
        $current = (int) now()->year;
        $years = [];
        for ($y = $current; $y >= $current - 5; $y--) {
            $years[$y] = (string) $y;
        }
        return $years;
    }

    /** @return array<int|string, mixed> */
    public function getMonthlyData(): array
    {
        $labelsFr = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];

        $data     = [];
        $totalCas = 0;
        $maxCas   = 0;
        $peakMois = null;

        for ($m = 1; $m <= 12; $m++) {
            $query = DB::table('bilan_maladie')
                ->join('bilans', 'bilan_maladie.bilan_id', '=', 'bilans.id')
                ->whereYear('bilans.created_at', $this->annee)
                ->whereMonth('bilans.created_at', $m);

            if ($this->maladie_id) {
                $query->where('bilan_maladie.maladie_id', '=', $this->maladie_id);
            }

            $cas = $query->count();

            $totalBilans = Bilan::query()
                ->whereYear('created_at', '=', $this->annee)
                ->whereMonth('created_at', '=', $m)
                ->count();

            $totalCas += $cas;

            if ($cas > $maxCas) {
                $maxCas   = $cas;
                $peakMois = $labelsFr[$m - 1];
            }

            $data[$m] = [
                'mois'         => $labelsFr[$m - 1],
                'cas'          => $cas,
                'total_bilans' => $totalBilans,
                'pct'          => $totalBilans > 0 ? round($cas / $totalBilans * 100, 1) : 0.0,
            ];
        }

        $totalBilansAnnee = Bilan::query()
            ->whereYear('created_at', '=', $this->annee)
            ->count();

        $data['total'] = [
            'mois'         => 'Total',
            'cas'          => $totalCas,
            'total_bilans' => $totalBilansAnnee,
            'pct'          => $totalBilansAnnee > 0 ? round($totalCas / $totalBilansAnnee * 100, 1) : 0.0,
        ];

        $data['_meta'] = [
            'max_cas'   => $maxCas,
            'total_cas' => $totalCas,
            'peak_mois' => $peakMois ?? '—',
        ];

        return $data;
    }

    public function getSelectedMaladieName(): string
    {
        if (!$this->maladie_id) {
            return 'Toutes les maladies';
        }

        return Maladie::query()->find($this->maladie_id)?->nom ?? '—';
    }
}
