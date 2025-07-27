<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue sur IPTV Service</title>
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
            background: linear-gradient(135deg, #6366f1, #4f46e5, #8b5cf6);
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
        
        .welcome-message {
            margin-bottom: 30px;
            color: #4b5563;
            font-size: 1.1rem;
        }
        
        .features {
            background: #f8fafc;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
        }
        
        .features h3 {
            color: #1f2937;
            margin-bottom: 20px;
            font-size: 1.2rem;
        }
        
        .feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .feature-list li {
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
        }
        
        .feature-list li:last-child {
            border-bottom: none;
        }
        
        .feature-list li::before {
            content: '✓';
            color: #10b981;
            font-weight: bold;
            margin-right: 12px;
            font-size: 1.1rem;
        }
        
        .cta-button {
            display: inline-block;
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            margin: 30px 0;
            text-align: center;
            transition: transform 0.2s;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
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
            color: #6366f1;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .footer-link:hover {
            text-decoration: underline;
        }
        
        .account-info {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        
        .account-info h4 {
            color: #0369a1;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0f2fe;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 500;
            color: #0c4a6e;
        }
        
        .info-value {
            font-weight: 600;
            color: #0369a1;
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
            <h1 class="title">🎉 Bienvenue sur IPTV Service !</h1>
            <p class="subtitle">Votre service de streaming premium</p>
        </div>
        
        <div class="content">
            <h2 class="greeting">Bonjour {{ $user->name }} !</h2>
            
            <p class="welcome-message">
                Nous sommes ravis de vous accueillir sur IPTV Service ! Votre compte a été créé avec succès et vous avez maintenant accès à notre plateforme de streaming premium.
            </p>
            
            <div class="account-info">
                <h4>📋 Informations de votre compte</h4>
                <div class="info-row">
                    <span class="info-label">Nom d'utilisateur :</span>
                    <span class="info-value">{{ $user->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Adresse email :</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date de création :</span>
                    <span class="info-value">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            
            <div class="features">
                <h3>🚀 Ce que vous pouvez faire maintenant :</h3>
                <ul class="feature-list">
                    <li>Accéder à des milliers de chaînes TV en direct</li>
                    <li>Regarder vos films et séries préférés</li>
                    <li>Profiter d'une qualité 4K Ultra HD</li>
                    <li>Utiliser l'appareil de votre choix</li>
                    <li>Bénéficier d'un support client 24/7</li>
                </ul>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ url('/dashboard') }}" class="cta-button">
                    🎬 Accéder à mon tableau de bord
                </a>
            </div>
            
            <p style="color: #6b7280; font-size: 0.9rem; text-align: center; margin-top: 20px;">
                Si vous avez des questions, n'hésitez pas à contacter notre équipe de support.
            </p>
        </div>
        
        <div class="footer">
            <p>Merci de nous faire confiance pour votre divertissement !</p>
            <div class="footer-links">
                <a href="{{ url('/support') }}" class="footer-link">Support client</a>
                <a href="{{ url('/contact') }}" class="footer-link">Nous contacter</a>
                <a href="{{ url('/terms') }}" class="footer-link">Conditions d'utilisation</a>
            </div>
        </div>
    </div>
</body>
</html> 