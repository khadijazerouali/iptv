<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Confirmation de votre commande</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f7f7f7; margin:0; padding:0;">
    <div style="max-width: 600px; margin: 30px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #eee; overflow: hidden;">
        <div style="background: #222; padding: 20px; text-align: center;">
            <img src="http://127.0.0.1:8000/assets/images/Logo.png" alt="Logo" style="max-height: 60px;">
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
                    <td style="padding: 10px; border: 1px solid #ddd;">
                        @if($subscription && isset($subscription->promo_code) && $subscription->promo_code)
                            <div style="text-align: center;">
                                <div style="text-decoration: line-through; color: #999; font-size: 14px;">
                                    {{ number_format($subscription->original_price, 2) }}€
                                </div>
                                <div style="color: #28a745; font-weight: bold; font-size: 16px;">
                                    {{ number_format($subscription->final_price, 2) }}€
                                </div>
                                <div style="color: #28a745; font-size: 12px; margin-top: 2px;">
                                    🏷️ Code {{ $subscription->promo_code }} (-{{ number_format($subscription->discount_amount, 2) }}€)
                                </div>
                            </div>
                        @else
                            {{ number_format($product->price ?? 0, 2) }}€
                        @endif
                    </td>
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
                @if($subscription && isset($subscription->promo_code) && $subscription->promo_code)
                <tr style="background-color: #d4edda;">
                    <td style="padding: 8px; border: 1px solid #eee;">Code promo appliqué</td>
                    <td style="padding: 8px; border: 1px solid #eee; color: #28a745;">
                        <strong>{{ $subscription->promo_code }}</strong>
                        @if($subscription->promoCode)
                            <br><small>{{ $subscription->promoCode->name }}</small>
                        @endif
                    </td>
                </tr>
                <tr style="background-color: #d4edda;">
                    <td style="padding: 8px; border: 1px solid #eee;">Économies réalisées</td>
                    <td style="padding: 8px; border: 1px solid #eee; color: #28a745;">
                        <strong>-{{ number_format($subscription->discount_amount, 2) }}€</strong>
                        <br><small>({{ $subscription->discount_percentage }}% de réduction)</small>
                    </td>
                </tr>
                @endif
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
                {{-- <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Adresse MAC</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $formiptv->mac_address ?? '-' }}</td>
                </tr>
                @if($formiptv->formuler_mac)
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">Formuler MAC</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $formiptv->formuler_mac }}</td>
                </tr>
                @endif
                @if($formiptv->mag_adresse)
                <tr>
                    <td style="padding: 8px; border: 1px solid #eee;">MAG Adresse</td>
                    <td style="padding: 8px; border: 1px solid #eee;">{{ $formiptv->mag_adresse }}</td>
                </tr>
                @endif --}}
            </table>
            @endif

            @if($subscription && isset($subscription->formiptvs) && $subscription->formiptvs && $subscription->formiptvs->count() > 0)
            @foreach($subscription->formiptvs as $formiptv)
                @php
                    $applicationType = \App\Models\Applicationtype::where('name', $formiptv->application)->first();
                    $hasFields = false;
                    if ($applicationType) {
                        $hasFields = ($applicationType->deviceid && $formiptv->device_id) ||
                                    ($applicationType->devicekey && $formiptv->device_key) ||
                                    ($applicationType->otpcode && $formiptv->otp_code) ||
                                    ($applicationType->smartstbmac && $formiptv->note);
                    }
                @endphp
                
                @if($hasFields)
                <h3 style="margin-top: 30px;">Configuration spécifique à l'application</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    @if($applicationType && $applicationType->deviceid && $formiptv->device_id)
                    <tr>
                        <td style="padding: 8px; border: 1px solid #eee;">Device ID</td>
                        <td style="padding: 8px; border: 1px solid #eee;">{{ $formiptv->device_id }}</td>
                    </tr>
                    @endif
                    @if($applicationType && $applicationType->devicekey && $formiptv->device_key)
                    <tr>
                        <td style="padding: 8px; border: 1px solid #eee;">Device Key</td>
                        <td style="padding: 8px; border: 1px solid #eee;">{{ $formiptv->device_key }}</td>
                    </tr>
                    @endif
                    @if($applicationType && $applicationType->otpcode && $formiptv->otp_code)
                    <tr>
                        <td style="padding: 8px; border: 1px solid #eee;">OTP Code</td>
                        <td style="padding: 8px; border: 1px solid #eee;">{{ $formiptv->otp_code }}</td>
                    </tr>
                    @endif
                    @if($applicationType && $applicationType->smartstbmac && $formiptv->note)
                    <tr>
                        <td style="padding: 8px; border: 1px solid #eee;">Smart STB MAC</td>
                        <td style="padding: 8px; border: 1px solid #eee;">{{ $formiptv->note }}</td>
                    </tr>
                    @endif
                </table>
                @endif
            @endforeach
            @endif

            @if($subscription && isset($subscription->note) && $subscription->note)
            <h3 style="margin-top: 30px;">Informations Complémentaires</h3>
            <p style="padding: 10px; background: #f9f9f9; border-radius: 4px;">{{ $subscription->note }}</p>
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
<<<<<<< HEAD
            
=======
>>>>>>> e0b1228c2e6aaa4ccf2205a14c6af684ce49080b
            <p style="margin-top: 30px;">Nous restons à votre disposition pour toute question.<br>Merci de votre confiance !</p>
        </div>
        <div style="background: #222; color: #fff; text-align: center; padding: 15px;">
            &copy; {{ date('Y') }} VotreSite.com
        </div>
    </div>
</body>
</html>
