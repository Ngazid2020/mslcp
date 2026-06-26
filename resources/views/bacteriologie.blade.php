<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ECBU — {{ $record->patient->nom ?? 'Patient' }}</title>
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
        .section-hd-sub {
            background-color: #2e5f9e; color: #fff;
            padding: 4px 10px; font-size: 8px; font-weight: bold;
            letter-spacing: 0.8px; text-transform: uppercase;
        }

        /* ── TABLEAU BIOCHIMIE ───────────────────────────── */
        .bc-table {
            width: 100%; border-collapse: collapse; margin-bottom: 12px;
        }
        .bc-table td {
            border: 1px solid #d8e0ed; padding: 4px 8px;
            vertical-align: middle; font-size: 9.5px;
        }
        .bc-table tr:nth-child(even) td { background-color: #f6f8fd; }
        .bc-label {
            width: 25%; background-color: #edf1fb;
            font-size: 8px; text-transform: uppercase;
            letter-spacing: 0.4px; color: #1B3A6B; font-weight: bold;
        }
        .bc-val { width: 25%; text-align: center; font-weight: bold; }

        /* ── TABLEAU ECBU ────────────────────────────────── */
        .ecbu-table {
            width: 100%; border-collapse: collapse; margin-bottom: 12px;
        }
        .ecbu-table td {
            border: 1px solid #d8e0ed; padding: 4px 8px;
            vertical-align: middle; font-size: 9.5px;
        }
        .ecbu-table tr:nth-child(even) td { background-color: #f6f8fd; }
        .ecbu-label {
            width: 40%; background-color: #edf1fb;
            font-size: 8px; text-transform: uppercase;
            letter-spacing: 0.4px; color: #1B3A6B; font-weight: bold;
        }
        .ecbu-val { width: 60%; font-weight: bold; min-height: 18px; }
        .ecbu-val-lg { width: 60%; min-height: 36px; font-weight: bold; }

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
            <div class="h-badge-title">Examen<br>Urinaire<br>ECBU</div>
        </td>
    </tr>
</table>

<div class="doc-title-bar">EXAMEN CYTOBACTÉRIOLOGIQUE DES URINES (ECBU)</div>

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
                            <div class="p-label">Tél</div>
                            <div class="p-value">{{ $record->patient->tel ?? '—' }}</div>
                        </td>
                    </tr>
                    <tr class="patient-row2">
                        <td>
                            <div class="p-label">Prescripteur</div>
                            <div class="p-value">{{ $record->prescripteur->nom ?? 'Non renseigné' }}</div>
                        </td>
                        <td>
                            <div class="p-label">Référence</div>
                            <div class="p-value">{{ $record->id }}</div>
                        </td>
                        <td>
                            <div class="p-label">Domicile</div>
                            <div class="p-value">{{ $record->patient->domicile ?? '—' }}</div>
                        </td>
                        <td>
                            <div class="p-label">Date</div>
                            <div class="p-value">{{ $record->created_at->format('d/m/Y') }}</div>
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

{{-- BIOCHIMIE URINAIRE --}}
<div class="section-hd">Biochimie Urinaire</div>
<table class="bc-table">
    <tr>
        <td class="bc-label">Urobilinogène</td>
        <td class="bc-val">{{ $record->urobilinogene ?? '' }} @if($record->urobilinogene) mg/L @endif</td>
        <td class="bc-label">pH</td>
        <td class="bc-val">{{ $record->ph ?? '' }}</td>
    </tr>
    <tr>
        <td class="bc-label">Albumine</td>
        <td class="bc-val">{{ $record->albumine ?? '' }}</td>
        <td class="bc-label">Bilirubine</td>
        <td class="bc-val">{{ $record->bilirubine ?? '' }}</td>
    </tr>
    <tr>
        <td class="bc-label">Sucre (Glucose)</td>
        <td class="bc-val">{{ $record->sucre ?? '' }}</td>
        <td class="bc-label">Densité</td>
        <td class="bc-val">{{ $record->densite ?? '' }}</td>
    </tr>
    <tr>
        <td class="bc-label">Acétone</td>
        <td class="bc-val">{{ $record->acetone ?? '' }}</td>
        <td class="bc-label">Sang</td>
        <td class="bc-val">{{ $record->sang ?? '' }}</td>
    </tr>
    <tr>
        <td class="bc-label">Nitrite</td>
        <td class="bc-val">{{ $record->nitrite ?? '' }}</td>
        <td class="bc-label">Leucocytes</td>
        <td class="bc-val">{{ $record->leucocytes ?? '' }}</td>
    </tr>
</table>

{{-- EXAMEN MACROSCOPIQUE --}}
<div class="section-hd">Examen Macroscopique</div>
<table class="ecbu-table">
    <tr>
        <td class="ecbu-label">Aspect des urines</td>
        <td class="ecbu-val">{{ $record->aspect_urines ?? '' }}</td>
    </tr>
</table>

{{-- EXAMEN MICROSCOPIQUE --}}
<div class="section-hd">Examen Microscopique</div>
<table class="ecbu-table">
    <tr>
        <td class="ecbu-label">Cellules épithéliales</td>
        <td class="ecbu-val">{{ $record->cellules_epitheliales ?? '' }}</td>
    </tr>
    <tr>
        <td class="ecbu-label">Leucocytes</td>
        <td class="ecbu-val">{{ $record->leucocytes_micro ?? '' }}</td>
    </tr>
    <tr>
        <td class="ecbu-label">Hématies</td>
        <td class="ecbu-val">{{ $record->hematies ?? '' }}</td>
    </tr>
    <tr>
        <td class="ecbu-label">Parasites</td>
        <td class="ecbu-val">{{ $record->parasites ?? '' }}</td>
    </tr>
    <tr>
        <td class="ecbu-label">Éléments fongiques</td>
        <td class="ecbu-val">{{ $record->elements_fongiques ?? '' }}</td>
    </tr>
    <tr>
        <td class="ecbu-label">Bactéries</td>
        <td class="ecbu-val">{{ $record->bacteries ?? '' }}</td>
    </tr>
    <tr>
        <td class="ecbu-label">Cristaux</td>
        <td class="ecbu-val">{{ $record->cristaux ?? '' }}</td>
    </tr>
    <tr>
        <td class="ecbu-label">Coloration de Gram</td>
        <td class="ecbu-val-lg">{{ $record->coloration_gram ?? '' }}</td>
    </tr>
    <tr>
        <td class="ecbu-label">Culture</td>
        <td class="ecbu-val-lg">{{ $record->culture ?? '' }}</td>
    </tr>
    <tr>
        <td class="ecbu-label">Conclusion</td>
        <td class="ecbu-val-lg">{{ $record->conclusion ?? '' }}</td>
    </tr>
</table>

{{-- PIED DE PAGE --}}
<div class="rule"></div>
<table class="footer-table">
    <tr>
        <td style="width:55%; font-size:8px; color:#888; font-style:italic; vertical-align:bottom;">
            Les résultats de cet examen ne sont valables que pour l'échantillon analysé.<br>
            Pour toute question, contacter le laboratoire.
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
