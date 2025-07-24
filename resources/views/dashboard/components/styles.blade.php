<style>
/* Styles de base pour le dashboard */
.dashboard-container {
    display: flex;
    min-height: calc(100vh - 200px); /* Ajuster pour la nav et footer */
    background-color: #f8fafc;
    position: relative;
    margin: 0;
    padding: 0;
    width: 100%;
}

/* Sidebar styles - Positionnée à côté */
.sidebar {
    width: 280px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    position: relative;
    height: auto;
    min-height: calc(100vh - 200px);
    z-index: 1000;
    overflow-y: auto;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    flex-shrink: 0;
    order: 1; /* Sidebar en premier */
}

.sidebar-header {
    padding: 2rem 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(255, 255, 255, 0.05);
}

.sidebar-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin: 0 0 0.5rem 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.user-welcome {
    font-size: 0.9rem;
    opacity: 0.9;
    font-weight: 500;
}

.sidebar-menu {
    list-style: none;
    padding: 1rem 0;
    margin: 0;
}

.sidebar-item {
    margin: 0;
}

.sidebar-link {
    display: flex;
    align-items: center;
    padding: 1rem 1.5rem;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
    border-left: 3px solid transparent;
    margin: 0.25rem 0;
}

.sidebar-link:hover {
    background: rgba(255, 255, 255, 0.1);
    border-left-color: rgba(255, 255, 255, 0.5);
    transform: translateX(5px);
}

.sidebar-link.active {
    background: rgba(255, 255, 255, 0.15);
    border-left-color: white;
    box-shadow: inset 0 0 20px rgba(255, 255, 255, 0.1);
}

.sidebar-icon {
    margin-right: 0.75rem;
    font-size: 1.2rem;
    width: 24px;
    text-align: center;
}

/* Main content - Positionné à côté de la sidebar */
.main-content {
    flex: 1;
    padding: 2rem;
    background: #f8fafc;
    min-height: calc(100vh - 200px);
    transition: all 0.3s ease;
    order: 2; /* Contenu en second */
    width: calc(100% - 280px); /* Largeur calculée */
}

/* Content sections */
.content-section {
    display: none;
    animation: fadeIn 0.3s ease;
}

.content-section.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.section-header {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #e2e8f0;
}

.section-title {
    font-size: 2.2rem;
    font-weight: bold;
    color: #2d3748;
    margin: 0 0 0.5rem 0;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.section-subtitle {
    color: #718096;
    margin: 0;
    font-size: 1.1rem;
}

/* Cards et grilles - Amélioré */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
    margin-top: 1rem;
}

.card, .info-card {
    background: white;
    border-radius: 16px;
    padding: 1.8rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.card:hover, .info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2);
}

.card-title {
    font-size: 1.3rem;
    font-weight: bold;
    color: #2d3748;
    margin: 0 0 1.2rem 0;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid #f1f5f9;
}

.card-meta {
    color: #64748b;
    font-size: 0.95rem;
    margin-bottom: 1.2rem;
    line-height: 1.6;
}

.card-description {
    color: #4a5568;
    line-height: 1.7;
    margin-bottom: 1rem;
}

/* Forms - Amélioré */
.form-group {
    margin-bottom: 1.8rem;
}

.form-group label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.form-control {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: #fafbfc;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: white;
}

.form-control.is-invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.invalid-feedback {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    font-weight: 500;
}

.form-text {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 0.5rem;
}

/* Buttons - Amélioré */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.875rem 1.5rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-decoration: none;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    font-size: 0.95rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn:hover::before {
    left: 100%;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.btn-secondary {
    background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
    box-shadow: 0 4px 15px rgba(113, 128, 150, 0.3);
}

.btn-secondary:hover {
    box-shadow: 0 6px 20px rgba(113, 128, 150, 0.4);
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
}

.btn-danger:hover {
    box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
}

/* Empty states - Amélioré */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #718096;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 2px dashed #e2e8f0;
}

.empty-state-icon {
    font-size: 5rem;
    margin-bottom: 1.5rem;
    opacity: 0.7;
}

.empty-state h3 {
    color: #4a5568;
    margin-bottom: 0.75rem;
    font-size: 1.5rem;
}

.empty-state p {
    font-size: 1.1rem;
    opacity: 0.8;
}

/* Alerts - Amélioré */
.alert {
    padding: 1.2rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    border-left: 4px solid;
    font-weight: 500;
}

.alert-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
    border-left-color: #059669;
}

.alert-error {
    background: linear-gradient(135deg, #fee2e2 0%, #fca5a5 100%);
    color: #991b1b;
    border-left-color: #ef4444;
}

/* Prix - Amélioré */
.price {
    font-weight: bold;
    color: #059669;
    font-size: 1.1rem;
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    display: inline-block;
}

/* Styles pour les informations de formation - Amélioré */
.formation-info {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 1.2rem;
    border-radius: 12px;
    margin-bottom: 1.2rem;
    border-left: 4px solid #667eea;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
}

.formation-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #2d3748;
    margin: 0 0 0.75rem 0;
}

.formation-meta {
    display: flex;
    gap: 1rem;
    align-items: center;
    flex-wrap: wrap;
}

.formation-price {
    font-weight: bold;
    color: #059669;
    font-size: 1.1rem;
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
}

.formation-category {
    background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
    color: #4a5568;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

/* Responsive design - Corrigé pour mobile */
@media (max-width: 1200px) {
    .grid {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }
}

@media (max-width: 1024px) {
    .sidebar {
        width: 250px;
    }
    
    .main-content {
        width: calc(100% - 250px);
    }
    
    .grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.2rem;
    }
}

@media (max-width: 768px) {
    .dashboard-container {
        flex-direction: column;
        min-height: auto;
    }
    
    .sidebar {
        display: none; /* Complètement cachée en mobile */
        width: 100%;
        height: auto;
        min-height: auto;
        order: 2;
    }
    
    .main-content {
        width: 100%;
        padding: 1rem;
        order: 1;
    }
    
    .grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
    
    .card, .info-card {
        padding: 1.5rem;
    }
}

@media (max-width: 480px) {
    .main-content {
        padding: 0.75rem;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
    
    .card, .info-card {
        padding: 1.2rem;
        border-radius: 12px;
    }
    
    .formation-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .btn {
        padding: 0.75rem 1.2rem;
        font-size: 0.9rem;
    }
}

/* Styles pour les modals - Amélioré */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    z-index: 2000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    backdrop-filter: blur(5px);
}

.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.modal-content {
    background: white;
    border-radius: 16px;
    max-width: 600px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    transform: scale(0.9) translateY(20px);
    transition: all 0.3s ease;
}

.modal-overlay.active .modal-content {
    transform: scale(1) translateY(0);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-radius: 16px 16px 0 0;
}

.modal-header h3 {
    margin: 0;
    color: #2d3748;
    font-weight: bold;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #718096;
    padding: 0.5rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.modal-close:hover {
    color: #4a5568;
    background: rgba(0, 0, 0, 0.05);
}

.modal-body {
    padding: 1.5rem;
}

/* Styles pour les toasts - Amélioré */
.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 3000;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.toast {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    min-width: 320px;
    animation: slideIn 0.3s ease;
    backdrop-filter: blur(10px);
}

.toast-info {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
    border-left: 4px solid #3b82f6;
}

.toast-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
    border-left: 4px solid #059669;
}

.toast-error {
    background: linear-gradient(135deg, #fee2e2 0%, #fca5a5 100%);
    color: #991b1b;
    border-left: 4px solid #ef4444;
}

.toast button {
    background: none;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
    margin-left: 1rem;
    opacity: 0.7;
    transition: opacity 0.3s ease;
}

.toast button:hover {
    opacity: 1;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Styles pour les formulaires dans les modals */
.form-actions {
    margin-top: 1.5rem;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

textarea.form-control {
    resize: vertical;
    min-height: 120px;
}

/* Améliorations supplémentaires */
.card ul {
    margin: 0.5rem 0;
    padding-left: 1.5rem;
}

.card li {
    margin-bottom: 0.25rem;
    color: #4a5568;
}

/* Animation pour les cartes */
.card {
    animation: cardSlideIn 0.5s ease;
}

@keyframes cardSlideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Scrollbar personnalisée pour la sidebar */
.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

.sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 3px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}
</style> 