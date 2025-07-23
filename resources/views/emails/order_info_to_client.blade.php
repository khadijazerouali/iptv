<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Confirmation de votre commande</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f7f7f7; margin:0; padding:0;">
    <div style="max-width: 600px; margin: 30px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #eee; overflow: hidden;">
        <div style="background: #222; padding: 20px; text-align: center;">
            <img src="https://votresite.com/assets/images/logo.png" alt="Logo" style="max-height: 60px;">
        </div>
        <div style="padding: 30px;">
            <h2 style="color: #222;">Merci pour votre commande !</h2>
            <p>Bonjour <strong>{{ $user->name ?? ($user['nom'] ?? '-') }}</strong>,</p>
            <p>Nous avons bien reçu votre commande. Voici un récapitulatif :</p>
            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <tr style="background: #f0f0f0;">
                    <th style="padding: 10px; border: 1px solid #ddd;">Produit</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Prix</th>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $product->name ?? $product['name'] ?? '-' }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $product->price ?? $product['price'] ?? '-' }} €</td>
                </tr>
            </table>
            <h3>Détails de la commande</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Appareil (Device ID)</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $cart['device_id'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Clé d'appareil</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $cart['device_key'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Adresse MAC</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $cart['macaddress'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Formuler MAC</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $cart['formulermac'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Smart STB MAC</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $cart['smartstbmac'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">VODs</td>
                    <td style="padding: 8px; border: 1px solid #eee;">
                        {{ is_array($cart['vods'] ?? null) ? implode(', ', $cart['vods']) : ($cart['vods'] ?? '-') }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Bouquets</td>
                    <td style="padding: 8px; border: 1px solid #eee;">
                        {{ is_array($cart['channels'] ?? null) ? implode(', ', $cart['channels']) : ($cart['channels'] ?? '-') }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Durée</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $cart['selectedOptionName'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Quantité</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $cart['quantity'] ?? '-' }}</td>
                </tr>
            </table>
            <h3>Vos informations</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Nom</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $user->name ?? ($user['nom'] ?? '-') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Email</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $user->email ?? ($user['email'] ?? '-') }}</td>
                </tr>
            </table>
            <p style="margin-top: 30px;">Nous restons à votre disposition pour toute question.<br>Merci de votre confiance !</p>
        </div>
        <div style="background: #222; color: #fff; text-align: center; padding: 15px;">
            &copy; {{ date('Y') }} VotreSite.com
        </div>
    </div>
</body>
</html>
