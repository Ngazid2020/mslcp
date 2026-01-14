<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Résultats Labo - {{ $patient->nom ?? 'Patient' }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            margin: 15px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .lab-info {
            font-size: 10px;
        }

        .patient-info {
            border: 1px solid #000;
            padding: 8px;
            margin: 15px 0;
        }

        .patient-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .patient-info td {
            padding: 4px;
            width: 50%;
        }

        .section-title {
            background-color: #d3d3d3;
            font-weight: bold;
            text-align: center;
            padding: 6px;
            margin-top: 12px;
            border: 1px solid #000;
            font-size: 14px;
        }
        .section-title-secondary {
            font-weight: bold;
            text-decoration: underline;
            font-size: 12px;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .results-table td {
            border: 1px solid #000;
            /* padding: 7px; */
        }

        .parameter-name {
            width: 20%;
            background-color: #f5f5f5;
        }

        .result-value {
            width: 40%;
            text-align: center;
            height: 40px;
        }

        .result-value-petit {
            width: 40%;
            text-align: center;
            /* height: 20px; */
        }

        .ref-range {
            width: 40%;
        }

        .signature-section {
            margin-top: 40px;
            width: 100%;
        }

        .signature-section table {
            width: 100%;
        }

        .signature-block {
            width: 50%;
            vertical-align: top;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 40px;
            width: 80%;
        }
    </style>
</head>

<body>
    <!-- EN-TÊTE -->
    <div class="header">
        <div class="lab-info">
            <strong>MAISON DE SURVEILLANCE ET DE LUTTE CONTRE LE PALUDISME</strong><br>
            LABORATOIRE D'ANALYSES MEDICALES<br>
            Dirigée par Mme Rahamatou Silai Parasitologue/Msc Biochimie<br>
            Chef de service Mhossein Mohamed Et Habib Technicien Biologiste de Laboratoire<br>
            Tel: +269 33 30 375 / 44 65 45 71 47 91 95 8<br>
            E-mail: mslcp.silai@yahoo.fr
        </div>
    </div>

    <!-- INFORMATIONS PATIENT -->
    <div class="patient-info">
        <table>
            <tr>
                <td><strong>Nom:</strong> {{ $record->patient->nom ?? '' }}</td>
                <td><strong>Prénom:</strong> {{ $record->patient->prenom ?? '' }}</td>
            </tr>
            <tr>
                <td><strong>Téléphone:</strong> {{ $record->patient->telephone ?? '' }}</td>
                <td><strong>Age:</strong> {{ $record->patient->age ?? '' }}</td>
            </tr>
            <tr>
                <td><strong>Domicile:</strong> {{ $record->patient->domicile ?? '' }}</td>
                <td><strong>Prescripteur:</strong> {{ $record->prescripteur->nom ?? '' }}</td>
            </tr>
        </table>
    </div>

    <!-- BIOCHIMIE URINAIRE -->
    <div class="section-title">BIOCHIMIE URINAIRE</div>
    <div class="patient-info">
        <table>
            <tr>
                <td><strong>Urobilinogène:</strong> {{ $record->urobilinogene ?? '' }} mg/L</td>
                <td><strong>Albumine:</strong> {{ $record->albumine ?? '' }}</td>
                <td><strong>Sucre:</strong> {{ $record->sucre ?? '' }}</td>
                <td><strong>Acétone:</strong> {{ $record->acetone ?? '' }}</td>
            </tr>
            <tr>
                <td><strong>pH:</strong> {{ $record->ph ?? '' }}</td>
                <td><strong>Bilirubine:</strong> {{ $record->bilirubine ?? '' }}</td>
                <td><strong>Densité:</strong> {{ $record->densite ?? '' }}</td>
                <td><strong>Sang:</strong> {{ $record->sang ?? '' }}</td>
            </tr>
            <tr>
                <td><strong>Nitrite:</strong> {{ $record->ntrite ?? '' }}</td>
                <td><strong>Leucocytes:</strong> {{ $record->leucocytes ?? '' }}</td>
            </tr>
        </table>
    </div>
    

    <!-- ECBU -->
    <div class="section-title">EXAMEN CYTOBACTERIOLOGIQUE DES URINES (ECBU)</div>
    <table class="results-table">
        <tr>
            <td colspan="2"><div class="section-title-secondary">E. macroscopique</div></td>
        </tr>
        <tr>
            <td class="parameter-name">Aspect des urines</td>
            <td class="result-value-petit">{{ $record->aspect_urines ?? '' }}</td>
        </tr>
        
        <tr><td colspan="2"><div class="section-title-secondary">E. Microscopique</div></td></tr>
        <tr>
            <td class="parameter-name">Cellules épithéliales</td>
            <td class="result-value-petit">{{ $record->cellules_epitheliales ?? '' }}</td>
        </tr>
        <tr>
            <td class="parameter-name">Leucocytes</td>
            <td class="result-value-petit">{{ $record->leucocytes_micro ?? '' }}</td>
        </tr>
        <tr>
            <td class="parameter-name">Hématies</td>
            <td class="result-value-petit">{{ $record->hematies ?? '' }}</td>
        </tr>
        <tr>
            <td class="parameter-name">Parasites</td>
            <td class="result-value-petit">{{ $record->parasites ?? '' }}</td>
        </tr>
        <tr>
            <td class="parameter-name">Eléments fongiques</td>
            <td class="result-value-petit">{{ $record->elements_fongiques ?? '' }}</td>
        </tr>
        <tr>
            <td class="parameter-name">Bacteries</td>
            <td class="result-value-petit">{{ $record->bacteries ?? '' }}</td>
        </tr>
        <tr>
            <td class="parameter-name">Cristaux</td>
            <td class="result-value-petit">{{ $record->cristaux ?? '' }}</td>
        </tr>
        <tr>
            <td class="parameter-name">Coloration de Gram</td>
            <td class="result-value">{{ $record->coloration_gram ?? '' }}</td>
        </tr>
        <tr>
            <td class="parameter-name">Culture</td>
            <td class="result-value">{{ $record->culture ?? '' }}</td>
        </tr>
        <tr>
            <td class="parameter-name">Conclusion</td>
            <td class="result-value">{{ $record->conclusion ?? '' }}</td>
        </tr>
    </table>

    <!-- SIGNATURE -->
    <div class="signature-section">
        <table>
            <tr>
                <td class="signature-block">
                </td>
                <td class="signature-block">
                    <strong>Chef de service (Directrice)</strong><br><br><br>
                    <div class="signature-line"></div>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>