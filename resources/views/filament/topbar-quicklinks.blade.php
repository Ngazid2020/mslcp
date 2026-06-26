@auth
@php
    $links = [
        [
            'label'  => 'Bilans',
            'url'    => route('filament.admin.resources.bilans.index'),
            'icon'   => 'heroicon-o-beaker',
            'active' => request()->is('admin/bilans') || request()->is('admin/bilans/*'),
            'can'    => true,
        ],
        [
            'label'  => 'Bilan urinaire',
            'url'    => route('filament.admin.resources.bilan-urinaires.index'),
            'icon'   => 'heroicon-o-eye-dropper',
            'active' => request()->is('admin/bilan-urinaires*'),
            'can'    => true,
        ],
        [
            'label'  => 'Maladies',
            'url'    => route('filament.admin.resources.maladies.index'),
            'icon'   => 'heroicon-o-bug-ant',
            'active' => request()->is('admin/maladies*'),
            'can'    => auth()->user()?->hasRole('administrateur') ?? false,
        ],
        [
            'label'  => 'Rapports',
            'url'    => route('filament.admin.pages.rapport-epidemiologique'),
            'icon'   => 'heroicon-o-document-chart-bar',
            'active' => request()->is('admin/rapport*'),
            'can'    => auth()->user()?->can('view Rapports') ?? false,
        ],
    ];
@endphp

<div class="flex items-center gap-x-1 me-2 border-e border-gray-200 pe-4 dark:border-white/10">
    @foreach ($links as $link)
        @if ($link['can'])
            <a href="{{ $link['url'] }}"
               @class([
                   'inline-flex items-center gap-x-1.5 rounded-lg px-3 py-1.5 text-sm font-medium transition',
                   'bg-primary-50 text-primary-700 dark:bg-primary-500/10 dark:text-primary-400' => $link['active'],
                   'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-white/5 dark:hover:text-white' => ! $link['active'],
               ])>
                <x-dynamic-component :component="$link['icon']" class="h-4 w-4 shrink-0" />
                {{ $link['label'] }}
            </a>
        @endif
    @endforeach
</div>
@endauth
