<x-filament-panels::page>

    {{-- ── Filtres ───────────────────────────────────────────────────────── --}}
    <x-filament::section>
        <x-slot name="heading">Filtres</x-slot>

        <div class="flex flex-wrap gap-6 items-end">
            <div class="flex flex-col gap-2 min-w-[240px]">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Maladie</label>
                <div class="relative">
                    <select wire:model.live="maladie_id"
                            class="w-full appearance-none rounded-lg border border-gray-300 dark:border-white/20 bg-white dark:bg-white/5 text-gray-900 dark:text-white pl-4 pr-10 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">— Toutes les maladies —</option>
                        @foreach($this->getMaladies() as $id => $nom)
                            <option value="{{ $id }}">{{ $nom }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-2 min-w-[120px]">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Année</label>
                <div class="relative">
                    <select wire:model.live="annee"
                            class="w-full appearance-none rounded-lg border border-gray-300 dark:border-white/20 bg-white dark:bg-white/5 text-gray-900 dark:text-white pl-4 pr-10 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        @foreach($this->getYears() as $y => $label)
                            <option value="{{ $y }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>

    @php
        $monthly = $this->getMonthlyData();
        $meta    = $monthly['_meta'];
        $total   = $monthly['total'];
        $maxCas  = $meta['max_cas'];
    @endphp

    {{-- ── KPIs synthèse ────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <x-filament::section>
            <div class="text-center py-2">
                <div class="text-3xl font-bold text-primary-600 dark:text-primary-400">{{ $meta['total_cas'] }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">cas détectés en {{ $this->annee }}</div>
                <div class="text-xs text-gray-400 mt-0.5">{{ $this->getSelectedMaladieName() }}</div>
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-center py-2">
                <div class="text-3xl font-bold text-amber-600 dark:text-amber-400">{{ $meta['peak_mois'] }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">pic épidémique (mois le plus chargé)</div>
                <div class="text-xs text-gray-400 mt-0.5">{{ $maxCas }} cas</div>
            </div>
        </x-filament::section>

        <x-filament::section>
            <div class="text-center py-2">
                <div class="text-3xl font-bold {{ $total['pct'] > 25 ? 'text-danger-600 dark:text-danger-400' : 'text-success-600 dark:text-success-400' }}">
                    {{ $total['pct'] }}%
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">des bilans concernés</div>
                <div class="text-xs text-gray-400 mt-0.5">sur {{ $total['total_bilans'] }} bilans généraux</div>
            </div>
        </x-filament::section>
    </div>

    {{-- ── Tableau mensuel + barres CSS ────────────────────────────────── --}}
    <x-filament::section>
        <x-slot name="heading">Évolution mensuelle — {{ $this->annee }}</x-slot>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="text-left py-2 pr-4 font-semibold text-gray-700 dark:text-gray-300">Mois</th>
                        <th class="text-right py-2 px-4 font-semibold text-gray-700 dark:text-gray-300 w-20">Cas</th>
                        <th class="text-right py-2 px-4 font-semibold text-gray-700 dark:text-gray-300 w-24">Bilans</th>
                        <th class="text-right py-2 px-4 font-semibold text-gray-700 dark:text-gray-300 w-20">%</th>
                        <th class="py-2 pl-4 font-semibold text-gray-700 dark:text-gray-300">Distribution</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @for($m = 1; $m <= 12; $m++)
                        @php $row = $monthly[$m]; @endphp
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="py-2 pr-4 font-medium text-gray-800 dark:text-gray-200">{{ $row['mois'] }}</td>
                            <td class="py-2 px-4 text-right font-semibold {{ $row['cas'] > 0 ? 'text-primary-700 dark:text-primary-400' : 'text-gray-400' }}">
                                {{ $row['cas'] }}
                            </td>
                            <td class="py-2 px-4 text-right text-gray-500 dark:text-gray-400">{{ $row['total_bilans'] }}</td>
                            <td class="py-2 px-4 text-right {{ $row['pct'] > 25 ? 'text-danger-600 font-semibold' : 'text-gray-600 dark:text-gray-300' }}">
                                {{ $row['pct'] > 0 ? $row['pct'].'%' : '—' }}
                            </td>
                            <td class="py-2 pl-4 w-full">
                                @if($row['cas'] > 0 && $maxCas > 0)
                                    <div class="h-4 rounded-full bg-primary-500/20 overflow-hidden">
                                        <div class="h-full rounded-full bg-primary-500 transition-all duration-500"
                                             style="width: {{ round($row['cas'] / $maxCas * 100) }}%"></div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endfor
                </tbody>
                <tfoot>
                    <tr class="border-t-2 border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800/50 font-bold">
                        <td class="py-2 pr-4 text-gray-900 dark:text-gray-100">Total</td>
                        <td class="py-2 px-4 text-right text-primary-700 dark:text-primary-400">{{ $total['cas'] }}</td>
                        <td class="py-2 px-4 text-right text-gray-600 dark:text-gray-300">{{ $total['total_bilans'] }}</td>
                        <td class="py-2 px-4 text-right {{ $total['pct'] > 25 ? 'text-danger-600' : 'text-gray-700 dark:text-gray-200' }}">
                            {{ $total['total_bilans'] > 0 ? $total['pct'].'%' : '—' }}
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </x-filament::section>

    {{-- ── Exports ──────────────────────────────────────────────────────── --}}
    <x-filament::section>
        <x-slot name="heading">Exporter</x-slot>

        <div class="flex flex-wrap gap-3">
            <a href="{{ route('rapport.pdf', ['maladie_id' => $this->maladie_id, 'annee' => $this->annee]) }}"
               target="_blank"
               class="inline-flex items-center gap-2 rounded-lg bg-primary-600 hover:bg-primary-700 text-white font-medium px-4 py-2 text-sm transition-colors">
                <x-heroicon-o-document-arrow-down class="w-4 h-4"/>
                Exporter PDF
            </a>

            <a href="{{ route('rapport.csv', ['maladie_id' => $this->maladie_id, 'annee' => $this->annee]) }}"
               class="inline-flex items-center gap-2 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium px-4 py-2 text-sm transition-colors">
                <x-heroicon-o-table-cells class="w-4 h-4"/>
                Exporter CSV
            </a>
        </div>
    </x-filament::section>

</x-filament-panels::page>
