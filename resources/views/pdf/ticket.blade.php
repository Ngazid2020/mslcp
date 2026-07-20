<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Ticket - {{ $bilan->ref }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            background: #fff;
            padding: 10px;
        }

        .ticket-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 10px;
        }

        .ticket-part {
            width: 48%;
            border: 1px dashed #333;
            padding: 15px;
            border-radius: 4px;
            background: #fefefe;
            page-break-inside: avoid;
        }

        .ticket-part.full {
            width: 100%;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #ccc;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .header h1 {
            font-size: 18px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .header .ref {
            font-size: 14px;
            font-weight: bold;
            color: #1a56db;
            margin-top: 4px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4px 12px;
            margin-bottom: 12px;
            font-size: 11px;
        }

        .info-grid .label {
            font-weight: bold;
            color: #555;
        }

        .info-grid .value {
            color: #000;
        }

        .separator {
            border-top: 1px dashed #aaa;
            margin: 10px 0;
        }

        .elements-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin: 8px 0;
        }

        .elements-table th {
            text-align: left;
            border-bottom: 1px solid #000;
            padding: 4px 2px;
            font-weight: bold;
        }

        .elements-table td {
            padding: 3px 2px;
            border-bottom: 1px dotted #ddd;
        }

        .elements-table .price {
            text-align: right;
            font-weight: bold;
        }

        .total {
            margin-top: 12px;
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            border-top: 2px solid #000;
            padding-top: 8px;
        }

        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 10px;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }

        .qr-code {
            text-align: center;
            margin: 10px 0;
        }

        .badge {
            display: inline-block;
            background: #f3f4f6;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            color: #1f2937;
        }

        .part-title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            background: #e5e7eb;
            padding: 4px;
            border-radius: 4px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .part-title.patient {
            background: #dbeafe;
            color: #1e40af;
        }

        .part-title.preleveur {
            background: #fef3c7;
            color: #92400e;
        }

        @media print {
            .ticket-part {
                border: 1px dashed #000 !important;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="ticket-container">

        {{-- PARTIE PATIENT --}}
        <div class="ticket-part">
            <div class="part-title patient">🧾 Partie Patient</div>

            <div class="header">
                <h1>Laboratoire MSLCP</h1>
                <div class="ref">Réf : {{ $bilan->ref }}</div>
                <div style="font-size:10px; color:#666;">{{ $bilan->created_at->format('d/m/Y H:i') }}</div>
            </div>

            <div class="info-grid">
                <span class="label">Patient :</span>
                <span class="value">{{ $bilan->patient->prenom }} {{ $bilan->patient->nom }}</span>

                <span class="label">Âge / Sexe :</span>
                <span class="value">{{ $bilan->patient->age }} ans / {{ $bilan->patient->sexe === 'M' ? 'M' : 'F' }}</span>

                <span class="label">N° dossier :</span>
                <span class="value">{{ $bilan->patient->numero }}</span>

                @if($bilan->prescripteur)
                <span class="label">Prescripteur :</span>
                <span class="value">{{ $bilan->prescripteur->nom }}</span>
                @endif
            </div>

            <div class="separator"></div>

            <table class="elements-table">
                <thead>
                    <tr>
                        <th>Analyse</th>
                        <th style="text-align:right;">Prix</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bilan->elements as $el)
                    <tr>
                        <td>{{ $el->nom }}</td>
                        <td class="price">{{ number_format($el->prix ?? 0, 0, ',', ' ') }} FC</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total">
                TOTAL : {{ number_format($bilan->prix_total ?? $bilan->elements->sum('prix'), 0, ',', ' ') }} FC
            </div>

            <div class="qr-code">
                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(80)->generate($bilan->ref) !!}
            </div>

            <div class="footer">
                Ce ticket fait office de bon de prélèvement.<br>
                Merci de le présenter au préleveur.
            </div>
        </div>

        {{-- PARTIE PRÉLEVEUR --}}
        <div class="ticket-part">
            <div class="part-title preleveur">🩸 Partie Préleveur</div>

            <div class="header">
                <h1>Laboratoire MSLCP</h1>
                <div class="ref">Réf : {{ $bilan->ref }}</div>
                <div style="font-size:10px; color:#666;">{{ $bilan->created_at->format('d/m/Y H:i') }}</div>
            </div>

            <div class="info-grid">
                <span class="label">Patient :</span>
                <span class="value">{{ $bilan->patient->prenom }} {{ $bilan->patient->nom }}</span>

                <span class="label">Âge / Sexe :</span>
                <span class="value">{{ $bilan->patient->age }} ans / {{ $bilan->patient->sexe === 'M' ? 'M' : 'F' }}</span>

                <span class="label">N° dossier :</span>
                <span class="value">{{ $bilan->patient->numero }}</span>
            </div>

            <div class="separator"></div>

            <div style="margin: 8px 0; font-weight:bold; font-size:13px;">
                Analyses à prélever :
            </div>

            <ul style="list-style: none; padding: 0; margin: 0;">
                @foreach($bilan->elements as $el)
                <li style="padding: 4px 0; border-bottom: 1px dotted #eee;">
                    ☐ {{ $el->nom }}
                    @if($el->category)
                    <span class="badge">{{ $el->category->name }}</span>
                    @endif
                </li>
                @endforeach
            </ul>

            <div style="margin-top:12px; font-size:11px; color:#555;">
                <strong>Nombre d'analyses :</strong> {{ $bilan->elements->count() }}
            </div>

            <div class="qr-code">
                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(80)->generate($bilan->ref) !!}
            </div>

            <div class="footer" style="font-weight:bold; color:#b91c1c;">
                À remettre au laborantin après prélèvement.
            </div>
        </div>

    </div>

</body>

</html>