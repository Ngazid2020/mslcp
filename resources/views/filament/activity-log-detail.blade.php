<div class="space-y-4 text-sm">

    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Date</p>
            <p>{{ $record->created_at->format('d/m/Y à H:i:s') }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Utilisateur</p>
            <p>{{ $record->causer?->name ?? 'Système' }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Entité</p>
            <p>{{ $record->subject_type }} #{{ $record->subject_id }}</p>
        </div>
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Événement</p>
            <p>{{ $record->event }}</p>
        </div>
    </div>

    @php
        $props = is_string($record->properties)
            ? json_decode($record->properties, true)
            : (array) $record->properties;
        $new = $props['attributes'] ?? [];
        $old = $props['old'] ?? [];
    @endphp

    @if(!empty($new))
        <div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Valeurs</p>
            <table class="w-full text-xs border-collapse">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="text-left px-2 py-1 font-medium">Champ</th>
                        @if(!empty($old))<th class="text-left px-2 py-1 font-medium">Avant</th>@endif
                        <th class="text-left px-2 py-1 font-medium">Après</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($new as $key => $val)
                        @php $changed = array_key_exists($key, $old) && $old[$key] != $val; @endphp
                        <tr class="border-t border-gray-200 dark:border-gray-600 {{ $changed ? 'bg-yellow-50 dark:bg-yellow-900/20' : '' }}">
                            <td class="px-2 py-1 font-mono text-gray-600">{{ $key }}</td>
                            @if(!empty($old))
                                <td class="px-2 py-1 {{ $changed ? 'line-through text-red-500' : 'text-gray-400' }}">
                                    {{ is_array($old[$key] ?? null) ? json_encode($old[$key]) : ($old[$key] ?? '—') }}
                                </td>
                            @endif
                            <td class="px-2 py-1 {{ $changed ? 'text-green-700 dark:text-green-400 font-semibold' : '' }}">
                                {{ is_array($val) ? json_encode($val) : ($val ?? '—') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-400 italic">Aucune donnée enregistrée.</p>
    @endif

</div>
