<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe - IPTV Service</title>
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
            background: linear-gradient(135deg, #dc2626, #b91c1c, #991b1b);
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
        
        .warning-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .warning-box h4 {
            color: #dc2626;
            margin-bottom: 15px;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
        }
        
        .warning-box h4::before {
            content: '⚠️';
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .warning-box ul {
            margin: 0;
            padding-left: 20px;
            color: #7f1d1d;
        }
        
        .warning-box li {
            margin-bottom: 8px;
        }
        
        .reset-button {
            display: inline-block;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            text-decoration: none;
            padding: 18px 35px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            margin: 30px 0;
            text-align: center;
            transition: transform 0.2s;
        }
        
        .reset-button:hover {
            transform: translateY(-2px);
        }
        
        .security-tips {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .security-tips h4 {
            color: #0369a1;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        
        .security-tips ul {
            margin: 0;
            padding-left: 20px;
            color: #0c4a6e;
        }
        
        .security-tips li {
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
            color: #dc2626;
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .footer-link:hover {
            text-decoration: underline;
        }
        
        .expiry-notice {
            background: #fef3c7;
            border: 1px solid #fde68a;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            color: #92400e;
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
            <h1 class="title">🔐 Réinitialisation de mot de passe</h1>
            <p class="subtitle">IPTV Service - Sécurité de votre compte</p>
        </div>
        
        <div class="content">
            <h2 class="greeting">Bonjour {{ $user->name }} !</h2>
            
            <p class="message">
                Nous avons reçu une demande de réinitialisation de mot de passe pour votre compte IPTV Service. Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer cet email en toute sécurité.
            </p>
            
            <div class="warning-box">
                <h4>Important</h4>
                <ul>
                    <li>Ce lien de réinitialisation est valide pendant 60 minutes</li>
                    <li>Ne partagez jamais ce lien avec qui que ce soit</li>
                    <li>Notre équipe ne vous demandera jamais votre mot de passe</li>
                </ul>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ url('/reset-password?token=' . $token . '&email=' . $user->email) }}" class="reset-button">
                    🔑 Réinitialiser mon mot de passe
                </a>
            </div>
            
            <div class="expiry-notice">
                ⏰ Ce lien expirera dans 60 minutes pour des raisons de sécurité.
            </div>
            
            <div class="security-tips">
                <h4>🔒 Conseils de sécurité</h4>
                <ul>
                    <li>Utilisez un mot de passe unique et complexe</li>
                    <li>Activez l'authentification à deux facteurs si disponible</li>
                    <li>Ne réutilisez pas ce mot de passe sur d'autres sites</li>
                    <li>Changez régulièrement votre mot de passe</li>
                </ul>
            </div>
            
            <p style="color: #6b7280; font-size: 0.9rem; text-align: center; margin-top: 20px;">
                Si vous n'avez pas demandé cette réinitialisation, votre compte est en sécurité et aucune action n'est requise.
            </p>
        </div>
        
        <div class="footer">
            <p>Merci de faire confiance à IPTV Service pour la sécurité de votre compte !</p>
            <div class="footer-links">
                <a href="{{ url('/support') }}" class="footer-link">Support client</a>
                <a href="{{ url('/contact') }}" class="footer-link">Nous contacter</a>
                <a href="{{ url('/security') }}" class="footer-link">Sécurité du compte</a>
            </div>
        </div>
    </div>
</body>
</html>