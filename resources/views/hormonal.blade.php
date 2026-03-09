<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Bulletin d'Analyse Hormonale</title>
    <style>
        /* dompdf-compatible CSS - no flexbox, no grid, use tables for layout */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
            padding: 15px 30px;
        }

        /* ---- Header ---- */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .header-logo {
            width: 70px;
            vertical-align: middle;
        }

        .header-info {
            text-align: center;
            vertical-align: middle;
        }

        .header-info p {
            font-size: 10px;
            line-height: 1.5;
        }

        .header-title {
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 4px;
        }

        /* ---- Patient info ---- */
        .patient-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        .patient-table td {
            padding: 3px 5px;
            font-size: 10px;
        }

        .patient-label {
            font-weight: bold;
            white-space: nowrap;
        }

        .patient-value {
            border-bottom: 1px solid #000;
            min-width: 80px;
        }

        /* ---- Main content table ---- */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        .main-table td,
        .main-table th {
            border: 1px solid #000;
            padding: 5px 7px;
            vertical-align: top;
        }

        .section-header {
            background-color: #4CAF50;
            color: #fff;
            font-weight: bold;
            font-size: 11px;
            text-align: center;
        }

        .sub-header {
            font-weight: bold;
            font-size: 10px;
            text-align: center;
            background-color: #f2f2f2;
        }

        .field-line {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        .field-line td {
            border: none;
            padding: 1px 0;
            font-size: 10px;
        }

        .dots {
            border-bottom: 1px dotted #000;
            width: 120px;
            display: inline-block;
            vertical-align: bottom;
            margin: 0 3px;
        }

        .vn {
            color: #333;
            font-size: 9px;
        }

        /* Sub-list */
        .sub-list {
            list-style: disc;
            padding-left: 15px;
            margin: 2px 0;
        }

        .sub-list li {
            margin-bottom: 2px;
            font-size: 9.5px;
        }

        /* ---- Half columns ---- */
        .half-left {
            width: 50%;
            border-right: 1px solid #000;
            padding: 5px 7px;
            vertical-align: top;
        }

        .half-right {
            width: 50%;
            padding: 5px 7px;
            vertical-align: top;
        }

        /* ---- Footer ---- */
        .footer-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .footer-table td {
            font-size: 10px;
            padding: 3px;
        }

        .footer-right {
            text-align: right;
            font-weight: bold;
        }

        .bold {
            font-weight: bold;
        }

        .center {
            text-align: center;
        }

        .inline-dots {
            border-bottom: 1px dotted #555;
            min-width: 100px;
            display: inline-block;
            vertical-align: bottom;
        }

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
            font-size: 110px;
            font-weight: bold;
            color: #e0e0e0;
            display: inline-block;
            transform: rotate(-45deg);
            letter-spacing: 50px;
        }
    </style>
</head>

<body>
    {{-- ========== FILIGRANE ========== --}}
    {{--
        position:fixed en dompdf = répété sur chaque page, derrière le contenu.
        z-index:-1000 assure qu'il reste sous tous les autres éléments.
    --}}
    <div class="watermark">
        <span>MLCP</span>
    </div>
    {{-- ========== HEADER ========== --}}
    <table class="header-table">
        <tr>
            <td class="header-logo">
                {{-- Logo placeholder - replace src with {{ asset('images/logo.png') }} --}}
                <img src="{{ $logo ?? '' }}" width="60" alt="Logo" />
            </td>
            <td class="header-info">
                <p><strong>Mme Rahamatou SILAI</strong> &nbsp; Tel : 3330375 / 4490375</p>
                <p>Assistante : Melle Fatima Mbaé &nbsp; Tel : 3431738</p>
                <p>MORONI-COULEE</p>
                <p class="header-title">Bulletin d'Analyse Hormonale</p>
            </td>
        </tr>
    </table>

    {{-- ========== PATIENT INFO ========== --}}
    <table class="patient-table">
        <tr>
            <td class="patient-label">Nom :</td>
            <td class="patient-value">{{ $record->patient->nom ?? '' }}</td>
            <td class="patient-label">Prénom :</td>
            <td class="patient-value">{{ $record->patient->prenom ?? '' }}</td>
            <td class="patient-label">Tel :</td>
            <td class="patient-value">{{ $record->patient->phone ?? '' }}</td>
            <td class="patient-label">Age :</td>
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
    @php

        $categories = [];
        foreach ($record->elements as $element) {
        $catName = $element->category->name ?? 'Sans catégorie';
        $categories[$catName][] = $element;
        }
        //dd($categories);
    @endphp
    {{-- ========== MAIN TABLE ========== --}}
    <table class="main-table">

        <!-- {{-- FINECARE header --}}
        <tr>
            <td colspan="2" class="section-header">FINECARE <sup>TM</sup></td>
        </tr> -->

        {{-- ---- BILAN PROSTATIQUE ---- --}}
        @foreach($categories as $categoryName => $elements)
            @if($categoryName == 'BILAN PROSTATIQUE')
            <tr>
                <td colspan="2" class="sub-header"> {{ $categoryName }}</td>
            </tr>
            
            
            
        @foreach($elements as $element)
        <tr>
            <td colspan="2">
                <strong>{{$element->nom}}</strong>                
                <span class="inline-dots" style="margin-left: 50px;">{{ $element->pivot->resultat ?? '' }}</span>
                <span class="vn">VN : &lt; 4 ng/ml</span>
            </td>            
        </tr>
        @endforeach
        @endif
         @endforeach
        {{-- ---- BILAN THYROÏDIEN ---- --}}
        
        @foreach($categories as $categoryName => $elements)
            @if($categoryName == 'BILAN THYROÏDIEN')
        <tr>
            <td colspan="2" class="sub-header">{{$categoryName}}</td>
        </tr>      
        
        <tr>            
            <td colspan="2">
                @foreach($elements as $element)
                <p style="margin-bottom:5px;">
                    <strong>{{$element->nom}}</strong>
                    <span class="inline-dots">{{ $element->pivot->resultat ?? '' }}</span>
                    <span class="vn">VN : [0,3 – 4,2 mUI/l] &nbsp; Rangé : [0,1 – 100 mUI/l]</span>
                </p>
                @endforeach
                
        </tr> 
        
        @endif
        @endforeach

        
        {{-- ---- FSH / LH ---- --}}
        
        <tr>
            <td class="sub-header half-left" style="border-right:1px solid #000;">FSH (mIU/L)</td>
            <td class="sub-header">LH (mIU/L)</td>
        </tr>
        <tr>
            @foreach($categories as $categoryName => $elements)
            @if($categoryName == 'FSH')
            <td class="half-left">
                @foreach($elements as $element)
                @if($element->nom == 'FSH')
                @if($record->patient->sexe == 'M')
                <p><strong>Homme :</strong>
                    <span class="inline-dots">{{ $element->pivot->resultat ?? '' }}</span>
                    <!-- <span class="vn">[1,50 – 12,40] &nbsp; Rangé : 1-100</span> -->
                </p>
                <br>
                @endif
                
                @if($record->patient->sexe == 'F')
                <p><strong>Femme : ........................{{ $element->pivot->resultat ?? '' }}</strong></p>
                <ul class="sub-list">
                    <li>P. folliculaire <span class="inline-dots">{{ $fsh_folliculaire ?? '' }}</span> <span class="vn">[4,46 – 12,43]</span></li>
                    <li>P. Ovulation <span class="inline-dots">{{ $fsh_ovulation ?? '' }}</span> <span class="vn">[4,88 – 20,96]</span></li>
                    <li>P. lutéale <span class="inline-dots">{{ $fsh_luteale ?? '' }}</span> <span class="vn">[1,96 – 7,70]</span></li>
                    <li>P. ménopause <span class="inline-dots">{{ $fsh_menopause ?? '' }}</span> <span class="vn">[22,70 – 130]</span></li>
                </ul>
                @endif
                @endif
                @endforeach
            </td>
            @endif
            @endforeach
            <td class="half-right">
                <p><strong>Homme :</strong>
                    <span class="inline-dots">{{ $lh_homme ?? '' }}</span>
                    <span class="vn">[1,70 – 8,60] &nbsp; Rangé : 1-100</span>
                </p>
                <br>
                <p><strong>Femme :</strong></p>
                <ul class="sub-list">
                    <li>P. folliculaire <span class="inline-dots">{{ $lh_folliculaire ?? '' }}</span> <span class="vn">[2,95 – 13,65]</span></li>
                    <li>P. Ovulation <span class="inline-dots">{{ $lh_ovulation ?? '' }}</span> <span class="vn">[13,65 – 95,75]</span></li>
                    <li>P. lutéale <span class="inline-dots">{{ $lh_luteale ?? '' }}</span> <span class="vn">[1,25 – 11,00]</span></li>
                    <li>P. ménopause <span class="inline-dots">{{ $lh_menopause ?? '' }}</span> <span class="vn">[8,24 – 55,23]</span></li>
                </ul>
            </td>
        </tr>

        {{-- ---- BHCG ---- --}}
        <tr>
            <td colspan="2">
                <p style="margin-bottom:6px;">
                    <strong>&#223;HCG</strong>
                    <span class="inline-dots">{{ $bhcg ?? '' }}</span>
                    <span class="vn">VN : [&lt; 2 mIU/ml] &nbsp; Rangé : [2 – 2×10<sup>6</sup> mUI/ml]</span>
                </p>
                <p class="center bold" style="margin-bottom:4px;">Semaines d'aménorrhée :</p>

                {{-- Two-column layout for SA values using table --}}
                <table style="width:100%; border-collapse:collapse;">
                    <tr>
                        <td style="width:50%; padding:2px 5px; vertical-align:top;">
                            <p style="margin-bottom:3px;"><strong>3</strong> <span class="inline-dots">{{ $sa3 ?? '' }}</span> <span class="vn">[5,8 – 71,2]</span></p>
                            <p style="margin-bottom:3px;"><strong>5</strong> <span class="inline-dots">{{ $sa5 ?? '' }}</span> <span class="vn">[217 – 7158]</span></p>
                            <p style="margin-bottom:3px;"><strong>6</strong> <span class="inline-dots">{{ $sa6 ?? '' }}</span> <span class="vn">[158 – 31795]</span></p>
                            <p style="margin-bottom:3px;"><strong>7</strong> <span class="inline-dots">{{ $sa7 ?? '' }}</span> <span class="vn">[3697 – 163563]</span></p>
                            <p style="margin-bottom:3px;"><strong>8</strong> <span class="inline-dots">{{ $sa8 ?? '' }}</span> <span class="vn">[32065 – 149571]</span></p>
                            <p style="margin-bottom:3px;"><strong>9</strong> <span class="inline-dots">{{ $sa9 ?? '' }}</span> <span class="vn">[63803 – 151410]</span></p>
                            <p style="margin-bottom:3px;"><strong>10</strong> <span class="inline-dots">{{ $sa10 ?? '' }}</span> <span class="vn">[46509 – 186977]</span></p>
                        </td>
                        <td style="width:50%; padding:2px 5px; vertical-align:top;">
                            <p style="margin-bottom:3px;"><strong>12</strong> <span class="inline-dots">{{ $sa12 ?? '' }}</span> <span class="vn">[27832 – 186977]</span></p>
                            <p style="margin-bottom:3px;"><strong>14</strong> <span class="inline-dots">{{ $sa14 ?? '' }}</span> <span class="vn">[13950 – 62530]</span></p>
                            <p style="margin-bottom:3px;"><strong>15</strong> <span class="inline-dots">{{ $sa15 ?? '' }}</span> <span class="vn">[12030 – 70971]</span></p>
                            <p style="margin-bottom:3px;"><strong>16</strong> <span class="inline-dots">{{ $sa16 ?? '' }}</span> <span class="vn">[9040 – 56451]</span></p>
                            <p style="margin-bottom:3px;"><strong>17</strong> <span class="inline-dots">{{ $sa17 ?? '' }}</span> <span class="vn">[8175 – 55868]</span></p>
                            <p style="margin-bottom:3px;"><strong>18</strong> <span class="inline-dots">{{ $sa18 ?? '' }}</span> <span class="vn">[8099 – 58176]</span></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- ---- HBA1C ---- --}}
        <tr>
            <td colspan="2">
                <strong>HBA1c :</strong>
                <span class="inline-dots">{{ $hba1c ?? '' }}</span>
                <span class="vn">VN : [&lt; 6,5%] &nbsp; Rangé : [4 – 14,5%]</span>
            </td>
        </tr>

        {{-- ---- ESTRADIOL (last unnamed section) ---- --}}
        <tr>
            <td colspan="2">
                <p style="margin-bottom:4px;">
                    <strong>Homme :</strong>
                    <span class="inline-dots">{{ $estradiol_homme ?? '' }}</span>
                    <span class="vn">31 – 433</span>
                </p>
                <p><strong>Femme :</strong></p>
                <ul class="sub-list">
                    <li>Post ménopause <span class="inline-dots">{{ $estradiol_post_menopause ?? '' }}</span> <span class="vn">33 – 413</span></li>
                    <li>Pré- ménopause <span class="inline-dots">{{ $estradiol_pre_menopause ?? '' }}</span> <span class="vn">118 – 555</span></li>
                </ul>
            </td>
        </tr>

    </table>

    {{-- ========== FOOTER ========== --}}
    <table class="footer-table">
        <tr>
            <td style="width:50%;">
                <strong>Date :</strong>
                <span class="inline-dots" style="min-width:120px;">{{ $date ?? '' }}</span>
            </td>
            <td class="footer-right">
                Responsable du laboratoire
            </td>
        </tr>
    </table>

</body>

</html>