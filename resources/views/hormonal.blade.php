<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bilan Hormonal — MSLCP</title>
    <style>
        @page { margin: 12mm 10mm 14mm 10mm; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #1a1a2e;
            background: #fff;
            margin: 0; padding: 0;
        }

        /* ── FILIGRANE ─────────────────────────────────────── */
        .watermark {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            text-align: center;
            padding-top: 260px;
            z-index: -1000;
        }
        .watermark span {
            font-size: 160px; font-weight: bold;
            color: #eaeff7; display: inline-block;
            transform: rotate(-35deg); letter-spacing: 30px;
        }

        /* ── EN-TÊTE ─────────────────────────────────────── */
        .header-table {
            width: 100%; border-collapse: collapse;
            border-top: 3px solid #1B3A6B;
            border-bottom: 2px solid #1B3A6B; margin-bottom: 0;
        }
        .h-logo {
            width: 72px; text-align: center;
            padding: 8px 6px; border-right: 1px solid #d0d8e8;
            vertical-align: middle;
        }
        .h-logo img { width: 54px; height: auto; }
        .h-info { padding: 8px 14px; vertical-align: middle; }
        .h-name {
            font-size: 10.5px; font-weight: bold;
            text-transform: uppercase; letter-spacing: 0.5px; line-height: 1.5;
        }
        .h-lab {
            font-size: 9px; font-weight: bold; letter-spacing: 0.3px;
            margin: 3px 0 4px; border-bottom: 1px dotted #aab;
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

        /* ── BANDE TITRE ─────────────────────────────────── */
        .doc-title-bar {
            background-color: #1B3A6B; color: #fff;
            text-align: center; padding: 5px 0;
            font-size: 10px; font-weight: bold;
            letter-spacing: 2.5px; text-transform: uppercase;
            margin-bottom: 10px;
        }

        /* ── BLOC PATIENT ────────────────────────────────── */
        .patient-outer { border: 1px solid #1B3A6B; margin-bottom: 12px; }
        .patient-bar {
            background-color: #1B3A6B; color: #fff;
            padding: 3px 8px; font-size: 7.5px;
            font-weight: bold; letter-spacing: 1.5px; text-transform: uppercase;
        }
        .patient-grid { width: 100%; border-collapse: collapse; }
        .patient-grid td { padding: 4px 8px; font-size: 9px; vertical-align: top; }
        .p-label {
            font-size: 7.5px; color: #6B7A99;
            text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 1px;
        }
        .p-value { font-weight: bold; font-size: 10px; color: #1a1a2e; }
        .patient-row2 td { border-top: 1px solid #e0e6f0; }

        /* ── EN-TÊTE DE SECTION ──────────────────────────── */
        .section-hd {
            background-color: #1B3A6B; color: #fff;
            padding: 5px 10px; font-size: 8.5px; font-weight: bold;
            letter-spacing: 1px; text-transform: uppercase;
        }

        /* ── TABLEAU DE RÉSULTATS ────────────────────────── */
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

        .v-ok  { color: #1a7f37; }
        .v-hi  { color: #c0392b; }
        .v-lo  { color: #d35400; }
        .s-ok  { color: #1a7f37; font-size: 12px; font-weight: bold; }
        .s-hi  { color: #c0392b; font-size: 11px; font-weight: bold; }
        .s-lo  { color: #d35400; font-size: 11px; font-weight: bold; }
        .s-na  { color: #bbb; }

        /* ── TABLE β-HCG SPÉCIALE ────────────────────────── */
        .hcg-result {
            border: 1px solid #d8e0ed; padding: 8px 10px;
            margin-bottom: 4px; font-size: 10px;
        }
        .hcg-val { font-weight: bold; font-size: 13px; color: #1B3A6B; }
        .hcg-vn { font-size: 8px; color: #888; font-style: italic; }

        .sa-table {
            width: 100%; border-collapse: collapse;
            font-size: 9px; margin-top: 8px;
        }
        .sa-table td {
            border: 1px solid #d8e0ed;
            padding: 3px 6px; vertical-align: middle;
        }
        .sa-table tr:nth-child(even) td { background-color: #f6f8fd; }
        .sa-title {
            font-size: 7.5px; font-weight: bold;
            text-transform: uppercase; letter-spacing: 0.8px;
            color: #1B3A6B; background-color: #edf1fb;
            padding: 4px 6px; border: 1px solid #c8d3ea;
        }
        .sa-week { width: 12%; font-weight: bold; }
        .sa-val  { width: 26%; font-style: italic; color: #666; font-size: 8.5px; }

        /* ── PIED DE PAGE ────────────────────────────────── */
        .rule { border-top: 1px solid #c8d3ea; margin: 10px 0 6px; }
        .footer-table { width: 100%; border-collapse: collapse; }
        .footer-table td { padding: 3px 4px; font-size: 8.5px; vertical-align: bottom; }
        .sig-label { font-size: 7.5px; text-transform: uppercase; letter-spacing: 0.8px; color: #888; }
        .sig-name  { font-weight: bold; font-size: 10px; color: #1B3A6B; }
        .sig-title { font-size: 8px; font-style: italic; color: #666; }
    </style>
</head>
<body>

<div class="watermark"><span>MSLCP</span></div>

{{-- EN-TÊTE --}}
<table class="header-table">
    <tr>
        <td class="h-logo">
            @if(file_exists(public_path('img/logo.png')))
            <img src="{{ public_path('img/logo.png') }}" alt="Logo MSLCP">
            @endif
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
            <div class="h-badge-title">Bilan<br>Hormonal</div>
        </td>
    </tr>
</table>

<div class="doc-title-bar">BILAN HORMONAL</div>

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
        $value = floatval($element->pivot->resultat ?? 0);
        $age = intval($age);
        if ($age < 1)        { $refMin = floatval($element->ref_inf_nne  ?? 0); $refMax = floatval($element->ref_sup_nne  ?? 0); }
        elseif ($age < 5)    { $refMin = floatval($element->ref_inf_nour ?? 0); $refMax = floatval($element->ref_sup_nour ?? 0); }
        elseif ($age < 16)   { $refMin = floatval($element->ref_inf_enf  ?? 0); $refMax = floatval($element->ref_sup_enf  ?? 0); }
        elseif ($sexe == 'F') { $refMin = floatval($element->ref_inf_f   ?? 0); $refMax = floatval($element->ref_sup_f   ?? 0); }
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

    $isFemale = ($record->patient->sexe ?? '') === 'F';
@endphp

@foreach ($categories as $categoryName => $elements)

    {{-- ── β-HCG : section spéciale ──────────────────────── --}}
    @if($categoryName === 'BetaHCG')
        @foreach($elements as $element)
            @if($element->nom === 'BetaHCG')
                @php $hcgVal = $element->pivot->resultat ?? ''; $hcgFloat = floatval($hcgVal); @endphp
                <div class="section-hd">&#946;HCG &mdash; Hormone Chorionique Gonadotrope
                    @if($hcgVal !== '') &mdash; @if($hcgFloat < 2) <span style="color:#90EE90;">Négatif</span> @else <span style="color:#FFAAAA;">Positif</span> @endif @endif
                </div>
                <table class="rt">
                    <thead>
                        <tr>
                            <th class="c-name">Analyse</th>
                            <th class="c-val">Résultat</th>
                            <th class="c-unit">Unité</th>
                            <th class="c-ref">Valeur normale</th>
                            <th class="c-stat">État</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="c-name">&#946;HCG</td>
                            <td class="c-val @if($hcgFloat >= 2) v-hi @else v-ok @endif">{{ $hcgVal }}</td>
                            <td class="c-unit">mIU/ml</td>
                            <td class="c-ref">&lt; 2 mIU/ml</td>
                            <td class="c-stat">
                                @if($hcgFloat >= 2) <span class="s-hi">&#9650;</span>
                                @else <span class="s-ok">&#9679;</span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                @if($isFemale && $hcgFloat >= 2)
                    <div style="font-size:8px; font-weight:bold; text-transform:uppercase; letter-spacing:0.8px; color:#1B3A6B; margin-bottom:4px; padding-left:4px;">
                        Valeurs de référence par semaine d'aménorrhée
                    </div>
                    <table class="sa-table" style="margin-bottom:10px;">
                        <tr>
                            <td class="sa-title">SA</td>
                            <td class="sa-title">Plage de référence (mIU/ml)</td>
                            <td class="sa-title">SA</td>
                            <td class="sa-title">Plage de référence (mIU/ml)</td>
                        </tr>
                        <tr>
                            <td class="sa-week">S3</td><td class="sa-val">5,8 &ndash; 71,2</td>
                            <td class="sa-week">S12</td><td class="sa-val">27 832 &ndash; 186 977</td>
                        </tr>
                        <tr>
                            <td class="sa-week">S5</td><td class="sa-val">217 &ndash; 7 158</td>
                            <td class="sa-week">S14</td><td class="sa-val">13 950 &ndash; 62 530</td>
                        </tr>
                        <tr>
                            <td class="sa-week">S6</td><td class="sa-val">158 &ndash; 31 795</td>
                            <td class="sa-week">S15</td><td class="sa-val">12 030 &ndash; 70 971</td>
                        </tr>
                        <tr>
                            <td class="sa-week">S7</td><td class="sa-val">3 697 &ndash; 163 563</td>
                            <td class="sa-week">S16</td><td class="sa-val">9 040 &ndash; 56 451</td>
                        </tr>
                        <tr>
                            <td class="sa-week">S8</td><td class="sa-val">32 065 &ndash; 149 571</td>
                            <td class="sa-week">S17</td><td class="sa-val">8 175 &ndash; 55 868</td>
                        </tr>
                        <tr>
                            <td class="sa-week">S9</td><td class="sa-val">63 803 &ndash; 151 410</td>
                            <td class="sa-week">S18</td><td class="sa-val">8 099 &ndash; 58 176</td>
                        </tr>
                        <tr>
                            <td class="sa-week">S10</td><td class="sa-val">46 509 &ndash; 186 977</td>
                            <td colspan="2"></td>
                        </tr>
                    </table>
                @endif
            @endif
        @endforeach

    {{-- ── Toutes les autres catégories : tableau standard ── --}}
    @else
        <div class="section-hd">
            @if($categoryName === 'HBA1c')      Hémoglobine Glyquée (HbA1c)
            @elseif($categoryName === 'BILAN THYROÏDIEN') Bilan Thyroïdien
            @elseif($categoryName === 'BILAN PROSTATIQUE') Bilan Prostatique (PSA)
            @elseif($categoryName === 'ŒSTRADIOL') Œstradiol (E2)
            @elseif($categoryName === 'PRL')    Prolactine (PRL)
            @else {{ $categoryName }}
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
                    $status   = $getStatus($element, $record->patient->age, $record->patient->sexe, $refMin, $refMax);
                    $resultat = $element->pivot->resultat ?? '';
                @endphp
                @if($resultat !== '' && $resultat !== '0')
                <tr>
                    <td class="c-name">{{ $element->nom }}</td>
                    <td class="c-val @if($status==='high') v-hi @elseif($status==='low') v-lo @elseif($status==='normal') v-ok @endif">
                        {{ $resultat }}
                    </td>
                    <td class="c-unit">{{ $element->unite }}</td>
                    <td class="c-ref">
                        @if($refMin != 0 || $refMax != 0)
                            {{ $refMin }} &ndash; {{ $refMax }}
                        @elseif($categoryName === 'BILAN PROSTATIQUE') &lt; 4 ng/ml
                        @elseif($categoryName === 'HBA1c') &lt; 6,5 %
                        @elseif($categoryName === 'Troponine') &lt; 0,3 ng/l
                        @else &mdash;
                        @endif
                    </td>
                    <td class="c-stat">
                        @if($status === 'high')    <span class="s-hi">&#9650;</span>
                        @elseif($status === 'low') <span class="s-lo">&#9660;</span>
                        @elseif($status === 'normal') <span class="s-ok">&#9679;</span>
                        @else <span class="s-na">&mdash;</span>
                        @endif
                    </td>
                </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    @endif

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
            @if(file_exists(public_path('img/signature.png')))
            <img src="{{ public_path('img/signature.png') }}" alt="Signature" style="width:100px; height:auto; display:block; margin-left:auto; margin-top:4px;">
            @endif
            <div class="sig-name">Mme Rahamatou SILAI</div>
            <div class="sig-title">Parasitologue / MSc Biochimie</div>
        </td>
    </tr>
</table>

</body>
</html>
