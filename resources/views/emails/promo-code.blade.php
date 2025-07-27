<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code promo spécial - IPTV Service</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #f59e0b, #d97706, #b45309);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .logo {
            position: relative;
            z-index: 1;
            width: 120px;
            height: 80px;
            margin: 0 auto 20px;
            display: block;
        }
        
        .title {
            position: relative;
            z-index: 1;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .subtitle {
            position: relative;
            z-index: 1;
            font-size: 1.1rem;
            opacity: 0.95;
            margin-bottom: 0;
        }
        
        .content {
            padding: 50px 30px;
        }
        
        .greeting {
            font-size: 1.4rem;
            margin-bottom: 25px;
            color: #1f2937;
            font-weight: 600;
        }
        
        .message {
            margin-bottom: 30px;
            color: #4b5563;
            font-size: 1.1rem;
        }
        
        .promo-card {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border: 2px solid #f59e0b;
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .promo-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shine 3s infinite;
        }
        
        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }
        
        .promo-code {
            font-size: 2.5rem;
            font-weight: bold;
            color: #92400e;
            margin: 20px 0;
            font-family: 'Courier New', monospace;
            letter-spacing: 3px;
            position: relative;
            z-index: 1;
        }
        
        .promo-title {
            font-size: 1.3rem;
            color: #92400e;
            margin-bottom: 15px;
            font-weight: 600;
            position: relative;
            z-index: 1;
        }
        
        .promo-description {
            color: #92400e;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }
        
        .discount-info {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            position: relative;
            z-index: 1;
        }
        
        .discount-amount {
            font-size: 1.8rem;
            font-weight: bold;
            color: #dc2626;
            margin-bottom: 5px;
        }
        
        .discount-type {
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            text-decoration: none;
            padding: 18px 35px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            margin: 30px 0;
            text-align: center;
            transition: transform 0.2s;
            position: relative;
            z-index: 1;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
        }
        
        .terms {
            background: #f3f4f6;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .terms h4 {
            color: #374151;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        
        .terms ul {
            margin: 0;
            padding-left: 20px;
            color: #6b7280;
        }
        
        .terms li {
            margin-bottom: 8px;
        }
        
        .footer {
            background: #f8fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .footer p {
            color: #6b7280;
            margin-bottom: 15px;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        
        .footer-link {
            color: #f59e0b;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .footer-link:hover {
            text-decoration: underline;
        }
        
        .expiry-notice {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            color: #dc2626;
            font-size: 0.9rem;
        }
        
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 10px;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .content {
                padding: 30px 20px;
            }
            
            .promo-code {
                font-size: 2rem;
                letter-spacing: 2px;
            }
            
            .footer-links {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ url('/assets/images/Logo.png') }}" alt="IPTV Logo" class="logo">
            <h1 class="title">🎫 Code promo spécial !</h1>
            <p class="subtitle">IPTV Service - Offre exclusive</p>
        </div>
        
        <div class="content">
            <h2 class="greeting">Bonjour {{ $user->name }} !</h2>
            
            <p class="message">
                Nous avons une offre spéciale pour vous ! Profitez de notre code promo exclusif pour économiser sur votre abonnement IPTV.
            </p>
            
            <div class="promo-card">
                <div class="promo-title">{{ $promoCode->name }}</div>
                <div class="promo-description">{{ $promoCode->description }}</div>
                
                <div class="promo-code">{{ $promoCode->code }}</div>
                
                <div class="discount-info">
                    <div class="discount-amount">
                        @if($promoCode->discount_type === 'percentage')
                            -{{ $promoCode->discount_value }}%
                        @else
                            -{{ number_format($promoCode->discount_value, 2) }}€
                        @endif
                    </div>
                    <div class="discount-type">
                        @if($promoCode->discount_type === 'percentage')
                            Réduction en pourcentage
                        @else
                            Réduction en montant fixe
                        @endif
                    </div>
                </div>
                
                @if($promoCode->min_amount)
                    <p style="color: #92400e; font-size: 0.9rem; margin: 10px 0;">
                        Minimum d'achat : {{ number_format($promoCode->min_amount, 2) }}€
                    </p>
                @endif
            </div>
            
            <div style="text-align: center;">
                <a href="{{ url('/checkout') }}" class="cta-button">
                    🛒 Utiliser ce code promo
                </a>
            </div>
            
            @if($promoCode->valid_until)
                <div class="expiry-notice">
                    ⏰ Offre valide jusqu'au {{ $promoCode->valid_until->format('d/m/Y H:i') }}
                </div>
            @endif
            
            <div class="terms">
                <h4>📋 Conditions d'utilisation</h4>
                <ul>
                    <li>Ce code promo est valable pour une utilisation par compte</li>
                    <li>Non cumulable avec d'autres offres en cours</li>
                    <li>Valable sur les nouveaux abonnements uniquement</li>
                    <li>L'offre peut être modifiée ou retirée à tout moment</li>
                    @if($promoCode->usage_limit)
                        <li>Limite d'utilisation : {{ $promoCode->usage_limit }} fois</li>
                    @endif
                </ul>
            </div>
            
            <p style="color: #6b7280; font-size: 0.9rem; text-align: center; margin-top: 20px;">
                Pour toute question concernant cette offre, contactez notre équipe de support.
            </p>
        </div>
        
        <div class="footer">
            <p>Merci de faire confiance à IPTV Service !</p>
            <div class="footer-links">
                <a href="{{ url('/support') }}" class="footer-link">Support client</a>
                <a href="{{ url('/contact') }}" class="footer-link">Nous contacter</a>
                <a href="{{ url('/terms') }}" class="footer-link">Conditions d'utilisation</a>
            </div>
        </div>
    </div>
</body>
</html> 