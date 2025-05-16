// Détecter le thème actuel
function getTheme() {
    return document.documentElement.getAttribute('data-theme') || 'dark';
}

// Configuration des couleurs en fonction du thème
function getColors() {
    // Couleurs de base identiques pour les deux thèmes
    const baseColors = {
        primary: '#4F46E5',
        secondary: '#EC4899',
        success: '#10B981',
        info: '#3B82F6',
        warning: '#F59E0B',
        danger: '#EF4444',
        purple: '#8B5CF6',
        pink: '#EC4899',
        indigo: '#6366F1',
        blue: '#3B82F6',
        green: '#10B981',
        yellow: '#F59E0B',
        red: '#EF4444'
    };
    
    // Ajouter les couleurs spécifiques au thème
    const currentTheme = getTheme();
    if (currentTheme === 'light') {
        return {
            ...baseColors,
            gray: '#6B7280',
            textColor: '#1E293B',
            gridColor: 'rgba(0, 0, 0, 0.1)',
            tooltipBackgroundColor: '#FFFFFF'
        };
    } else {
        return {
            ...baseColors, 
            gray: '#9CA3AF',
            textColor: '#F9FAFB',
            gridColor: 'rgba(255, 255, 255, 0.1)',
            tooltipBackgroundColor: '#1F2937'
        };
    }
}

// Obtenir les couleurs en fonction du thème
const colors = getColors();

// Fonction pour créer un dégradé
function createGradient(ctx, startColor, endColor) {
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, startColor);
    gradient.addColorStop(1, endColor);
    return gradient;
}

// 1. Graphique d'évolution des cas signalés
function initEvolutionChart() {
    const evolutionCtx = document.getElementById('evolutionChart');
    if (!evolutionCtx) return;
    
    // Options communes basées sur le thème
    const commonOptions = getCommonOptions();
    
    const months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
    
    new Chart(evolutionCtx, {
        type: 'line',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Cas signalés',
                    data: [450, 520, 480, 680, 750, 850, 920, 890, 940, 1020, 1100, 1230],
                    borderColor: colors.primary,
                    backgroundColor: 'rgba(79, 70, 229, 0.2)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Cas résolus',
                    data: [380, 420, 390, 560, 630, 720, 780, 740, 810, 850, 920, 1050],
                    borderColor: colors.success,
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            ...commonOptions,
            plugins: {
                ...commonOptions.plugins,
                legend: {
                    ...commonOptions.plugins.legend,
                    position: 'top',
                    labels: {
                        ...commonOptions.plugins.legend.labels,
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    ...commonOptions.plugins.tooltip,
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    ...commonOptions.scales.y,
                    beginAtZero: true,
                    grid: {
                        ...commonOptions.scales.y.grid,
                        display: true
                    }
                },
                x: {
                    ...commonOptions.scales.x,
                    grid: {
                        ...commonOptions.scales.x.grid,
                        display: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
}

// 2. Répartition par genre
function initGenderChart() {
    const genderCtx = document.getElementById('genderChart');
    if (!genderCtx) return;
    
    new Chart(genderCtx, {
        type: 'doughnut',
        data: {
            labels: ['Femmes', 'Hommes', 'Non précisé'],
            datasets: [{
                data: [68, 28, 4],
                backgroundColor: [colors.secondary, colors.primary, colors.gray],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.label}: ${context.raw}%`;
                        }
                    }
                }
            },
            cutout: '60%'
        }
    });
}

// 3. Répartition géographique
function initLocationChart() {
    const locationCtx = document.getElementById('locationChart');
    if (!locationCtx) return;
    
    new Chart(locationCtx, {
        type: 'bar',
        data: {
            labels: ['Dakar', 'Thiès', 'Saint-Louis', 'Ziguinchor', 'Louga', 'Autres'],
            datasets: [{
                label: 'Cas signalés par région',
                data: [42, 18, 12, 9, 7, 12],
                backgroundColor: [
                    colors.primary,
                    colors.purple,
                    colors.indigo,
                    colors.blue,
                    colors.info,
                    colors.gray
                ],
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.raw}%`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 50,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    },
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// 4. Types d'incidents
function initIncidentTypeChart() {
    const incidentTypeCtx = document.getElementById('incidentTypeChart');
    if (!incidentTypeCtx) return;
    
    new Chart(incidentTypeCtx, {
        type: 'polarArea',
        data: {
            labels: [
                'Violence physique',
                'Violence psychologique',
                'Violence verbale',
                'Discrimination',
                'Harcèlement'
            ],
            datasets: [{
                data: [35, 27, 20, 10, 8],
                backgroundColor: [
                    colors.danger,
                    colors.warning,
                    colors.info,
                    colors.primary,
                    colors.secondary
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            }
        }
    });
}

// 5. Interventions par organisation
function initOrganisationChart() {
    const organisationCtx = document.getElementById('organisationChart');
    if (!organisationCtx) return;
    
    new Chart(organisationCtx, {
        type: 'bar',
        data: {
            labels: ['ONG Alpha', 'Association Beta', 'Fondation Gamma', 'Institut Delta', 'Autres'],
            datasets: [{
                label: 'Interventions',
                data: [32, 27, 21, 14, 6],
                backgroundColor: colors.success,
                borderRadius: 6
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    max: 40,
                    grid: {
                        display: true,
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                },
                y: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// Fonction pour obtenir les options communes de graphique
function getCommonOptions() {
    const currentTheme = getTheme();
    const colors = getColors();
    return {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                labels: {
                    color: colors.textColor,
                    font: {
                        family: "'Inter', sans-serif"
                    }
                }
            },
            tooltip: {
                backgroundColor: colors.tooltipBackgroundColor,
                titleColor: colors.textColor,
                bodyColor: colors.textColor,
                borderColor: currentTheme === 'dark' ? '#374151' : '#E2E8F0',
                borderWidth: 1,
                padding: 12,
                cornerRadius: 6,
                displayColors: true,
                usePointStyle: true,
                titleFont: {
                    size: 14,
                    weight: 'bold',
                    family: "'Inter', sans-serif"
                },
                bodyFont: {
                    size: 13,
                    family: "'Inter', sans-serif"
                }
            }
        },
        scales: {
            y: {
                grid: {
                    color: colors.gridColor
                },
                ticks: {
                    color: colors.textColor
                }
            },
            x: {
                grid: {
                    color: colors.gridColor
                },
                ticks: {
                    color: colors.textColor
                }
            }
        }
    };
}

// Fonction pour initialiser tous les graphiques
function initAllCharts() {
    console.log('Initializing charts with theme:', getTheme());
    initEvolutionChart();
    initGenderChart();
    initLocationChart();
    initIncidentTypeChart();
    initOrganisationChart();
    console.log('Charts initialized!');
}

// Initialiser les graphiques une fois que la page est chargée
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded');
    
    // S'assurer que Chart.js est chargé
    if (typeof Chart === 'undefined') {
        console.error('Chart.js not loaded!');
        return;
    }
    
    // Initialiser les graphiques
    initAllCharts();
});

// Initialiser aussi lors du chargement complet de la page
window.onload = function() {
    console.log('Window loaded');
    if (typeof Chart !== 'undefined') {
        initAllCharts();
    }
};
