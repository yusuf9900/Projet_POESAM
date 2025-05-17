@extends('layouts.app')

@section('content')
<div class="container-fluid dashboard-container min-vh-100">
    <style>
        /* Styles spécifiques à la page statistiques */
        .dashboard-container {
            background-color: var(--bg-primary);
            color: var(--text-primary);
        }
        
        .card {
            background-color: var(--bg-card);
            border-color: var(--border-color);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }
        
        .card-header {
            background-color: var(--bg-secondary) !important;
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        
        .table {
            color: var(--text-primary);
        }
        
        .breadcrumb-item a {
            color: var(--text-secondary);
        }
        
        .breadcrumb-item.active {
            color: var(--text-primary);
        }
        
        .form-control {
            background-color: var(--bg-secondary);
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        
        .form-control:focus {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
        }
        
        .btn-outline-primary {
            border-color: var(--border-color);
            color: var(--text-primary);
        }
        
        .btn-outline-primary:hover, .btn-outline-primary.active {
            background-color: var(--bg-secondary);
            border-color: #4F46E5;
            color: #4F46E5;
        }
        
        /* Styles pour les tooltips des graphiques en mode sombre */
        #evolutionChart, #genderChart, #locationChart, #incidentTypeChart, #organisationChart {
            color: var(--text-primary) !important;
        }
    </style>
    <div class="row">
        @include('layouts.sidebar', ['userType' => 'admin'])
        
        <!-- Contenu principal -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-3 mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="/admin/dashboard" class="text-decoration-none">Tableau de bord</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Statistiques</li>
                        </ol>
                    </nav>
                    <h2 class="fw-bold">Statistiques</h2>
                </div>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="input-group me-2">
                        <input type="text" class="form-control form-control-sm" placeholder="Rechercher...">
                        <button class="btn btn-sm btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-soft-primary btn-icon"><i class="fas fa-download"></i>Exporter</button>
                        <button type="button" class="btn btn-soft-primary btn-icon"><i class="fas fa-print"></i>Imprimer</button>
                    </div>
                </div>
            </div>
            
            <!-- Filtres de date -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden hover-shadow transition-all">
                        <div class="card-body p-3">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="me-2"><i class="fas fa-filter"></i> Filtrer par période:</span>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-primary active">7 jours</button>
                                        <button type="button" class="btn btn-sm btn-outline-primary">30 jours</button>
                                        <button type="button" class="btn btn-sm btn-outline-primary">6 mois</button>
                                        <button type="button" class="btn btn-sm btn-outline-primary">1 an</button>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="me-2">Dates:</span>
                                    <input type="date" class="form-control form-control-sm me-2" id="start-date">
                                    <span class="me-2">à</span>
                                    <input type="date" class="form-control form-control-sm" id="end-date">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Statistiques générales -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden hover-shadow transition-all">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Évolution des cas signalés</h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Exporter</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-sync me-2"></i>Actualiser</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div style="position: relative; height: 400px;">
                                <canvas id="evolutionChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Graphiques spécifiques -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden hover-shadow transition-all h-100">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Répartition par genre</h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Exporter</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-sync me-2"></i>Actualiser</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div style="position: relative; height: 300px;">
                                <canvas id="genderChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden hover-shadow transition-all h-100">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Répartition géographique</h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Exporter</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-sync me-2"></i>Actualiser</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div style="position: relative; height: 300px;">
                                <canvas id="locationChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden hover-shadow transition-all h-100">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Types d'incidents</h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Exporter</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-sync me-2"></i>Actualiser</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div style="position: relative; height: 300px;">
                                <canvas id="incidentTypeChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden hover-shadow transition-all h-100">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="fas fa-building me-2"></i>Interventions par organisation</h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Exporter</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-sync me-2"></i>Actualiser</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div style="position: relative; height: 300px;">
                                <canvas id="organisationChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Library et scripts externes -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script src="{{ asset('js/charts-statistiques.js') }}" defer></script>

<!-- Script pour adapter les graphiques au thème -->
<script>
    // S'assurer que les graphiques s'adaptent au thème actuel
    document.addEventListener('DOMContentLoaded', function() {
        // Détecter le thème actuel
        const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
        
        // Créer un élément de style pour ajuster les couleurs de Chart.js
        const styleElement = document.createElement('style');
        
        if (currentTheme === 'dark') {
            styleElement.textContent = `
                .chartjs-tooltip {
                    background-color: #1F2937 !important;
                    color: #F9FAFB !important;
                    border-color: #374151 !important;
                }
                
                .chartjs-render-monitor {
                    color: #F9FAFB !important;
                }
            `;
        } else {
            styleElement.textContent = `
                .chartjs-tooltip {
                    background-color: #FFFFFF !important;
                    color: #1E293B !important;
                    border-color: #E2E8F0 !important;
                }
                
                .chartjs-render-monitor {
                    color: #1E293B !important;
                }
            `;
        }
        
        document.head.appendChild(styleElement);
        
        // Écouter les changements de thème
        window.addEventListener('themeChanged', function(e) {
            const newTheme = e.detail.theme;
            // Recharger la page pour que les graphiques se réinitialisent avec le bon thème
            window.location.reload();
        });
    });
</script>
@endsection
