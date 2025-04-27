<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Résultat Hémogramme - MSLCP</title>
    <style>
        @page {
            margin-top: 10mm;
            margin-right: 5mm;
            margin-bottom: 0mm;
            margin-left: 5mm;
        }

        body {
            font-family: Arial, sans-serif;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 12px;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 22px;
            color: #000;
        }

        header h2 {
            font-size: 18px;
            margin-top: 5px;
            color: #000;
        }

        .info {
            margin-bottom: 20px;
            line-height: 1.6;
            font-size: 14px;
        }

        .section-title {
            background-color: #f0f0f0;
            color: #000;
            padding: 8px 12px;
            margin-top: 30px;
            margin-bottom: 10px;
            border-radius: 6px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 13px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f9f9f9;
            color: #000;
        }

        .signature {
            text-align: right;
            margin-top: 0px;
            padding-top: 0px;
        }

        .signature img {
            width: 150px;
            height: auto;
        }

        .qrcode {
            margin-top: 30px;
            text-align: right;
        }

        .info-qrcode {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .qrcode img {
            width: 200px;
            height: 00px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border: none;
        }

        .info-table td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        .info-table td.info {
            text-align: left;
        }

        .symbole {
            width: 25px;
            /* height: 25px; */
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1>MAISON DE SURVEILLANCE ET DE LUTTE CONTRE LE PALUDISME (MSLCP)</h1>
            <h2>LABORATOIRE D’ANALYSES MÉDICALES</h2>
            <p>Dirigée par Mme Rahamatou SILAI – Parasitologue / MSc Biochimie<br>
                Tél : +269 3330375 / 4735095 – Email : <a href="mailto:mslcp_silai@yahoo.fr">mslcp_silai@yahoo.fr</a></p>
        </header>

        <table class="info-table">
            <tr>
                <td class="info">
                    <strong>Cabinet Médical Privé</strong><br>
                    Patient : {{$record->patient->nom ?? '__'}}, Âge : {{$record->patient->age}} , Sexe : {{$record->patient->sexe ?? '__'}}<br>
                    Lieu : {{$record->patient->lieu_naissance ?? '__'}}, Résidence : {{$record->patient->adresse ?? '__'}}<br>
                    Préscripteur : Dr {{$record->patient->prescripteur ?? '__'}}<br><br>
                    <strong>Numéro de patient :</strong> 0-0-25<br>
                    <strong>Prélevé le :</strong> {{$record->created_at}}<br>
                    <!-- <strong>Édité le :</strong> 0-0-25 -->
                </td>
                <td class="qrcode-cell" style="text-align: right; vertical-align: top;">
                    <img src="data:image/png;base64,{{ $qrcode }}" alt="QR Code" style="width: 90px; height: 90px;">
                </td>
            </tr>
        </table>

        @php
        // Fonction pour déterminer l'état (flèche) selon la valeur et les références
        function getArrowAndRefs($element, $age, $sexe, &$refMin, &$refMax) {
            $value = floatval($element->pivot->resultat ?? 0);

            if ($age < 5) {
                $refMin = floatval($element->ref_inf_nour ?? 0);
                $refMax = floatval($element->ref_sup_nour ?? 0);
            } elseif ($age >= 5 && $age < 15) {
                $refMin = floatval($element->ref_inf_enf ?? 0);
                $refMax = floatval($element->ref_sup_enf ?? 0);
            } else { // âge >= 15
                if ($sexe == 'F') {
                    $refMin = floatval($element->ref_inf_f ?? 0);
                    $refMax = floatval($element->ref_sup_f ?? 0);
                } else {
                    $refMin = floatval($element->ref_inf_h ?? 0);
                    $refMax = floatval($element->ref_sup_h ?? 0);
                }
            }

            if ($value < $refMin) {
                return 'arrow-down.png';
            } elseif ($value > $refMax) {
                return 'arrow-up.png';
            } else {
                return 'check_ok.png';
            }
        }

        // Regrouper les éléments par catégorie
        $categories = [];
        foreach ($record->elements as $element) {
            $catName = $element->category->name ?? 'Sans catégorie';
            $categories[$catName][] = $element;
        }
        @endphp

        @foreach ($categories as $categoryName => $elements)
            <div class="section-title">{{ $categoryName }}</div>
            <table>
                <tr>
                    <th width="30%">Paramètre</th>
                    <th>Valeur</th>
                    <th>Unité</th>
                    <th>Référence</th>
                    <th width="20">État</th>
                </tr>
                @foreach ($elements as $element)
                    @php
                        $refMin = 0;
                        $refMax = 0;
                        $arrow = getArrowAndRefs($element, $record->patient->age, $record->patient->sexe, $refMin, $refMax);
                    @endphp
                    <tr>
                        <td>{{ $element->nom }}</td>
                        <td>{{ $element->pivot->resultat }}</td>
                        <td>{{ $element->unite }}</td>
                        <td>{{ $refMin }} - {{ $refMax }}</td>
                        <td><img src="{{ public_path('img/' . $arrow) }}" class="symbole" alt="État"></td>
                    </tr>
                @endforeach
            </table>
        @endforeach

        <div class="signature">
            <p style="margin-bottom: -10px;"><strong>Responsable du Laboratoire:</strong></p>
            <img src="{{ public_path('img/signature.png') }}" alt="Signature du médecin">
        </div>
    </div>
</body>

</html>
