<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture {{ $subscription->number_order }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 20px;
        }
        .company-info {
            float: left;
            width: 50%;
        }
        .invoice-info {
            float: right;
            width: 40%;
            text-align: right;
        }
        .clear {
            clear: both;
        }
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 10px;
        }
        .invoice-number {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .date {
            margin-bottom: 5px;
        }
        .client-info {
            margin-bottom: 30px;
        }
        .client-title {
            font-weight: bold;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background-color: #667eea;
            color: white;
            padding: 10px;
            text-align: left;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .total-row {
            font-weight: bold;
            background-color: #f8f9fa;
        }
        .total-amount {
            font-size: 18px;
            color: #667eea;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-info">
            <h1 style="color: #667eea; margin: 0;">IPTV PREMIUM</h1>
            <p style="margin: 5px 0;">abonnement-iptvpremium.com</p>
            <p style="margin: 5px 0;">Support: support@iptvpremium.com</p>
        </div>
        <div class="invoice-info">
            <div class="invoice-title">FACTURE</div>
            <div class="invoice-number">N° {{ $subscription->number_order }}</div>
            <div class="date">Date: {{ $subscription->created_at->format('d/m/Y') }}</div>
        </div>
        <div class="clear"></div>
    </div>

    <div class="client-info">
        <div class="client-title">Client:</div>
        <div>{{ $user->name }}</div>
        <div>{{ $user->email }}</div>
        @if($user->telephone)
            <div>Téléphone: {{ $user->telephone }}</div>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Durée</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $subscription->product->title ?? 'Abonnement IPTV' }}</td>
                <td>
                    @if($subscription->formiptvs && $subscription->formiptvs->count() > 0)
                        {{ $subscription->formiptvs->first()->duration ?? 'Standard' }}
                    @else
                        Standard
                    @endif
                </td>
                <td>
                    @if($subscription->hasPromoCode())
                        <div style="text-align: center;">
                            <div style="text-decoration: line-through; color: #999; font-size: 11px;">
                                {{ number_format($subscription->product->price ?? 0, 2) }}€
                            </div>
                            <div style="color: #28a745; font-weight: bold;">
                                {{ number_format($subscription->final_price / $subscription->quantity, 2) }}€
                            </div>
                        </div>
                    @else
                        {{ number_format($subscription->product->price ?? 0, 2) }}€
                    @endif
                </td>
                <td>{{ $subscription->quantity }}</td>
                <td>
                    @if($subscription->hasPromoCode())
                        <div style="text-align: center;">
                            <div style="text-decoration: line-through; color: #999; font-size: 11px;">
                                {{ number_format(($subscription->product->price ?? 0) * $subscription->quantity, 2) }}€
                            </div>
                            <div style="color: #28a745; font-weight: bold;">
                                {{ number_format($subscription->final_price, 2) }}€
                            </div>
                        </div>
                    @else
                        {{ number_format(($subscription->product->price ?? 0) * $subscription->quantity, 2) }}€
                    @endif
                </td>
            </tr>
        </tbody>
        <tfoot>
            @if($subscription->hasPromoCode())
                <tr style="background-color: #f8f9fa;">
                    <td colspan="4" style="text-align: right; padding: 8px;">
                        <strong>Sous-total:</strong>
                    </td>
                    <td style="padding: 8px;">
                        {{ number_format($subscription->subtotal, 2) }}€
                    </td>
                </tr>
                <tr style="background-color: #d4edda;">
                    <td colspan="4" style="text-align: right; padding: 8px;">
                        <strong>Réduction ({{ $subscription->promo_code }}):</strong>
                    </td>
                    <td style="padding: 8px; color: #28a745;">
                        -{{ number_format($subscription->discount_amount, 2) }}€
                    </td>
                </tr>
            @endif
            <tr class="total-row">
                <td colspan="4" style="text-align: right;">Total:</td>
                <td class="total-amount">
                    @if($subscription->hasPromoCode())
                        <div style="text-align: center;">
                            <div style="text-decoration: line-through; color: #999; font-size: 14px;">
                                {{ number_format($subscription->subtotal, 2) }}€
                            </div>
                            <div style="color: #28a745; font-weight: bold; font-size: 18px;">
                                {{ number_format($subscription->final_price, 2) }}€
                            </div>
                        </div>
                    @else
                        {{ number_format(($subscription->product->price ?? 0) * $subscription->quantity, 2) }}€
                    @endif
                </td>
            </tr>
        </tfoot>
    </table>

    @if($subscription->note)
    <div style="margin-bottom: 20px;">
        <strong>Note:</strong><br>
        {{ $subscription->note }}
    </div>
    @endif

    <div class="footer">
        <p>Merci pour votre confiance !</p>
        <p>Pour toute question, contactez-nous à support@iptvpremium.com</p>
        <p>Facture générée automatiquement le {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>
</html> 