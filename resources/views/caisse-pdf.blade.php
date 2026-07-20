<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Caisse du {{ $dateParsed->format('d/m/Y') }}</title>
    <style>
        @page { margin: 12mm 10mm 14mm 10mm; }
        * { box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9.5px;
            color: #1a1a2e;
            background: #fff;
            margin: 0; padding: 0;
        }

        /* ── EN-TÊTE ── */
        .header-table { width: 100%; border-collapse: collapse; border-top: 3px solid #1B3A6B; border-bottom: 2px solid #1B3A6B; margin-bottom: 0; }
        .h-logo  { width: 72px; text-align: center; padding: 8px 6px; border-right: 1px solid #d0d8e8; vertical-align: middle; }
        .h-logo img { width: 54px; height: auto; }
        .h-info  { padding: 8px 14px; vertical-align: middle; }
        .h-name  { font-size: 10px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.4px; line-height: 1.5; }
        .h-lab   { font-size: 8.5px; font-weight: bold; letter-spacing: 0.3px; margin: 2px 0 3px; border-bottom: 1px dotted #aab; padding-bottom: 2px; display: inline-block; }
        .h-contact { font-size: 7.5px; color: #555; line-height: 1.8; }
        .h-badge { width: 108px; text-align: center; padding: 8px; border-left: 1px solid #d0d8e8; vertical-align: middle; }
        .h-badge-type  { font-size: 6px; font-weight: bold; text-transform: uppercase; letter-spacing: 1.5px; border: 1px solid #1B3A6B; padding: 2px 4px; color: #1B3A6B; display: inline-block; margin-bottom: 3px; }
        .h-badge-title { font-size: 8.5px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; line-height: 1.6; color: #1B3A6B; }

        /* ── BANDE TITRE ── */
        .doc-title-bar { background-color: #1B3A6B; color: #fff; text-align: center; padding: 5px 0; font-size: 9.5px; font-weight: bold; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px; }

        /* ── BLOC DATE ── */
        .meta-bar { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .meta-bar td { padding: 4px 8px; font-size: 8.5px; border: 1px solid #e0e6f0; }
        .meta-label { background: #edf1fb; color: #1B3A6B; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; width: 25%; }

        /* ── TABLEAU RÉSULTATS ── */
        .rt { width: 100%; border-collapse: collapse; margin-bottom: 12px; font-size: 8.5px; }
        .rt th { background-color: #1B3A6B; color: #fff; font-size: 7px; text-transform: uppercase; letter-spacing: 0.5px; padding: 4px 6px; border: 1px solid #1B3A6B; text-align: left; }
        .rt th.right { text-align: right; }
        .rt td { padding: 4px 6px; border: 1px solid #e0e6f0; vertical-align: middle; }
        .rt tr:nth-child(even) td { background-color: #f6f8fd; }

        .badge { display: inline-block; padding: 1px 5px; border-radius: 3px; font-size: 6.5px; font-weight: bold; text-transform: uppercase; }
        .badge-general  { background: #dbeafe; color: #1d4ed8; }
        .badge-hormonal { background: #ede9fe; color: #6d28d9; }
        .badge-urinaire { background: #fef3c7; color: #b45309; }

        .v-green { color: #15803d; font-weight: bold; }
        .v-gray  { color: #999; }
        .right   { text-align: right; }
        .center  { text-align: center; }
        .mono    { font-family: 'DejaVu Sans Mono', monospace; font-size: 7.5px; }

        /* ── TOTAL ── */
        .total-row td { background: #1B3A6B; color: #fff; font-weight: bold; padding: 5px 6px; border: 1px solid #1B3A6B; }
        .total-amount { font-size: 11px; }

        /* ── PIED ── */
        .rule { border-top: 1px solid #c8d3ea; margin: 8px 0 5px; }
        .footer-table { width: 100%; border-collapse: collapse; }
        .footer-table td { padding: 3px 4px; font-size: 7.5px; vertical-align: bottom; }
        .sig-name  { font-weight: bold; font-size: 9px; color: #1B3A6B; }
        .sig-title { font-size: 7.5px; font-style: italic; color: #666; }
        .sig-line  { border-top: 1px solid #1B3A6B; width: 120px; display: inline-block; margin-top: 20px; }
    </style>
</head>
<body>

{{-- EN-TÊTE --}}
<table class="header-table">
    <tr>
        <td class="h-logo"><img src="{{ public_path('img/logo.png') }}" alt="Logo MSLCP"></td>
        <td class="h-info">
            <div class="h-name">Maison de Surveillance et de Lutte contre le Paludisme (MSLCP)</div>
            <div class="h-lab">Laboratoire d'Analyses Médicales</div>
            <div class="h-contact">
                Dirigée par <strong>Mme Rahamatou SILAI</strong> &mdash; Parasitologue / MSc Biochimie<br>
                Tél : {{ $contact['tel1'] ?? '' }} / {{ $contact['tel2'] ?? '' }}
                &nbsp;|&nbsp; Email : {{ $contact['email'] ?? '' }}
            </div>
        </td>
        <td class="h-badge">
            <div class="h-badge-type">Laboratoire</div><br>
            <div class="h-badge-title">Récapitulatif<br>Caisse</div>
        </td>
    </tr>
</table>

<div class="doc-title-bar">RÉCAPITULATIF DE CAISSE</div>

{{-- MÉTA --}}
<table class="meta-bar">
    <tr>
        <td class="meta-label">Date</td>
        <td>{{ $dateParsed->translatedFormat('l d F Y') }}</td>
        <td class="meta-label">Type</td>
        <td>
            @php
                $typeLabel = match($typeFilter) {
                    'general'  => 'Bilans généraux',
                    'hormonal' => 'Bilans hormonaux',
                    'urinaire' => 'Bilans urinaires',
                    default    => 'Tous les bilans',
                };
            @endphp
            {{ $typeLabel }}
        </td>
        <td class="meta-label">Total bilans</td>
        <td>{{ $lignes->count() }}</td>
    </tr>
</table>

{{-- TABLEAU --}}
<table class="rt">
    <thead>
        <tr>
            <th style="width:12%">Référence</th>
            <th style="width:26%">Patient</th>
            <th style="width:10%">Type</th>
            <th style="width:20%">Prescripteur</th>
            <th class="center" style="width:8%">Heure</th>
            <th class="center" style="width:8%">Éléments</th>
            <th class="right" style="width:16%">Montant (FC)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($lignes as $ligne)
        <tr>
            <td class="mono">{{ $ligne->ref ?? '—' }}</td>
            <td>{{ $ligne->patient_nom ?: '—' }}</td>
            <td>
                @php
                    [$badgeLabel, $badgeClass] = match($ligne->type_bilan) {
                        'hormonal' => ['Hormonal',  'badge-hormonal'],
                        'urinaire' => ['Urinaire',  'badge-urinaire'],
                        default    => ['Général',   'badge-general'],
                    };
                @endphp
                <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
            </td>
            <td>{{ $ligne->prescripteur_nom ?: '—' }}</td>
            <td class="center">{{ \Carbon\Carbon::parse($ligne->created_at)->format('H:i') }}</td>
            <td class="center">
                @if($ligne->source === 'urinaire')
                    <span class="v-gray" style="font-size:7px;font-style:italic;">forfait</span>
                @else
                    {{ $ligne->nb_analyses_tarif > 0 ? $ligne->nb_analyses_tarif : '—' }}
                @endif
            </td>
            <td class="right {{ $ligne->total_ligne > 0 ? 'v-green' : 'v-gray' }}">
                {{ $ligne->total_ligne > 0 ? number_format($ligne->total_ligne, 0, ',', ' ') : '—' }}
            </td>
        </tr>
        @endforeach
    </tbody>
    <tr class="total-row">
        <td colspan="5">TOTAL DU JOUR</td>
        <td class="center">{{ $lignes->sum('nb_analyses_tarif') }}</td>
        <td class="right total-amount">{{ number_format($grandTotal, 0, ',', ' ') }} FC</td>
    </tr>
</table>

{{-- PIED DE PAGE --}}
<div class="rule"></div>
<table class="footer-table">
    <tr>
        <td style="width:55%; font-size:7.5px; color:#888; font-style:italic;">
            Document généré le {{ now()->translatedFormat('d F Y à H:i') }}
        </td>
        <td style="width:45%; text-align:right;">
            <div style="font-size:7px; text-transform:uppercase; letter-spacing:0.8px; color:#888;">Responsable du Laboratoire</div>
            <img src="{{ public_path('img/signature.png') }}" alt="Signature" style="width:130px; height:auto; display:block; margin-left:auto; margin-top:4px;">
            <div class="sig-name">Mme Rahamatou SILAI</div>
            <div class="sig-title">Parasitologue / MSc Biochimie</div>
        </td>
    </tr>
</table>

</body>
</html>
