<x-filament-widgets::widget>
    <div class="grid grid-cols-1 gap-4">
        @if($reactifsAlerte->count() > 0)
        <div class="bg-red-50 border-l-4 border-red-500 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <x-heroicon-o-exclamation-circle class="h-5 w-5 text-red-500" />
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        Alerte stock : {{ $reactifsAlerte->count() }} réactif(s) sous le seuil
                    </h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($reactifsAlerte as $r)
                            <li>
                                <strong>{{ $r['nom'] }}</strong> :
                                {{ number_format($r['stock'], 2) }} {{ $r['unite'] }}
                                (seuil : {{ $r['seuil'] }} {{ $r['unite'] }})
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($lotsPerimes->count() > 0)
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <x-heroicon-o-clock class="h-5 w-5 text-yellow-500" />
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">
                        Lots périmés : {{ $lotsPerimes->count() }} lot(s) à mettre au rebut
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($lotsPerimes as $l)
                            <li>
                                <strong>{{ $l['nom'] }}</strong> -
                                Lot {{ $l['lot'] }}
                                (périmé le {{ $l['peremption'] }})
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($reactifsAlerte->count() === 0 && $lotsPerimes->count() === 0)
        <div class="bg-green-50 border-l-4 border-green-500 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <x-heroicon-o-check-circle class="h-5 w-5 text-green-500" />
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">
                        ✅ Tous les stocks sont suffisants et aucun lot périmé.
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
</x-filament-widgets::widget>