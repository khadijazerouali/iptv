<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport d'envoi de code promo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
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
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            position: relative;
            z-index: 1;
        }
        
        .header h1 {
            color: white;
            font-size: 24px;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        
        .header p {
            color: rgba(255,255,255,0.9);
            font-size: 16px;
            position: relative;
            z-index: 1;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .report-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }
        
        .report-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .report-title i {
            margin-right: 10px;
            color: #667eea;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stat-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e9ecef;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            display: block;
        }
        
        .stat-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .promo-details {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
        }
        
        .promo-details h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f1f3f4;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 500;
            color: #6c757d;
        }
        
        .detail-value {
            font-weight: 600;
            color: #333;
        }
        
        .errors-section {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .errors-section h4 {
            color: #856404;
            margin-bottom: 15px;
            font-size: 16px;
        }
        
        .error-item {
            background: white;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 8px;
            border-left: 3px solid #dc3545;
            font-size: 14px;
            color: #721c24;
        }
        
        .footer {
            background: #f8f9fa;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        
        .footer p {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        
        .footer-link {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
        }
        
        .footer-link:hover {
            text-decoration: underline;
        }
        
        .success-badge {
            background: #d4edda;
            color: #155724;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .warning-badge {
            background: #fff3cd;
            color: #856404;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }
        
        @media (max-width: 600px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .detail-row {
                flex-direction: column;
                gap: 5px;
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
            <div class="logo">IPTV</div>
            <h1>📧 Rapport d'envoi de code promo</h1>
            <p>Rapport détaillé de l'envoi du code promo</p>
        </div>
        
        <div class="content">
            <div class="report-card">
                <div class="report-title">
                    <i>📊</i>
                    Résumé de l'envoi
                </div>
                
                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-number">{{ $sentCount }}</span>
                        <span class="stat-label">Emails envoyés</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $totalUsers }}</span>
                        <span class="stat-label">Utilisateurs ciblés</span>
                    </div>
                </div>
                
                @if($sentCount == $totalUsers)
                    <div class="success-badge">✅ Tous les emails ont été envoyés avec succès</div>
                @else
                    <div class="warning-badge">⚠️ {{ $totalUsers - $sentCount }} email(s) non envoyé(s)</div>
                @endif
            </div>
            
            <div class="promo-details">
                <h3>📋 Détails du code promo</h3>
                <div class="detail-row">
                    <span class="detail-label">Nom :</span>
                    <span class="detail-value">{{ $promoCode->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Code :</span>
                    <span class="detail-value"><strong>{{ $promoCode->code }}</strong></span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Type de réduction :</span>
                    <span class="detail-value">
                        @if($promoCode->discount_type === 'percentage')
                            {{ $promoCode->discount_value }}%
                        @else
                            {{ number_format($promoCode->discount_value, 2) }}€
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Limite d'usage :</span>
                    <span class="detail-value">{{ $promoCode->usage_limit }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Utilisations actuelles :</span>
                    <span class="detail-value">{{ $promoCode->used_count }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Statut :</span>
                    <span class="detail-value">
                        @if($promoCode->is_active)
                            <span class="success-badge">Actif</span>
                        @else
                            <span class="warning-badge">Inactif</span>
                        @endif
                    </span>
                </div>
            </div>
            
            <div class="promo-details">
                <h3>👤 Informations de l'administrateur</h3>
                <div class="detail-row">
                    <span class="detail-label">Administrateur :</span>
                    <span class="detail-value">{{ $admin->name ?? 'Admin' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email :</span>
                    <span class="detail-value">{{ $admin->email ?? 'admin@admin.com' }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Date d'envoi :</span>
                    <span class="detail-value">{{ now()->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            
            @if(!empty($errors))
                <div class="errors-section">
                    <h4>❌ Erreurs rencontrées</h4>
                    @foreach($errors as $error)
                        <div class="error-item">
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        
        <div class="footer">
            <p>Ce rapport a été généré automatiquement par le système IPTV</p>
            <div class="footer-links">
                <a href="{{ url('/admin/promo-codes') }}" class="footer-link">Gérer les codes promo</a>
                <a href="{{ url('/admin') }}" class="footer-link">Tableau de bord admin</a>
            </div>
        </div>
    </div>
</body>
</html> 