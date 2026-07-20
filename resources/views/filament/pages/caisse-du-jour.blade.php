<x-filament-panels::page>

    {{-- ── Filtres ─────────────────────────────────────────────────────────── --}}
    <x-filament::section>
        <x-slot name="heading">Filtres</x-slot>

        <div class="flex flex-wrap gap-6 items-end">

            {{-- Sélecteur de date --}}
            <div class="flex flex-col gap-2 min-w-[280px]">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                <div class="relative">
                    <select wire:model.live="selectedDate"
                            class="w-full appearance-none rounded-lg border border-gray-300 dark:border-white/20 bg-white dark:bg-white/5 text-gray-900 dark:text-white pl-4 pr-10 py-2.5 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500">
                        @foreach($this->getDateOptions() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                    </div>
                </div>
            </div>

            {{-- Filtre par type --}}
            <div class="flex flex-col gap-2">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                <div class="flex gap-2 flex-wrap">
                    @foreach(['tous' => 'Tous', 'general' => 'Général', 'hormonal' => 'Hormonal', 'urinaire' => 'Urinaire'] as $val => $label)
                        <button wire:click="$set('typeFilter', '{{ $val }}')"
                                class="px-3 py-2 rounded-lg text-sm font-medium transition-colors
                                    {{ $typeFilter === $val
                                        ? 'bg-primary-600 text-white shadow'
                                        : 'bg-white dark:bg-white/5 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-white/20 hover:bg-gray-50 dark:hover:bg-white/10' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Bouton PDF --}}
            <div class="flex flex-col gap-2 ml-auto">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300 opacity-0 select-none">Export</label>
                <a href="{{ $this->getPdfUrl() }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium shadow transition-colors">
                    <x-heroicon-o-document-arrow-down class="h-4 w-4"/>
                    Exporter PDF
                </a>
            </div>

        </div>
    </x-filament::section>

    {{-- ── Tableau ─────────────────────────────────────────────────────────── --}}
    @php
        $data       = $this->getCaisseData();
        $lignes     = $data['lignes'];
        $grandTotal = $data['grand_total'];
        $nbTotal    = $data['nb_total'];
        $nbFactures = $data['nb_factures'];
    @endphp

    <x-filament::section>
        <x-slot name="heading">
            {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l d F Y') }}
            &mdash; {{ $nbTotal }} bilan(s) &mdash; {{ $nbFactures }} facturé(s)
        </x-slot>

        @if($lignes->isEmpty())
            <div class="py-12 text-center text-gray-400 dark:text-gray-500">
                <x-heroicon-o-document-magnifying-glass class="mx-auto h-10 w-10 mb-3 opacity-50"/>
                Aucun bilan enregistré ce jour.
            </div>
        @else
            <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-white/10">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 dark:bg-white/5 text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-3">Référence</th>
                            <th class="px-4 py-3">Patient</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">Prescripteur</th>
                            <th class="px-4 py-3 text-center">Heure</th>
                            <th class="px-4 py-3 text-center">Éléments tarifés</th>
                            <th class="px-4 py-3 text-right">Montant</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @foreach($lignes as $ligne)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                <td class="px-4 py-3 font-mono text-xs text-gray-500 dark:text-gray-400">
                                    {{ $ligne->ref ?? '—' }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                    {{ $ligne->patient_nom ?: '—' }}
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $badge = match($ligne->type_bilan) {
                                            'hormonal'  => ['Hormonal',  'bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300'],
                                            'urinaire'  => ['Urinaire',  'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300'],
                                            default     => ['Général',   'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300'],
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badge[1] }}">
                                        {{ $badge[0] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                                    {{ $ligne->prescripteur_nom ?: '—' }}
                                </td>
                                <td class="px-4 py-3 text-center text-gray-500 dark:text-gray-400 tabular-nums">
                                    {{ \Carbon\Carbon::parse($ligne->created_at)->format('H:i') }}
                                </td>
                                <td class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    @if($ligne->source === 'urinaire')
                                        <span class="text-gray-300 dark:text-gray-600 text-xs italic">forfait</span>
                                    @elseif($ligne->nb_analyses_tarif > 0)
                                        {{ $ligne->nb_analyses_tarif }}
                                    @else
                                        <span class="text-gray-300 dark:text-gray-600">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right tabular-nums font-semibold
                                    {{ $ligne->total_ligne > 0 ? 'text-green-700 dark:text-green-400' : 'text-gray-400 dark:text-gray-600' }}">
                                    {{ $ligne->total_ligne > 0 ? number_format($ligne->total_ligne, 0, ',', ' ') . ' FC' : '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr class="border-t-2 border-gray-300 dark:border-white/20 bg-gray-50 dark:bg-white/5">
                            <td colspan="5" class="px-4 py-3 font-semibold text-gray-700 dark:text-gray-200 text-sm uppercase tracking-wide">
                                Total du jour
                            </td>
                            <td class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-200">
                                {{ $lignes->sum('nb_analyses_tarif') }}
                            </td>
                            <td class="px-4 py-3 text-right tabular-nums text-lg font-bold
                                {{ $grandTotal > 0 ? 'text-green-700 dark:text-green-400' : 'text-gray-400' }}">
                                {{ number_format($grandTotal, 0, ',', ' ') }} FC
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </x-filament::section>

</x-filament-panels::page>
