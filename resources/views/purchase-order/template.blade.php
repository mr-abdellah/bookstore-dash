<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bon de Commande - {{ $supplier['name'] }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: sans-serif;
            background-color: #f3f4f6;
            padding: 32px;
            color: #374151;
            line-height: 1.5;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            padding: 24px;
            border-bottom: 1px solid #e5e7eb;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            height: 80px;
        }

        .header-right {
            text-align: right;
        }

        .header-right h1 {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .header-right p {
            color: #6b7280;
            margin-bottom: 4px;
        }

        .info-section {
            padding: 24px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-block h2 {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 12px;
        }

        .info-block p {
            color: #374151;
            margin-bottom: 4px;
        }

        .products-section {
            padding: 24px;
            border-bottom: 1px solid #e5e7eb;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
        }

        .products-table thead tr {
            background-color: #f9fafb;
        }

        .products-table th {
            padding: 12px 16px;
            font-weight: 600;
            color: #6b7280;
            font-size: 14px;
            text-align: left;
        }

        .products-table th.center {
            text-align: center;
        }

        .products-table th.right {
            text-align: right;
        }

        .products-table tbody tr {
            border-top: 1px solid #e5e7eb;
        }

        .products-table td {
            padding: 12px 16px;
            font-size: 14px;
        }

        .products-table td.center {
            text-align: center;
        }

        .products-table td.right {
            text-align: right;
        }

        .totals-section {
            padding: 24px;
            border-bottom: 1px solid #e5e7eb;
        }

        .totals-container {
            display: flex;
            justify-content: flex-end;
        }

        .totals-box {
            width: 256px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }

        .total-row.final {
            border-top: 1px solid #e5e7eb;
            font-weight: bold;
        }

        .conditions-section {
            padding: 24px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .conditions h2 {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 12px;
        }

        .conditions ul {
            list-style-type: disc;
            padding-left: 20px;
        }

        .conditions li {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .signatures {
            margin-top: 32px;
            padding-top: 32px;
            border-top: 1px solid #e5e7eb;
        }

        .signatures-content {
            display: flex;
            justify-content: space-between;
        }

        .signature-block {
            text-align: center;
        }

        .signature-block p {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .signature-box {
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 8px;
            width: 160px;
            height: 80px;
            margin: 0 auto 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .signature-name {
            font-size: 14px;
            font-weight: 600;
            margin-top: 8px;
        }

        .signature-title {
            font-size: 12px;
            color: #6b7280;
        }

        .signature-line {
            border-top: 1px solid #9ca3af;
            width: 160px;
            margin-top: 40px;
        }

        .footer {
            background-color: #f9fafb;
            padding: 16px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }

        .footer p {
            margin-bottom: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- En-tête -->
        <div class="header">
            <div class="header-content">
                <div>
                    <img src="{{ $supplier['logo'] }}" alt="{{ $supplier['name'] }} Logo" class="logo">
                </div>
                <div class="header-right">
                    <h1>BON DE COMMANDE</h1>
                    <p>N° {{ $orderNumber }}</p>
                    <p>Date: {{ $orderDate }}</p>
                </div>
            </div>
        </div>

        <!-- Informations client et vendeur -->
        <div class="info-section">
            <div class="info-block">
                <h2>Fournisseur:</h2>
                <p>{{ $supplier['name'] }}</p>
                <p>{{ $supplier['address'] }}</p>
                <p>{{ $supplier['city'] }}</p>
                <p>Tél: {{ $supplier['phone'] }}</p>
                <p>Email: {{ $supplier['email'] }}</p>
            </div>
            <div class="info-block">
                <h2>Client:</h2>
                <p>{{ $client['name'] }}</p>
                <p>{{ $client['address'] }}</p>
                <p>{{ $client['city'] }}</p>
                <p>Tél: {{ $client['phone'] }}</p>
                <p>Email: {{ $client['email'] }}</p>
            </div>
        </div>

        <!-- Tableau des produits -->
        <div class="products-section">
            <table class="products-table">
                <thead>
                    <tr>
                        <th>Réf.</th>
                        <th>Description</th>
                        <th class="center">Quantité</th>
                        <th class="right">Prix Unitaire (DA)</th>
                        <th class="right">Montant (DA)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item['ref'] }}</td>
                            <td>{{ $item['description'] }}</td>
                            <td class="center">{{ $item['quantity'] }}</td>
                            <td class="right">{{ $item['unit_price'] }}</td>
                            <td class="right">{{ $item['total'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Récapitulatif -->
        <div class="totals-section">
            <div class="totals-container">
                <div class="totals-box">
                    <div class="total-row">
                        <span>Sous-total:</span>
                        <span>{{ $totals['subtotal'] }}</span>
                    </div>
                    <div class="total-row">
                        <span>TVA (19%):</span>
                        <span>{{ $totals['tva'] }}</span>
                    </div>
                    <div class="total-row final">
                        <span>Total:</span>
                        <span>{{ $totals['total'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conditions et signatures -->
        <div class="conditions-section">
            <div class="conditions">
                <h2>Conditions:</h2>
                <ul>
                    @foreach($conditions as $condition)
                        <li>{{ $condition }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="signatures">
                <div class="signatures-content">
                    <div class="signature-block">
                        <p>Signature du fournisseur</p>
                        <div class="signature-box">
                            <svg viewBox="0 0 200 50" width="120" height="30">
                                <path
                                    d="M10,30 C20,10 30,40 40,20 C50,10 60,30 70,20 C80,10 90,30 100,20 C110,10 120,30 130,20 C140,10 150,30 160,20 C170,10 180,30 190,20"
                                    fill="none" stroke="#000" stroke-width="1.5" />
                            </svg>
                        </div>
                        <div class="signature-name">Mohammed Karim</div>
                        <div class="signature-title">Directeur Commercial</div>
                    </div>
                    <div class="signature-block">
                        <p>Signature du client</p>
                        <div class="signature-line"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <p>{{ $supplier['name'] }} - RC: 16/00-1234567B18 - NIF: 16123456789</p>
            <p>{{ $supplier['address'] }}, {{ $supplier['city'] }}, Algérie</p>
        </div>
    </div>
</body>

</html>