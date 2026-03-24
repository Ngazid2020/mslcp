<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Bulletin d'Analyse Hormonale</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #000;
            background: #fff;
            padding: 20px 32px;
        }

        /* WATERMARK */
        .watermark {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            text-align: center;
            padding-top: 300px;
            z-index: -1000;
        }

        .watermark span {
            font-family: DejaVu Sans, sans-serif;
            font-size: 180px;
            font-weight: bold;
            color: #e8e8e8;
            display: inline-block;
            transform: rotate(-40deg);
            letter-spacing: 40px;
        }

        /* ── HEADER ─────────────────────────────────────────── */

        /* Filets de séparation */
        .rule-thick {
            width: 100%;
            border-top: 2px solid #000;
            margin-bottom: 0;
        }

        .rule-thin {
            width: 100%;
            border-top: 1px solid #000;
            margin-bottom: 0;
        }

        .rule-double {
            width: 100%;
            border-top: 3px double #000;
            margin-bottom: 10px;
        }

        /* Tableau principal de l'en-tête :
           [Logo] | [séparateur vertical] | [Infos clinique] | [Badge document] */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-top: 2px solid #000;
            border-bottom: 1px solid #000;
            margin-bottom: 0;
        }

        .header-logo-cell {
            width: 82px;
            vertical-align: middle;
            text-align: center;
            padding: 10px 10px 10px 6px;
            border-right: 1px solid #ccc;
        }

        .header-logo-cell img {
            width: 66px;
            height: auto;
        }

        .header-info-cell {
            vertical-align: middle;
            padding: 10px 16px;
        }

        /* Nom de la clinique : gras, majuscules, hiérarchie forte */
        .clinic-name {
            font-size: 11.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            line-height: 1.5;
            margin-bottom: 2px;
        }

        /* Sous-titre laboratoire */
        .lab-name {
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 0.2px;
            margin-bottom: 5px;
            border-bottom: 1px dotted #999;
            padding-bottom: 4px;
            display: inline-block;
        }

        /* Ligne de contact : petite, espacée, lisible */
        .header-contact {
            font-size: 8.5px;
            line-height: 1.9;
            margin-top: 2px;
        }

        /* Badge document (colonne droite) */
        .header-badge-cell {
            width: 110px;
            vertical-align: middle;
            text-align: center;
            padding: 10px 8px;
            border-left: 1px solid #ccc;
        }

        .badge-type {
            font-size: 7.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border: 1px solid #000;
            padding: 3px 6px 3px 6px;
            display: inline-block;
            margin-bottom: 4px;
        }

        .badge-title {
            font-size: 9.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.5;
        }

        /* Séparateur double sous le header */
        .header-sep {
            width: 100%;
            border-top: 3px double #000;
            margin-bottom: 10px;
        }

        /* ── TITRE DU DOCUMENT ──────────────────────────────── */
        .doc-title-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }

        .doc-title-cell {
            text-align: center;
            padding: 6px 0;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .doc-title {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        /* PATIENT FIELDS */
        .patient-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        .patient-table td {
            padding: 3px 6px;
            font-size: 10px;
        }

        .patient-label {
            font-weight: bold;
            white-space: nowrap;
            width: 1%;
        }

        /*.patient-value { border-bottom: 1px solid #000; min-width:80px; }*/

        /* MAIN TABLE */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
            margin-bottom: 14px;
        }

        .main-table td,
        .main-table th {
            border: 1px solid #000;
            padding: 5px 8px;
            vertical-align: top;
        }

        .section-header {
            font-weight: bold;
            font-size: 10.5px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            text-align: center;
            padding: 5px 8px;
            border-top: 2px solid #000;
        }

        .sub-header {
            font-weight: bold;
            font-size: 10px;
            text-align: center;
            letter-spacing: 0.5px;
            padding: 4px 8px;
            border-bottom: 2px solid #000;
        }

        /* INLINE UNDERLINES */
        .inline-dots {
            border-bottom: 1px dotted #555;
            min-width: 100px;
            display: inline-block;
            vertical-align: bottom;
            margin: 0 4px;
        }

        /* NORMAL VALUES */
        .vn {
            font-size: 8.5px;
            font-style: italic;
        }

        /* RESULT NAME */
        .result-name {
            font-weight: bold;
            font-size: 10px;
        }

        /* SUB-LISTS */
        .sub-list {
            list-style: none;
            padding-left: 10px;
            margin: 3px 0;
        }

        .sub-list li {
            margin-bottom: 3px;
            font-size: 9.5px;
            padding-left: 12px;
            position: relative;
        }

        .sub-list li:before {
            content: "—";
            position: absolute;
            left: 0;
            font-size: 9px;
        }

        /* HALF COLUMNS */
        .half-left {
            width: 50%;
            padding: 6px 9px;
            vertical-align: top;
        }

        .half-right {
            width: 50%;
            padding: 6px 9px;
            vertical-align: top;
        }

        /* FOOTER */
        .footer-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        .footer-table td {
            font-size: 10px;
            padding: 3px 4px;
            vertical-align: bottom;
        }

        .footer-right {
            text-align: right;
        }

        .footer-sig-label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .footer-sig-name {
            font-weight: bold;
            font-size: 10px;
        }

        .footer-sig-title {
            font-size: 8.5px;
            font-style: italic;
        }

        .sig-line {
            border-top: 1px solid #000;
            width: 140px;
            display: inline-block;
            margin-top: 24px;
        }

        /* UTILITIES */
        .bold {
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .italic {
            font-style: italic;
        }

        .small {
            font-size: 8.5px;
        }
    </style>
</head>

<body>

    {{-- WATERMARK --}}
    <div class="watermark"><span>MSLCP</span></div>

    {{-- ========== HEADER ========== --}}
    <table class="header-table">
        <tr>
            <td class="header-logo-cell">
                <img src="{{ public_path('img/logo.png') }}" alt="Logo">
            </td>
            <td class="header-info-cell">
                <div class="clinic-name">Maison de Surveillance et de Lutte contre le Paludisme (MSLCP)</div>
                <div class="lab-name">Laboratoire d'Analyses Médicales</div>
                <div class="header-contact">
                    Dirigée par <strong>Mme Rahamatou SILAI</strong> &nbsp;—&nbsp; Parasitologue / MSc Biochimie<br>
                    <strong>Tél :</strong> +269 333 03 75 &nbsp;/&nbsp; 473 50 95
                    &nbsp;&nbsp;|&nbsp;&nbsp;
                    <strong>Email :</strong> <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="c7aab4aba4b798b4aeaba6ae87bea6afa8a8e9a1b5">[email&#160;protected]</a>
                </div>
            </td>
            <td class="header-badge-cell">
                <div class="badge-type">Laboratoire</div>
                <div class="badge-title">Bulletin<br>d'Analyse<br>Hormonale</div>
            </td>
        </tr>
    </table>

    <div class="header-sep"></div>

    {{-- ========== PATIENT SUMMARY ========== --}}
    <table style="width:100%; border-collapse:collapse; margin-bottom:8px;">
        <tr>
            <td style="font-size:10px; padding:4px 6px; vertical-align:top; width:75%;">
                <!-- <span class="bold">Cabinet Médical Privé</span><br><br> -->
                <!-- <span class="bold">Patient :</span>&nbsp;{{ $record->patient->nom ?? '__' }} -->
                {{-- ========== PATIENT FIELDS ========== --}}
                <table class="patient-table">
                    <tr>
                        <td class="patient-label">Nom :</td>
                        <td class="patient-value">{{ $record->patient->nom ?? '' }}</td>
                        <td class="patient-label">Prénom :</td>
                        <td class="patient-value">{{ $record->patient->prenom ?? '' }}</td>
                        <td class="patient-label">Tél :</td>
                        <td class="patient-value">{{ $record->patient->phone ?? '' }}</td>
                        <td class="patient-label">Âge :</td>
                        <td class="patient-value">{{ $record->patient->age ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="patient-label">N° :</td>
                        <td class="patient-value">{{ $numero ?? '' }}</td>
                        <td class="patient-label">Domicile :</td>
                        <td class="patient-value">{{ $domicile ?? '' }}</td>
                        <td class="patient-label">Prescripteur :</td>
                        <td class="patient-value" colspan="3">{{ $prescripteur ?? '' }}</td>
                    </tr>
                </table>
            </td>
            <td style="text-align:right; vertical-align:top; padding:4px 6px; width:25%;">

                <img src="data:image/png;base64,{{ $qrcode }}" alt="QR Code" style="width: 90px; height: 90px;">
            </td>
        </tr>
    </table>



    @php
    $categories = [];
    foreach ($record->elements as $element) {
    $catName = $element->category->name ?? 'Sans catégorie';
    $categories[$catName][] = $element;
    }
    @endphp

    {{-- ========== MAIN TABLE ========== --}}
    <table class="main-table">

        {{-- ---- BILAN PROSTATIQUE ---- --}}
        @foreach($categories as $categoryName => $elements)
        @if($categoryName == 'BILAN PROSTATIQUE')
        <tr>
            <td colspan="4" class="section-header">{{ $categoryName }}</td>
        </tr>
        @foreach($elements as $element)
        <tr>
            <th>Analyse</th>
            <th>Résultat</th>
            <th>Unité</th>
            <th>Référence</th>
        </tr>

        <tr>
            <td>
                <span class="result-name">{{ $element->nom }}</span>
                <span style="margin-left:40px;"></span>
                <span class="vn"></span>
            </td>
            <td style="text-align: right">{{ $element->pivot->resultat ?? '' }}</td>
            <td>ng/ml</td>
            <td>VN : &lt; 4 ng/ml</td>
        </tr>
        @endforeach
        @endif
        @endforeach

        {{-- ---- BILAN THYROÏDIEN ---- --}}
        @foreach($categories as $categoryName => $elements)
        @if($categoryName == 'BILAN THYROÏDIEN')
        <tr>
            <td colspan="4" class="section-header">{{ $categoryName }}</td>
        </tr>
        @foreach($elements as $element)
        <tr>
            <td>
                <p style="margin-bottom:6px;">
                    <span class="result-name">{{ $element->nom }}</span>
                </p>
            </td>
            <td class="half-right" style="text-align: right">{{ $element->pivot->resultat ?? '' }}</td>
            <td class="half-right">{{$element->unite}}</td>
            <td class="half-right">ref</td>
        </tr>
        @endforeach
        @endif
        @endforeach

        {{-- ---- FSH / LH ---- --}}
        @foreach($categories as $categoryName => $elements)
        @if($categoryName == 'FSH')
        <tr>
            <td colspan="4" class="sub-header half-left">Hormone folliculostimulante <span class="small italic">(mIU/L)</span></td>
        </tr>
        @endif

        @foreach($elements as $element)
        @if($element->nom == 'FSH')
        <tr>
            <td>{{ $element->nom }}</td>
            <td style="text-align: right;">
                @if($record->patient->sexe == 'M')
                {{ $element->pivot->resultat ?? '' }}
                @endif

                @if($record->patient->sexe == 'F')

                <span style="text-align: right; font-weight:semi-bold;">{{ $element->pivot->resultat ?? '' }}</span>
            </td>
            <td>unite</td>
            <td>ref</td>
        </tr>
        <tr>
            <td colspan="4">
                <ul class="sub-list">
                    <li>P. folliculaire <span class="inline-dots">{{ $fsh_folliculaire ?? '' }}</span> <span class="vn">[4,46 – 12,43]</span></li>
                    <li>P. Ovulation <span class="inline-dots">{{ $fsh_ovulation ?? '' }}</span> <span class="vn">[4,88 – 20,96]</span></li>
                    <li>P. lutéale <span class="inline-dots">{{ $fsh_luteale ?? '' }}</span> <span class="vn">[1,96 – 7,70]</span></li>
                    <li>P. ménopause <span class="inline-dots">{{ $fsh_menopause ?? '' }}</span> <span class="vn">[22,70 – 130]</span></li>
                </ul>
            </td>
        </tr>
        @endif
        @endif
        @endforeach
        @endforeach

        {{-- ---- LH ---- --}}
        @foreach($categories as $categoryName => $elements)
        @if($categoryName == 'LH')
        <tr>
            <td colspan="4" class="sub-header half-left">Hormone luteinisante <span class="small italic">(mIU/L)</span></td>
        </tr>
        @endif

        @foreach($elements as $element)
        @if($element->nom == 'LH')
        <tr>
            <td>{{ $element->nom }}</td>
            <td style="text-align: right;">
                @if($record->patient->sexe == 'M')
                {{ $element->pivot->resultat ?? '' }}
                @endif

                @if($record->patient->sexe == 'F')

                <span style="margin-left:40px; font-weight:semi-bold;">{{ $element->pivot->resultat ?? '' }}</span>
            </td>
            <td>{{$element->unite}}</td>
            <td>@if($record->patient->sexe == 'M') reg @endif</td>
        </tr>
        <tr>
            <td colspan="4">
                <ul class="sub-list">
                    <li>P. folliculaire <span class="inline-dots">{{ $fsh_folliculaire ?? '' }}</span> <span class="vn">[4,46 – 12,43]</span></li>
                    <li>P. Ovulation <span class="inline-dots">{{ $fsh_ovulation ?? '' }}</span> <span class="vn">[4,88 – 20,96]</span></li>
                    <li>P. lutéale <span class="inline-dots">{{ $fsh_luteale ?? '' }}</span> <span class="vn">[1,96 – 7,70]</span></li>
                    <li>P. ménopause <span class="inline-dots">{{ $fsh_menopause ?? '' }}</span> <span class="vn">[22,70 – 130]</span></li>
                </ul>
            </td>
        </tr>
        @endif
        @endif
        @endforeach
        @endforeach



        {{-- ---- β HCG ---- --}}
        @foreach($categories as $categoryName => $elements)
        @if($categoryName == 'BetaHCG')
        <tr>
            <td colspan="4" class="section-header">Hormone chorionique gonadotrope humaine</td>
        </tr>
        @foreach($elements as $element)
        @if($element->nom == 'BetaHCG')
        <tr>
            <td colspan="4">
                <p style="margin-bottom:8px;">
                    <span class="result-name">&#946;HCG</span>
                    <span class="inline-dots">{{ $element->pivot->resultat ?? '' }}</span>
                    <span class="vn">VN : [&lt; 2 mIU/ml] &nbsp; Rangé : [2 – 2×10<sup>6</sup> mUI/ml]</span>
                </p>
                <p class="center bold" style="margin-bottom:6px; font-size:10px; text-decoration:underline; letter-spacing:0.5px;">
                    Semaines d'aménorrhée :
                </p>
                <table style="width:100%; border-collapse:collapse;">
                    <tr>
                        <td style="width:50%; padding:2px 6px; vertical-align:top; border-right:1px dotted #000;">
                            <p style="margin-bottom:4px;"><span class="result-name">S3</span> <span class="inline-dots">{{ $sa3  ?? '' }}</span> <span class="vn">[5,8 – 71,2]</span></p>
                            <p style="margin-bottom:4px;"><span class="result-name">S5</span> <span class="inline-dots">{{ $sa5  ?? '' }}</span> <span class="vn">[217 – 7 158]</span></p>
                            <p style="margin-bottom:4px;"><span class="result-name">S6</span> <span class="inline-dots">{{ $sa6  ?? '' }}</span> <span class="vn">[158 – 31 795]</span></p>
                            <p style="margin-bottom:4px;"><span class="result-name">S7</span> <span class="inline-dots">{{ $sa7  ?? '' }}</span> <span class="vn">[3 697 – 163 563]</span></p>
                            <p style="margin-bottom:4px;"><span class="result-name">S8</span> <span class="inline-dots">{{ $sa8  ?? '' }}</span> <span class="vn">[32 065 – 149 571]</span></p>
                            <p style="margin-bottom:4px;"><span class="result-name">S9</span> <span class="inline-dots">{{ $sa9  ?? '' }}</span> <span class="vn">[63 803 – 151 410]</span></p>
                            <p style="margin-bottom:4px;"><span class="result-name">S10</span> <span class="inline-dots">{{ $sa10 ?? '' }}</span> <span class="vn">[46 509 – 186 977]</span></p>
                        </td>
                        <td style="width:50%; padding:2px 6px; vertical-align:top;">
                            <p style="margin-bottom:4px;"><span class="result-name">S12</span> <span class="inline-dots">{{ $sa12 ?? '' }}</span> <span class="vn">[27 832 – 186 977]</span></p>
                            <p style="margin-bottom:4px;"><span class="result-name">S14</span> <span class="inline-dots">{{ $sa14 ?? '' }}</span> <span class="vn">[13 950 – 62 530]</span></p>
                            <p style="margin-bottom:4px;"><span class="result-name">S15</span> <span class="inline-dots">{{ $sa15 ?? '' }}</span> <span class="vn">[12 030 – 70 971]</span></p>
                            <p style="margin-bottom:4px;"><span class="result-name">S16</span> <span class="inline-dots">{{ $sa16 ?? '' }}</span> <span class="vn">[9 040 – 56 451]</span></p>
                            <p style="margin-bottom:4px;"><span class="result-name">S17</span> <span class="inline-dots">{{ $sa17 ?? '' }}</span> <span class="vn">[8 175 – 55 868]</span></p>
                            <p style="margin-bottom:4px;"><span class="result-name">S18</span> <span class="inline-dots">{{ $sa18 ?? '' }}</span> <span class="vn">[8 099 – 58 176]</span></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- ---- Troponine ---- --}}
        @foreach($categories as $categoryName => $elements)
        @if($categoryName == 'Troponine')
        <!-- <tr>
            <td colspan="4" class="section-header">Troponine</td>
        </tr> -->
        @foreach($elements as $element)
        @if($element->nom == 'Troponine')
        <tr>
            <td>
                <span class="result-name">Troponine</span>
            </td>
            <td style="text-align: right;">{{ $element->pivot->resultat ?? '' }}</td>
            <td>{{$element->unite ?? ''}}</td>
            <td>VN : [&lt; 0.3]ng/l</td>
        </tr>
        @endif
        @endforeach
        @endif
        @endforeach
        {{-- ---- HBA1C ---- --}}
        @foreach($categories as $categoryName => $elements)
        @if($categoryName == 'HBA1c')
        <tr>
            <td colspan="4" class="section-header">Hémoglobine glyquée</td>
        </tr>
        @foreach($elements as $element)
        @if($element->nom == 'HBA1c')
        <tr>
            <td>
                <span class="result-name">HBA1c</span>
            </td>
            <td style="text-align: right;">{{ $element->pivot->resultat ?? '' }}</td>
            <td>{{$element->unite ?? ''}}</td>
            <td>VN : [&lt; 6,5%]</td>
        </tr>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- ---- ŒSTRADIOL ---- --}}
        
        @foreach($categories as $categoryName => $elements)
        @if($categoryName == 'ŒSTRADIOL')
        <tr>
            <td colspan="4" class="sub-header half-left">{{$categoryName}}</td>
        </tr>
        @endif

        @foreach($elements as $element)
        @if($element->nom == 'E2')
        <tr>
            <td>{{ $element->nom }}</td>
            <td style="text-align: right;">
                @if($record->patient->sexe == 'M' || $record->patient->age < 15)
                {{ $element->pivot->resultat ?? '' }}
                @endif

                @if($record->patient->sexe == 'F')

                <span style="text-align: right; font-weight:semi-bold;">{{ $element->pivot->resultat ?? '' }}</span>
            </td>
            <td>unite</td>
            <td>ref</td>
        </tr>
        <tr>
            <td colspan="4">
                <ul class="sub-list">
                    <li>Avant puberté <span class="inline-dots">{{ $fsh_folliculaire ?? '' }}</span> <span class="vn">[4,46 – 12,43]</span></li>
                    <li>P. folliculaire <span class="inline-dots">{{ $fsh_folliculaire ?? '' }}</span> <span class="vn">[4,46 – 12,43]</span></li>
                    <li>P. Ovulation <span class="inline-dots">{{ $fsh_ovulation ?? '' }}</span> <span class="vn">[4,88 – 20,96]</span></li>
                    <li>P. lutéale <span class="inline-dots">{{ $fsh_luteale ?? '' }}</span> <span class="vn">[1,96 – 7,70]</span></li>
                    <li>P. ménopause <span class="inline-dots">{{ $fsh_menopause ?? '' }}</span> <span class="vn">[22,70 – 130]</span></li>
                </ul>
            </td>
        </tr>
        @endif
        @endif
        @endforeach
        @endforeach

        {{-- ---- PROLACTINE ---- --}}
        
        @foreach($categories as $categoryName => $elements)
        @if($categoryName == 'PRL')
        <tr>
            <td colspan="4" class="sub-header half-left">PROLACTINE</td>
        </tr>
        @endif

        @foreach($elements as $element)
        @if($element->nom == 'PRL')
        <tr>
            <td>{{ $element->nom }}</td>
            <td style="text-align: right;">
                @if($record->patient->sexe == 'M')
                {{ $element->pivot->resultat ?? '' }}
            
                @endif
            
                @if($record->patient->sexe == 'F')

                <span style="text-align: right; font-weight:semi-bold;">{{ $element->pivot->resultat ?? '' }}</span>
            </td>
            <td>unite</td>
            <td>ref</td>
        </tr>
        <tr>
            <td colspan="4">
                <ul class="sub-list">
                    <li>Pré-ménopausées folliculaire <span class="inline-dots">{{ $fsh_folliculaire ?? '' }}</span> <span class="vn">[4,46 – 12,43]</span></li>
                    <li>Post-ménopausées <span class="inline-dots">{{ $fsh_ovulation ?? '' }}</span> <span class="vn">[4,88 – 20,96]</span></li>
                    <li>P. lutéale <span class="inline-dots">{{ $fsh_luteale ?? '' }}</span> <span class="vn">[1,96 – 7,70]</span></li>
                    <li>P. ménopause <span class="inline-dots">{{ $fsh_menopause ?? '' }}</span> <span class="vn">[22,70 – 130]</span></li>
                </ul>
            </td>
        </tr>
        @endif
        @endif
        @endforeach
        @endforeach

    </table>

    {{-- ========== FOOTER ========== --}}
    <div class="rule-thin"></div>

    <table class="footer-table">
        <tr>
            <td style="width:55%; vertical-align:bottom;">
                <span class="bold">Date :</span>
                <span class="inline-dots" style="min-width:130px;">{{ $date ?? '' }}</span>
            </td>
            <td class="footer-right" style="width:45%; vertical-align:bottom;">
                <div class="footer-sig-label">Responsable du laboratoire</div>
                <div class="sig-line"></div>
                <div class="footer-sig-name">Mme Rahamatou SILAI</div>
                <div class="footer-sig-title">Parasitologue / MSc Biochimie</div>
            </td>
        </tr>
    </table>

</body>

</html>