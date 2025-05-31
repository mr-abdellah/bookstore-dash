<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <base href="{{ public_path() }}/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de Commande - {{ $supplier['name'] }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.4;
            font-size: 12px;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            border: 1px solid #ddd;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #eee;
            padding: 15px;
        }

        .header-table td {
            padding: 15px;
            vertical-align: top;
        }

        .logo {
            height: 60px;
        }

        .header-right {
            text-align: right;
        }

        .header-title {
            font-size: 24px;
            font-weight: bold;
            color: #222;
            margin-bottom: 8px;
        }

        .header-info {
            color: #666;
            margin-bottom: 4px;
        }

        .info-section {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #eee;
        }

        .info-section td {
            width: 50%;
            padding: 20px;
            vertical-align: top;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #222;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .info-line {
            margin-bottom: 5px;
            color: #444;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .products-table th {
            background-color: #f8f8f8;
            padding: 12px 8px;
            font-weight: bold;
            color: #555;
            font-size: 11px;
            text-transform: uppercase;
            border-bottom: 2px solid #ddd;
        }

        .products-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #eee;
            font-size: 11px;
        }

        .products-table .text-center {
            text-align: center;
        }

        .products-table .text-right {
            text-align: right;
        }

        .totals-section {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #eee;
        }

        .totals-section td {
            padding: 20px;
            vertical-align: top;
        }

        .totals-table {
            width: 250px;
            margin-left: auto;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #eee;
        }

        .totals-table .total-row {
            font-weight: bold;
            border-top: 2px solid #ddd;
            font-size: 14px;
        }

        .conditions-section {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #eee;
        }

        .conditions-section td {
            width: 50%;
            padding: 20px;
            vertical-align: top;
        }

        .conditions-list {
            list-style-type: disc;
            margin-left: 20px;
        }

        .conditions-list li {
            margin-bottom: 5px;
            color: #555;
            font-size: 11px;
        }

        .signatures-section {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        .signatures-section td {
            width: 50%;
            padding: 20px;
            text-align: center;
            vertical-align: top;
        }

        .signature-label {
            font-size: 11px;
            color: #666;
            margin-bottom: 10px;
        }

        .signature-box {
            border: 1px solid #ccc;
            width: 150px;
            height: 80px;
            margin: 10px auto;
            position: relative;
            background-color: #fafafa;
        }

        .signature-svg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .signature-name {
            font-weight: bold;
            margin-top: 10px;
            font-size: 12px;
        }

        .signature-title {
            font-size: 10px;
            color: #666;
            margin-top: 2px;
        }

        .signature-line {
            border-top: 1px solid #666;
            width: 150px;
            margin: 40px auto 0;
        }

        .footer {
            background-color: #f8f8f8;
            padding: 15px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
        }

        .footer p {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- En-tête -->
        <table class="header-table">
            <tr>
                <td width="60%">
                    <img src="{{ $supplier['logo'] }}" alt="{{ $supplier['name'] }} Logo" class="logo">
                </td>
                <td width="40%" class="header-right">
                    <div class="header-title">BON DE COMMANDE</div>
                    <div class="header-info">N° {{ $orderNumber }}</div>
                    <div class="header-info">Date: {{ $orderDate }}</div>
                </td>
            </tr>
        </table>

        <!-- Informations client et vendeur -->
        <table class="info-section">
            <tr>
                <td>
                    <div class="section-title">Fournisseur:</div>
                    <div class="info-line">{{ $supplier['name'] }}</div>
                    <div class="info-line">{{ $supplier['address'] }}</div>
                    <div class="info-line">{{ $supplier['city'] }}</div>
                    <div class="info-line">Tél: {{ $supplier['phone'] }}</div>
                    <div class="info-line">Email: {{ $supplier['email'] }}</div>
                </td>
                <td>
                    <div class="section-title">Client:</div>
                    <div class="info-line">{{ $client['name'] }}</div>
                    <div class="info-line">{{ $client['address'] }}</div>
                    <div class="info-line">{{ $client['city'] }}</div>
                    <div class="info-line">Tél: {{ $client['phone'] }}</div>
                    <div class="info-line">Email: {{ $client['email'] }}</div>
                </td>
            </tr>
        </table>

        <!-- Tableau des produits -->
        <table class="products-table">
            <thead>
                <tr>
                    <th width="40%">Livre</th>
                    <th width="10%" class="text-center">Quantité</th>
                    <th width="20%" class="text-right">Prix Unitaire (DA)</th>
                    <th width="20%" class="text-right">Montant (DA)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item['description'] }}</td>
                        <td class="text-center">{{ $item['quantity'] }}</td>
                        <td class="text-right">{{ $item['unit_price'] }}</td>
                        <td class="text-right">{{ $item['total'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Récapitulatif -->
        <table class="totals-section">
            <tr>
                <td>
                    <table class="totals-table">
                        <tr class="total-row">
                            <td>Total:</td>
                            <td class="text-right">{{ $totals['total'] }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Conditions et signatures -->
        <table class="conditions-section">
            <tr>
                <td>
                    <div class="section-title">Conditions:</div>
                    <ul class="conditions-list">
                        @foreach ($conditions as $condition)
                            <li>{{ $condition }}</li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <table class="signatures-section">
                        <tr>
                            <td>
                                <div class="signature-label">Signature du fournisseur</div>
                                <div class="signature-box">
                                    <svg class="signature-svg" viewBox="0 0 200 50" width="120" height="30">
                                        <path
                                            d="M10,30 C20,10 30,40 40,20 C50,10 60,30 70,20 C80,10 90,30 100,20 C110,10 120,30 130,20 C140,10 150,30 160,20 C170,10 180,30 190,20"
                                            fill="none" stroke="#000" stroke-width="1.5" />
                                    </svg>
                                </div>
                                <div class="signature-name">Mohammed Karim</div>
                                <div class="signature-title">Directeur Commercial</div>
                            </td>
                            <td>
                                <div class="signature-label">Signature du client</div>
                                <div class="signature-line"></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Pied de page -->
        <div class="footer">
            <p>{{ $supplier['name'] }} - RC: 16/00-1234567B18 - NIF: 16123456789</p>
            <p>{{ $supplier['address'] }}, {{ $supplier['city'] }}, Algérie</p>
        </div>
    </div>
</body>

</html>
