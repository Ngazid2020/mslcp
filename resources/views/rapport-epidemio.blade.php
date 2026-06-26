<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Épidémiologique — MSLCP</title>
    <style>
        @page { margin: 12mm 10mm 14mm 10mm; }
        * { box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #1a1a2e;
            background: #fff;
            margin: 0; padding: 0;
        }

        /* ── FILIGRANE ────────────────────────────────── */
        .watermark {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            text-align: center;
            padding-top: 220px;
            z-index: -1000;
        }
        .watermark span {
            font-size: 120px; font-weight: bold;
            color: #eaeff7; display: inline-block;
            transform: rotate(-35deg); letter-spacing: 20px;
        }

        /* ── EN-TÊTE ──────────────────────────────────── */
        .header-table {
            width: 100%; border-collapse: collapse;
            border-top: 3px solid #1B3A6B;
            border-bottom: 2px solid #1B3A6B;
            margin-bottom: 0;
        }
        .h-logo { width: 72px; text-align: center; padding: 8px 6px; border-right: 1px solid #d0d8e8; vertical-align: middle; }
        .h-logo img { width: 54px; height: auto; }
        .h-info { padding: 8px 14px; vertical-align: middle; }
        .h-name { font-size: 10.5px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; line-height: 1.5; }
        .h-lab  { font-size: 9px; font-weight: bold; letter-spacing: 0.3px; margin: 3px 0 4px; color: #1B3A6B; }
        .h-addr { font-size: 8.5px; color: #5a6a7e; line-height: 1.6; }
        .h-badge {
            width: 120px; text-align: center; padding: 8px 10px;
            border-left: 1px solid #d0d8e8; vertical-align: middle;
        }
        .h-badge-label { font-size: 7px; text-transform: uppercase; letter-spacing: 1px; color: #8897a8; margin-bottom: 3px; }
        .h-badge-val {
            display: inline-block; background: #1B3A6B; color: #fff;
            font-size: 9px; font-weight: bold; padding: 4px 8px;
            border-radius: 3px; letter-spacing: 0.5px;
        }

        /* ── TITRE RAPPORT ────────────────────────────── */
        .rapport-title {
            background: #1B3A6B; color: #fff;
            font-size: 13px; font-weight: bold;
            text-align: center; padding: 7px 0;
            letter-spacing: 1px; text-transform: uppercase;
            margin-top: 0;
        }
        .rapport-subtitle {
            text-align: center; font-size: 10px; color: #4a5568;
            padding: 5px 0 8px; border-bottom: 1px solid #d0d8e8;
        }

        /* ── SYNTHÈSE KPI ─────────────────────────────── */
        .kpi-table {
            width: 100%; border-collapse: collapse;
            margin: 10px 0;
        }
        .kpi-cell {
            width: 33%; text-align: center;
            border: 1px solid #d0d8e8;
            padding: 8px 4px;
            background: #f8fafc;
        }
        .kpi-value { font-size: 22px; font-weight: bold; color: #1B3A6B; }
        .kpi-label { font-size: 8px; color: #6b7280; margin-top: 2px; }

        /* ── TABLEAU MENSUEL ──────────────────────────── */
        .section-title {
            font-size: 10px; font-weight: bold; color: #1B3A6B;
            text-transform: uppercase; letter-spacing: 0.5px;
            border-bottom: 2px solid #1B3A6B;
            padding-bottom: 3px; margin: 12px 0 6px;
        }
        .data-table {
            width: 100%; border-collapse: collapse; font-size: 9.5px;
        }
        .data-table th {
            background: #1B3A6B; color: #fff;
            padding: 5px 8px; text-align: center;
            font-size: 9px; letter-spacing: 0.3px;
        }
        .data-table th:first-child { text-align: left; }
        .data-table td {
            padding: 4px 8px; border-bottom: 1px solid #e8edf2;
            text-align: center; vertical-align: middle;
        }
        .data-table td:first-child { text-align: left; font-weight: 500; }
        .data-table tr:nth-child(even) td { background: #f8fafc; }
        .data-table tr.total-row td {
            background: #e8edf2 !important; font-weight: bold;
            border-top: 2px solid #1B3A6B;
        }
        .cas-val { font-weight: bold; color: #1B3A6B; }
        .zero-val { color: #aab4bf; }
        .pct-high { color: #c0392b; font-weight: bold; }

        /* Barre de progression (DOMPDF: largeur inline via style) */
        .bar-wrap { width: 100%; background: #e8edf2; height: 8px; border-radius: 2px; overflow: hidden; }
        .bar-fill  { height: 8px; background: #1B3A6B; border-radius: 2px; }

        /* ── PIED DE PAGE ─────────────────────────────── */
        .footer {
            position: fixed; bottom: 0; left: 0; right: 0;
            border-top: 1px solid #d0d8e8;
            padding-top: 4px; font-size: 8px; color: #8897a8;
        }
        .footer-table { width: 100%; }
    </style>
</head>
<body>

<div class="watermark"><span>MSLCP</span></div>

{{-- ── En-tête ──────────────────────────────────────────────────────────── --}}
<table class="header-table">
    <tr>
        <td class="h-logo">
            <img src="{{ public_path('img/logo.png') }}" alt="MSLCP">
        </td>
        <td class="h-info">
            <div class="h-name">{{ $contact['nom'] ?? 'MSLCP' }}</div>
            <div class="h-lab">Laboratoire d'Analyse Médicale</div>
            <div class="h-addr">
                {{ $contact['adresse'] ?? '' }}<br>
                Tél : {{ $contact['tel'] ?? '' }} &nbsp;|&nbsp; {{ $contact['email'] ?? '' }}
            </div>
        </td>
        <td class="h-badge">
            <div class="h-badge-label">Type de document</div>
            <div class="h-badge-val">ÉPIDÉMIOLOGIE</div>
        </td>
    </tr>
</table>

{{-- ── Titre ────────────────────────────────────────────────────────────── --}}
<div class="rapport-title">Rapport Épidémiologique</div>
<div class="rapport-subtitle">
    Année <strong>{{ $annee }}</strong> &mdash;
    Pathologie : <strong>{{ $maladie ? $maladie->nom : 'Toutes les maladies' }}</strong>
    &mdash; Généré le {{ \Carbon\Carbon::now()->format('d/m/Y') }}
</div>

{{-- ── KPIs ─────────────────────────────────────────────────────────────── --}}
@php
    $total   = $monthly['total'];
    $meta    = $monthly['_meta'];
    $maxCas  = $meta['max_cas'];
@endphp

<table class="kpi-table">
    <tr>
        <td class="kpi-cell">
            <div class="kpi-value">{{ $total['cas'] }}</div>
            <div class="kpi-label">CAS DÉTECTÉS</div>
        </td>
        <td class="kpi-cell">
            <div class="kpi-value">{{ $meta['peak_mois'] }}</div>
            <div class="kpi-label">PIC ÉPIDÉMIQUE ({{ $meta['max_cas'] }} cas)</div>
        </td>
        <td class="kpi-cell">
            <div class="kpi-value">{{ $total['pct'] }}%</div>
            <div class="kpi-label">DES BILANS CONCERNÉS</div>
        </td>
    </tr>
</table>

{{-- ── Tableau mensuel ──────────────────────────────────────────────────── --}}
<div class="section-title">Évolution mensuelle</div>
<table class="data-table">
    <thead>
        <tr>
            <th style="width:15%">Mois</th>
            <th style="width:12%">Cas</th>
            <th style="width:14%">Bilans</th>
            <th style="width:10%">%</th>
            <th>Distribution</th>
        </tr>
    </thead>
    <tbody>
        @for($m = 1; $m <= 12; $m++)
            @php $row = $monthly[$m]; @endphp
            <tr>
                <td>{{ $row['mois'] }}</td>
                <td class="{{ $row['cas'] > 0 ? 'cas-val' : 'zero-val' }}">{{ $row['cas'] }}</td>
                <td>{{ $row['total_bilans'] }}</td>
                <td class="{{ $row['pct'] > 25 ? 'pct-high' : '' }}">
                    {{ $row['pct'] > 0 ? $row['pct'].'%' : '—' }}
                </td>
                <td style="padding: 4px 8px;">
                    @if($row['cas'] > 0 && $maxCas > 0)
                        @php $w = round($row['cas'] / $maxCas * 100); @endphp
                        <div class="bar-wrap">
                            <div class="bar-fill" style="width:{{ $w }}%"></div>
                        </div>
                    @endif
                </td>
            </tr>
        @endfor
    </tbody>
    <tfoot>
        <tr class="total-row">
            <td>Total {{ $annee }}</td>
            <td class="cas-val">{{ $total['cas'] }}</td>
            <td>{{ $total['total_bilans'] }}</td>
            <td class="{{ $total['pct'] > 25 ? 'pct-high' : '' }}">
                {{ $total['total_bilans'] > 0 ? $total['pct'].'%' : '—' }}
            </td>
            <td></td>
        </tr>
    </tfoot>
</table>

{{-- ── Pied de page ────────────────────────────────────────────────────── --}}
<div class="footer">
    <table class="footer-table">
        <tr>
            <td>{{ $contact['nom'] ?? 'MSLCP' }} &mdash; Rapport confidentiel</td>
            <td style="text-align:right">Page <span class="pagenum"></span></td>
        </tr>
    </table>
</div>

</body>
</html>
