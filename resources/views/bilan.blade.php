<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bilan d'Analyse — MSLCP</title>
    <style>
        @page { margin: 12mm 10mm 14mm 10mm; }

        * { box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #1a1a2e;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        /* ── FILIGRANE ──────────────────────────────────────── */
        .watermark {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            text-align: center;
            padding-top: 260px;
            z-index: -1000;
        }
        .watermark span {
            font-size: 160px;
            font-weight: bold;
            color: #eaeff7;
            display: inline-block;
            transform: rotate(-35deg);
            letter-spacing: 30px;
        }

        /* ── EN-TÊTE ────────────────────────────────────────── */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-top: 3px solid #1B3A6B;
            border-bottom: 2px solid #1B3A6B;
            margin-bottom: 0;
        }
        .h-logo {
            width: 72px; text-align: center;
            padding: 8px 6px;
            border-right: 1px solid #d0d8e8;
            vertical-align: middle;
        }
        .h-logo img { width: 54px; height: auto; }
        .h-info { padding: 8px 14px; vertical-align: middle; }
        .h-name {
            font-size: 10.5px; font-weight: bold;
            text-transform: uppercase; letter-spacing: 0.5px; line-height: 1.5;
        }
        .h-lab {
            font-size: 9px; font-weight: bold;
            letter-spacing: 0.3px; margin: 3px 0 4px;
            border-bottom: 1px dotted #aab;
            padding-bottom: 3px; display: inline-block;
        }
        .h-contact { font-size: 8px; color: #555; line-height: 1.9; }
        .h-badge {
            width: 108px; text-align: center;
            padding: 8px; border-left: 1px solid #d0d8e8;
            vertical-align: middle;
        }
        .h-badge-type {
            font-size: 6.5px; font-weight: bold; text-transform: uppercase;
            letter-spacing: 1.5px; border: 1px solid #1B3A6B;
            padding: 2px 5px; color: #1B3A6B;
            display: inline-block; margin-bottom: 4px;
        }
        .h-badge-title {
            font-size: 9px; font-weight: bold;
            text-transform: uppercase; letter-spacing: 0.5px;
            line-height: 1.6; color: #1B3A6B;
        }

        /* ── BANDE TITRE ────────────────────────────────────── */
        .doc-title-bar {
            background-color: #1B3A6B; color: #fff;
            text-align: center; padding: 5px 0;
            font-size: 10px; font-weight: bold;
            letter-spacing: 2.5px; text-transform: uppercase;
            margin-bottom: 10px;
        }

        /* ── BLOC PATIENT ───────────────────────────────────── */
        .patient-outer {
            border: 1px solid #1B3A6B;
            margin-bottom: 12px;
        }
        .patient-bar {
            background-color: #1B3A6B; color: #fff;
            padding: 3px 8px; font-size: 7.5px;
            font-weight: bold; letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        .patient-grid { width: 100%; border-collapse: collapse; }
        .patient-grid td {
            padding: 4px 8px; font-size: 9px;
            vertical-align: top;
        }
        .p-label {
            font-size: 7.5px; color: #6B7A99;
            text-transform: uppercase; letter-spacing: 0.5px;
            margin-bottom: 1px;
        }
        .p-value { font-weight: bold; font-size: 10px; color: #1a1a2e; }
        .patient-row2 td { border-top: 1px solid #e0e6f0; }

        /* ── EN-TÊTE DE SECTION ─────────────────────────────── */
        .section-hd {
            background-color: #1B3A6B; color: #fff;
            padding: 5px 10px;
            font-size: 8.5px; font-weight: bold;
            letter-spacing: 1px; text-transform: uppercase;
        }

        /* ── TABLEAU DE RÉSULTATS ───────────────────────────── */
        .rt {
            width: 100%; border-collapse: collapse;
            margin-bottom: 10px; font-size: 9.5px;
        }
        .rt th {
            background-color: #edf1fb; color: #1B3A6B;
            font-size: 7.5px; text-transform: uppercase;
            letter-spacing: 0.5px; padding: 4px 8px;
            border: 1px solid #c8d3ea; text-align: center;
        }
        .rt td {
            padding: 4px 8px;
            border: 1px solid #e0e6f0;
            vertical-align: middle;
        }
        .rt tr:nth-child(even) td { background-color: #f6f8fd; }

        .c-name  { width: 35%; text-align: left; }
        .c-val   { width: 14%; text-align: center; font-weight: bold; }
        .c-unit  { width: 14%; text-align: center; color: #666; }
        .c-ref   { width: 27%; text-align: center; color: #666; font-size: 8.5px; }
        .c-stat  { width: 10%; text-align: center; }

        .v-ok   { color: #1a7f37; }
        .v-hi   { color: #c0392b; }
        .v-lo   { color: #d35400; }
        .s-ok   { color: #1a7f37; font-size: 12px; font-weight: bold; }
        .s-hi   { color: #c0392b; font-size: 11px; font-weight: bold; }
        .s-lo   { color: #d35400; font-size: 11px; font-weight: bold; }
        .s-na   { color: #bbb; }

        /* ── PIED DE PAGE ───────────────────────────────────── */
        .rule { border-top: 1px solid #c8d3ea; margin: 10px 0 6px; }
        .footer-table { width: 100%; border-collapse: collapse; }
        .footer-table td { padding: 3px 4px; font-size: 8.5px; vertical-align: bottom; }
        .sig-label { font-size: 7.5px; text-transform: uppercase; letter-spacing: 0.8px; color: #888; }
        .sig-name  { font-weight: bold; font-size: 10px; color: #1B3A6B; }
        .sig-title { font-size: 8px; font-style: italic; color: #666; }
        .sig-line  { border-top: 1px solid #1B3A6B; width: 130px; display: inline-block; margin-top: 22px; }
    </style>
</head>
<body>

<div class="watermark"><span>MSLCP</span></div>

{{-- EN-TÊTE --}}
<table class="header-table">
    <tr>
        <td class="h-logo">
            <img src="{{ public_path('img/logo.png') }}" alt="Logo MSLCP">
        </td>
        <td class="h-info">
            <div class="h-name">Maison de Surveillance et de Lutte contre le Paludisme (MSLCP)</div>
            <div class="h-lab">Laboratoire d'Analyses Médicales</div>
            <div class="h-contact">
                Dirigée par <strong>Mme Rahamatou SILAI</strong> &mdash; Parasitologue / MSc Biochimie<br>
                Tél : {{ config('mslcp.contact.tel1') }} / {{ config('mslcp.contact.tel2') }}
                &nbsp;|&nbsp; Email : {{ config('mslcp.contact.email') }}
            </div>
        </td>
        <td class="h-badge">
            <div class="h-badge-type">Laboratoire</div><br>
            <div class="h-badge-title">Résultat<br>d'Analyse</div>
        </td>
    </tr>
</table>

<div class="doc-title-bar">BILAN D'ANALYSE MÉDICALE</div>

{{-- PATIENT + QR CODE --}}
<table style="width:100%; border-collapse:collapse; margin-bottom:12px;">
    <tr>
        <td style="width:76%; vertical-align:top;">
            <div class="patient-outer">
                <div class="patient-bar">Informations patient &amp; prescription</div>
                <table class="patient-grid">
                    <tr>
                        <td>
                            <div class="p-label">Patient</div>
                            <div class="p-value">{{ $record->patient->nom ?? '' }} {{ $record->patient->prenom ?? '' }}</div>
                        </td>
                        <td>
                            <div class="p-label">Âge</div>
                            <div class="p-value">{{ $record->patient->age ?? '—' }} ans</div>
                        </td>
                        <td>
                            <div class="p-label">Sexe</div>
                            <div class="p-value">{{ ($record->patient->sexe ?? '') == 'M' ? 'Masculin' : 'Féminin' }}</div>
                        </td>
                        <td>
                            <div class="p-label">Domicile</div>
                            <div class="p-value">{{ $record->patient->domicile ?? '—' }}</div>
                        </td>
                    </tr>
                    <tr class="patient-row2">
                        <td>
                            <div class="p-label">Prescripteur</div>
                            <div class="p-value">{{ $record->prescripteur->nom ?? 'Non renseigné' }}</div>
                        </td>
                        <td>
                            <div class="p-label">Référence</div>
                            <div class="p-value">{{ $record->ref }}</div>
                        </td>
                        <td>
                            <div class="p-label">Date de prélèvement</div>
                            <div class="p-value">{{ $record->created_at->format('d/m/Y') }}</div>
                        </td>
                        <td>
                            <div class="p-label">N° patient</div>
                            <div class="p-value">{{ $record->patient->id }}</div>
                        </td>
                    </tr>
                </table>
            </div>
        </td>
        <td style="width:24%; text-align:right; vertical-align:top; padding-left:10px;">
            <img src="data:image/png;base64,{{ $qrcode }}" alt="QR Code" style="width:80px; height:80px; margin-top:4px;">
        </td>
    </tr>
</table>

@php
    $getStatus = function($element, $age, $sexe, &$refMin, &$refMax) {
        $refMin = 0; $refMax = 0;

        // Éléments qualitatifs : pas de bornes numériques
        if ($element->type_valeur === 'qualitatif') {
            $val = strtolower(trim($element->pivot->resultat ?? ''));
            return in_array($val, ['négatif', 'negatif', '', '-']) ? 'qual_neg' : 'qual_pos';
        }

        $value = floatval($element->pivot->resultat ?? 0);
        $age   = intval($age);
        if ($age < 1)        { $refMin = floatval($element->ref_inf_nne  ?? 0); $refMax = floatval($element->ref_sup_nne  ?? 0); }
        elseif ($age < 5)    { $refMin = floatval($element->ref_inf_nour ?? 0); $refMax = floatval($element->ref_sup_nour ?? 0); }
        elseif ($age < 16)   { $refMin = floatval($element->ref_inf_enf  ?? 0); $refMax = floatval($element->ref_sup_enf  ?? 0); }
        elseif ($sexe === 'F'){ $refMin = floatval($element->ref_inf_f   ?? 0); $refMax = floatval($element->ref_sup_f   ?? 0); }
        else                  { $refMin = floatval($element->ref_inf_h   ?? 0); $refMax = floatval($element->ref_sup_h   ?? 0); }
        if ($refMin == 0 && $refMax == 0) return 'none';
        if ($value < $refMin) return 'low';
        if ($value > $refMax) return 'high';
        return 'normal';
    };

    $categories = [];
    foreach ($record->elements as $element) {
        $catName = $element->category->name ?? 'Sans catégorie';
        $categories[$catName][] = $element;
    }
@endphp

@foreach ($categories as $categoryName => $elements)
    <div class="section-hd">
        @if($categoryName === 'BetaHCG')
            &beta;HCG — Hormone Chorionique Gonadotrope
            @foreach($elements as $el)
                @php $v = floatval($el->pivot->resultat ?? 0); @endphp
                @if($el->nom === 'BetaHCG') &mdash; @if($v < 2) Négatif @else Positif @endif @endif
            @endforeach
        @else
            {{ $categoryName }}
        @endif
    </div>

    <table class="rt">
        <thead>
            <tr>
                <th class="c-name">Analyse</th>
                <th class="c-val">Résultat</th>
                <th class="c-unit">Unité</th>
                <th class="c-ref">Valeurs de référence</th>
                <th class="c-stat">État</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($elements as $element)
            @php
                $refMin = 0; $refMax = 0;
                $status  = $getStatus($element, $record->patient->age, $record->patient->sexe, $refMin, $refMax);
                $resultat = $element->pivot->resultat ?? '';
            @endphp
            @if($element->nom !== 'BetaHCG' && $resultat !== '' && $resultat !== '0')
            <tr>
                <td class="c-name">{{ $element->nom }}</td>
                <td class="c-val @if($status==='high' || $status==='qual_pos') v-hi @elseif($status==='low') v-lo @elseif($status==='normal' || $status==='qual_neg') v-ok @endif">
                    {{ $resultat }}
                </td>
                <td class="c-unit">{{ $element->unite }}</td>
                <td class="c-ref">
                    @if($element->type_valeur === 'qualitatif')
                        <span style="font-size:8px; color:#888; font-style:italic;">Qualitatif</span>
                    @elseif($refMin != 0 || $refMax != 0)
                        {{ $refMin }} &ndash; {{ $refMax }}
                    @else &mdash; @endif
                </td>
                <td class="c-stat">
                    @if($status === 'qual_pos')     <span class="s-hi" style="font-size:7.5px; font-weight:bold;">POS</span>
                    @elseif($status === 'qual_neg')  <span class="s-ok" style="font-size:7.5px; font-weight:bold;">NÉG</span>
                    @elseif($status === 'high')      <span class="s-hi">&#9650;</span>
                    @elseif($status === 'low')       <span class="s-lo">&#9660;</span>
                    @elseif($status === 'normal')    <span class="s-ok">&#9679;</span>
                    @else <span class="s-na">&mdash;</span>
                    @endif
                </td>
            </tr>
            @endif
        @endforeach
        </tbody>
    </table>
@endforeach

{{-- PIED DE PAGE --}}
<div class="rule"></div>
<table class="footer-table">
    <tr>
        <td style="width:55%;">
            <span style="font-size:7.5px; color:#888; font-style:italic;">
                &#9679; Normal &nbsp;&nbsp; &#9650; Au-dessus des valeurs de référence &nbsp;&nbsp; &#9660; En dessous des valeurs de référence
            </span>
        </td>
        <td style="width:45%; text-align:right;">
            <div class="sig-label">Responsable du Laboratoire</div>
            <img src="{{ public_path('img/signature.png') }}" alt="Signature" style="width:100px; height:auto; display:block; margin-left:auto; margin-top:4px;">
            <div class="sig-name">Mme Rahamatou SILAI</div>
            <div class="sig-title">Parasitologue / MSc Biochimie</div>
        </td>
    </tr>
</table>

</body>
</html>
