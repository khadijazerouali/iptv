<script>
// JavaScript pour la navigation des sections
function showSection(sectionName) {
    // Masquer toutes les sections
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => {
        section.style.display = 'none';
        section.classList.remove('active');
    });
    
    // Afficher la section sélectionnée
    const targetSection = document.getElementById(sectionName);
    if (targetSection) {
        targetSection.style.display = 'block';
        targetSection.classList.add('active');
    }
    
    // Mettre à jour les liens actifs
    const links = document.querySelectorAll('.sidebar-link');
    links.forEach(link => {
        link.classList.remove('active');
    });
    
    // Ajouter la classe active au lien cliqué
    const activeLink = document.querySelector(`[data-section="${sectionName}"]`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
}

// Afficher la section profil par défaut au chargement
document.addEventListener('DOMContentLoaded', function() {
    showSection('profile');
});

// Fonction pour afficher les détails d'une commande (redirection vers la page dédiée)
function showOrderDetails(subscriptionUuid) {
    // Rediriger vers la page de détails de la commande
    window.location.href = '/order/' + subscriptionUuid;
}

// Fonction pour télécharger une facture
function downloadInvoice(subscriptionUuid) {
    // Afficher un message de chargement
    const loadingToast = showToast('Génération de la facture en cours...', 'info');
    
    // Simuler le téléchargement (remplacez par votre logique réelle)
    setTimeout(() => {
        loadingToast.remove();
        
        const link = document.createElement('a');
        link.href = '#'; // Remplacez par l'URL de votre API
        link.download = `facture-commande-${subscriptionUuid}.pdf`;
        link.textContent = 'Télécharger';
        
        // Pour la démo, on affiche juste un message
        showToast(`Facture pour la commande #${subscriptionUuid} téléchargée avec succès !`, 'success');
        
    
    }, 2000);
}

// Fonction pour contacter le support
function contactSupport(subscriptionUuid) {
    const modal = createModal('Contacter le support', 'support-modal');
    const modalContent = `
        <form id="support-form">
            <div class="form-group">
                <label for="support-subject">Sujet :</label>
                <input type="text" id="support-subject" class="form-control" value="Problème avec la commande #${subscriptionUuid}" required>
            </div>
            <div class="form-group">
                <label for="support-message">Message :</label>
                <textarea id="support-message" class="form-control" rows="4" placeholder="Décrivez votre problème..." required></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Envoyer</button>
                <button type="button" onclick="closeModal()" class="btn btn-secondary">Annuler</button>
            </div>
        </form>
    `;
    
    showModal(modal, modalContent);
    
    // Gérer la soumission du formulaire
    document.getElementById('support-form').onsubmit = function(e) {
        e.preventDefault();
        const subject = document.getElementById('support-subject').value;
        const message = document.getElementById('support-message').value;
        
        // Ici vous enverriez les données à votre backend
        // fetch('/support/tickets', { method: 'POST', ... })
        
        closeModal();
        showToast('Ticket de support créé avec succès !', 'success');
    };
}

// Utilitaires pour les modals
function createModal(title, id) {
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.id = id;
    modal.innerHTML = `
        <div class="modal-content">
            <div class="modal-header">
                <h3>${title}</h3>
                <button onclick="closeModal()" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Le contenu sera injecté ici -->
            </div>
        </div>
    `;
    return modal;
}

function showModal(modal, content) {
    modal.querySelector('.modal-body').innerHTML = content;
    document.body.appendChild(modal);
    setTimeout(() => modal.classList.add('active'), 10);
}

function closeModal() {
    const modals = document.querySelectorAll('.modal-overlay');
    modals.forEach(modal => {
        modal.classList.remove('active');
        setTimeout(() => modal.remove(), 300);
    });
}

// Utilitaires pour les toasts
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <span>${message}</span>
        <button onclick="this.parentElement.remove()">&times;</button>
    `;
    
    // Ajouter au DOM
    let toastContainer = document.querySelector('.toast-container');
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.className = 'toast-container';
        document.body.appendChild(toastContainer);
    }
    
    toastContainer.appendChild(toast);
    
    // Auto-suppression après 5 secondes
    setTimeout(() => {
        if (toast.parentElement) {
            toast.remove();
        }
    }, 5000);
    
    return toast;
}

// Amélioration de l'expérience utilisateur
document.addEventListener('DOMContentLoaded', function() {
    // Ajouter des animations aux cartes
    const cards = document.querySelectorAll('.card');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });
    
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
    
    // Améliorer l'accessibilité
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    sidebarLinks.forEach(link => {
        link.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const section = this.getAttribute('data-section');
                if (section) {
                    showSection(section);
                }
            }
        });
    });
});
</script> 