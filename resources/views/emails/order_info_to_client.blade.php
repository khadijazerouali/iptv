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
            
            <h3 style="margin-top: 30px;">Détails de la formation</h3>
            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <tr style="background: #f0f0f0;">
                    <th style="padding: 10px; border: 1px solid #ddd;">Formation</th>
                    <th style="padding: 10px; border: 1px solid #ddd;">Prix</th>
                </tr>
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $product->title ?? $product->name ?? '-' }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ number_format($product->price ?? 0, 2) }} €</td>
                </tr>
            </table>
            
            <h3 style="margin-top: 30px;">Détails de la commande</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Numéro de commande</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $subscription->number_order ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Date de début</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $subscription->start_date ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Date de fin</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $subscription->end_date ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Quantité</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $subscription->quantity ?? ($cart['quantity'] ?? '-') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Statut</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $subscription->status ?? '-' }}</td>
                </tr>
            </table>

            @if($formiptv)
            <h3 style="margin-top: 30px;">Configuration IPTV</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Durée</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $formiptv->duration ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Appareil</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $formiptv->device ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Application</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $formiptv->application ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">VODs</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $formiptv->vods ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Chaînes</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $formiptv->channels ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Adresse MAC</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $formiptv->mac_address ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Device ID</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $formiptv->device_id ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Device Key</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $formiptv->device_key ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Formuler MAC</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $formiptv->formuler_mac ?? '-' }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">MAG Adresse</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $formiptv->mag_adresse ?? '-' }}</td>
                </tr>
            </table>
            @endif

            <h3 style="margin-top: 30px;">Vos informations</h3>
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
