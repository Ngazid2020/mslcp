<x-filament-panels::page>

    {{-- ── Sélecteur de date ──────────────────────────────────────────────── --}}
    <x-filament::section>
        <x-slot name="heading">Sélectionner la date</x-slot>

        <div class="flex flex-wrap gap-6 items-end">
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
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>

    {{-- ── Tableau des bilans ──────────────────────────────────────────────── --}}
    @php
        $data        = $this->getCaisseData();
        $bilans      = $data['bilans'];
        $grandTotal  = $data['grand_total'];
        $nbBilans    = $data['nb_bilans'];
        $nbFactures  = $data['nb_factures'];
    @endphp

    <x-filament::section>
        <x-slot name="heading">
            Bilans du
            {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('l d F Y') }}
            &mdash; {{ $nbBilans }} bilan(s) &mdash;
            {{ $nbFactures }} facturé(s)
        </x-slot>

        @if($bilans->isEmpty())
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
                        @foreach($bilans as $bilan)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                                <td class="px-4 py-3 font-mono text-xs text-gray-600 dark:text-gray-300">
                                    {{ $bilan->ref }}
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                    {{ $bilan->patient_nom ?: '—' }}
                                </td>
                                <td class="px-4 py-3">
                                    @if($bilan->type === 'hormonal')
                                        <span class="inline-flex items-center rounded-full bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300 px-2.5 py-0.5 text-xs font-medium">
                                            Hormonal
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-2.5 py-0.5 text-xs font-medium">
                                            Général
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                    {{ $bilan->prescripteur_nom ?: '—' }}
                                </td>
                                <td class="px-4 py-3 text-center text-gray-500 dark:text-gray-400 tabular-nums">
                                    {{ \Carbon\Carbon::parse($bilan->created_at)->format('H:i') }}
                                </td>
                                <td class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                    @if($bilan->nb_analyses_tarif > 0)
                                        {{ $bilan->nb_analyses_tarif }}
                                    @else
                                        <span class="text-gray-300 dark:text-gray-600">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right tabular-nums font-semibold
                                    @if($bilan->total_bilan > 0) text-green-700 dark:text-green-400
                                    @else text-gray-400 dark:text-gray-600 @endif">
                                    @if($bilan->total_bilan > 0)
                                        {{ number_format($bilan->total_bilan, 0, ',', ' ') }} FC
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    {{-- ── Ligne de total ──────────────────────────────────── --}}
                    <tfoot>
                        <tr class="border-t-2 border-gray-300 dark:border-white/20 bg-gray-50 dark:bg-white/5">
                            <td colspan="5" class="px-4 py-3 text-sm font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wide">
                                Total du jour
                            </td>
                            <td class="px-4 py-3 text-center text-sm font-semibold text-gray-700 dark:text-gray-200">
                                {{ $bilans->sum('nb_analyses_tarif') }}
                            </td>
                            <td class="px-4 py-3 text-right tabular-nums text-lg font-bold
                                @if($grandTotal > 0) text-green-700 dark:text-green-400 @else text-gray-400 @endif">
                                {{ number_format($grandTotal, 0, ',', ' ') }} FC
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @endif
    </x-filament::section>

</x-filament-panels::page>
