// Gestion du thème clair/sombre pour toutes les pages
document.addEventListener('DOMContentLoaded', function() {
    // Récupérer le thème actuel depuis localStorage ou utiliser par défaut le thème sombre
    const currentTheme = localStorage.getItem('theme') || 'dark';
    
    // Appliquer le thème au chargement
    document.documentElement.setAttribute('data-theme', currentTheme);
    
    // Ajouter le bouton de changement de thème s'il n'existe pas déjà
    if (!document.querySelector('.theme-switcher')) {
        const switcher = document.createElement('div');
        switcher.className = 'theme-switcher';
        switcher.innerHTML = `
            <button class="theme-toggle" aria-label="Changer de thème">
                <i class="fas fa-sun light-icon"></i>
                <i class="fas fa-moon dark-icon"></i>
            </button>
        `;
        document.body.appendChild(switcher);
    }
    
    // Fonction pour changer de thème
    function toggleTheme() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        // Mettre à jour l'attribut sur l'élément HTML
        document.documentElement.setAttribute('data-theme', newTheme);
        
        // Enregistrer la préférence dans localStorage
        localStorage.setItem('theme', newTheme);
        
        // Déclencher un événement personnalisé pour informer d'autres scripts
        const event = new CustomEvent('themeChanged', { 
            detail: { theme: newTheme } 
        });
        window.dispatchEvent(event);
    }
    
    // Ajouter l'écouteur d'événement au bouton
    document.addEventListener('click', function(e) {
        if (e.target.closest('.theme-toggle')) {
            toggleTheme();
        }
    });
    
    // Ajouter les styles pour le bouton s'ils n'existent pas déjà
    if (!document.querySelector('#theme-switcher-styles')) {
        const styleTag = document.createElement('style');
        styleTag.id = 'theme-switcher-styles';
        styleTag.textContent = `
            .theme-switcher {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 9999;
            }
            
            .theme-toggle {
                width: 45px;
                height: 45px;
                border-radius: 50%;
                background: #4F46E5;
                border: none;
                color: white;
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
                transition: transform 0.3s ease;
            }
            
            .theme-toggle:hover {
                transform: translateY(-3px);
            }
            
            [data-theme="dark"] .light-icon {
                display: block;
            }
            
            [data-theme="dark"] .dark-icon {
                display: none;
            }
            
            [data-theme="light"] .light-icon {
                display: none;
            }
            
            [data-theme="light"] .dark-icon {
                display: block;
            }
        `;
        document.head.appendChild(styleTag);
    }
});
