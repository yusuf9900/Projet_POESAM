@extends('layouts.app')

@section('content')
<div class="container-fluid dashboard-container min-vh-100">
    <style>
        :root {
            --primary-color: #6366F1;
            --primary-hover: #4F46E5;
            --secondary-color: #4B5563;
            --success-color: #059669;
            --info-color: #0EA5E9;
            --warning-color: #F59E0B;
            --danger-color: #DC2626;
            --dark-bg: #111827;
            --darker-bg: #0B0F1A;
            --card-bg: #1F2937;
            --border-color: #374151;
            --text-primary: #F9FAFB;
            --text-secondary: #D1D5DB;
            --text-muted: #9CA3AF;
        }

        /* Styles généraux */
        .dashboard-container {
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
        }

        .sidebar {
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .gradient-border {
            position: relative;
            background: var(--gray-50);
            z-index: 1;
        }

        .gradient-border::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            border-radius: inherit;
            z-index: -1;
            opacity: 0.3;
        }

        /* Cartes statistiques avec dégradés */
        .stat-card {
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gradient-primary);
            opacity: 0.05;
            z-index: -1;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover::before {
            opacity: 0.1;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px -1px rgba(0, 0, 0, 0.2);
        }

        .stat-card:hover {
            border-color: rgba(126, 58, 242, 0.2);
            box-shadow: 0 8px 12px -1px rgba(126, 58, 242, 0.08), 0 4px 6px -1px rgba(126, 58, 242, 0.05);
        }

        /* Icônes avec dégradés */
        .stat-icon {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 2rem;
        }

        .stat-icon-bg {
            background: rgba(79, 70, 229, 0.1);
            border-radius: 12px;
            padding: 1rem;
            margin-right: 1rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon-bg {
            transform: scale(1.1);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-label {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin-top: 0.5rem;
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1rem;
            font-size: 0.9rem;
        }

        .trend-up {
            color: var(--success);
        }

        .trend-down {
            color: var(--danger);
        }

        /* Animation de pulsation pour les icônes */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .stat-icon {
            color: var(--primary-color);
        }
        /* Cartes avec effets modernes */
        .card {
            position: relative;
            overflow: hidden;
            border: none;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }

        .card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gradient-primary);
            opacity: 0.05;
            z-index: -1;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 12px -1px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 1rem;
        }
        .table {
            color: var(--text-primary);
            margin-bottom: 0;
        }

        .table tr:hover {
            background-color: var(--bg-secondary);
        }
        .table thead th {
            background: var(--darker-bg);
            color: var(--text-secondary);
            border-bottom: 2px solid var(--border-color);
        }
        .table td {
            border-color: var(--border-color);
        }
        .text-muted {
            color: var(--text-muted) !important;
        }
        .btn-soft-primary {
            background: rgba(99, 102, 241, 0.1);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }
        .btn-soft-primary:hover {
            background: var(--primary-color);
            color: white;
        }
        .bg-gray-50 { background-color: var(--gray-50); }
        .bg-gray-100 { background-color: var(--gray-100); }
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); }
        .btn-primary:hover { background-color: var(--primary-hover); border-color: var(--primary-hover); }
        .text-primary { color: var(--primary-color) !important; }
    </style>
    <div class="row">
        @include('layouts.sidebar', ['userType' => 'admin'])
        
        <!-- Contenu principal -->
        <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-3 mb-4">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-primary">Administration</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tableau de bord</li>
                        </ol>
                    </nav>
                    <h1 class="h2 mb-1 fw-bold text-dark">Tableau de bord</h1>
                    <p class="text-muted mb-0 fs-6">Vue d'ensemble de votre système - <span class="fw-medium">{{ now()->format('d F Y') }}</span></p>
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
                    <style>
                        .btn-soft-primary {
                            background-color: rgba(126, 58, 242, 0.1);
                            color: var(--primary-color);
                            border: 1px solid rgba(126, 58, 242, 0.1);
                            transition: all 0.3s ease;
                        }
                        .btn-soft-primary:hover {
                            background-color: var(--primary-color);
                            color: white;
                            border-color: var(--primary-color);
                        }
                    </style>
                </div>
            </div>
            
            @if(request()->has('success'))
            <div class="alert custom-alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    <div>
                        {{ request()->get('success') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            @if(request()->has('error'))
            <div class="alert custom-alert alert-danger alert-dismissible fade show border-0 rounded-4 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <div>
                        {{ request()->get('error') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            <style>
                .custom-alert {
                    padding: 1rem;
                    background-color: rgba(var(--bs-success-rgb), 0.05);
                }
                .custom-alert.alert-danger {
                    background-color: rgba(var(--bs-danger-rgb), 0.05);
                }
            </style>
            
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        <h5>Bienvenue, {{ session('user_name') }}!</h5>
                        <p>Vous êtes connecté en tant qu'administrateur du système.</p>
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card stat-card shadow-sm h-100 border-0 rounded-4 overflow-hidden hover-shadow transition-all">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start mb-3">
                                <div class="stat-icon-bg">
                                    <i class="fas fa-building stat-icon"></i>
                                </div>
                                <div>
                                    <h5 class="stat-label">Organisations</h5>
                                    <div class="stat-number">1,234</div>
                                    <div class="stat-trend">
                                        <i class="fas fa-arrow-up trend-up"></i>
                                        <span class="trend-up">+12.5%</span>
                                        <span class="text-muted">ce mois</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card shadow-sm h-100 border-0 rounded-4 overflow-hidden hover-shadow transition-all">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start mb-3">
                                <div class="stat-icon-bg">
                                    <i class="fas fa-users stat-icon"></i>
                                </div>
                                <div>
                                    <h5 class="stat-label">Victimes</h5>
                                    <div class="stat-number">856</div>
                                    <div class="stat-trend">
                                        <i class="fas fa-arrow-up trend-up"></i>
                                        <span class="trend-up">+8.3%</span>
                                        <span class="text-muted">ce mois</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stat-card shadow-sm h-100 border-0 rounded-4 overflow-hidden hover-shadow transition-all">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start mb-3">
                                <div class="stat-icon-bg">
                                    <i class="fas fa-file-alt stat-icon"></i>
                                </div>
                                <div>
                                    <h5 class="stat-label">Cas signalés</h5>
                                    <div class="stat-number">2,567</div>
                                    <div class="stat-trend">
                                        <i class="fas fa-arrow-up trend-up"></i>
                                        <span class="trend-up">+15.2%</span>
                                        <span class="text-muted">ce mois</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden hover-shadow transition-all mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Evolution des cas signalés</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div style="position: relative; height: 300px;">
                                <canvas id="casChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden hover-shadow transition-all mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Types d'organisations</h5>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div style="position: relative; height: 300px;">
                                <canvas id="organisationsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Chart.js Library -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
            
            <!-- Initialization des graphiques -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Graphique des cas signalés
                    const casCtx = document.getElementById('casChart');
                    if (casCtx) {
                        const casChart = new Chart(casCtx, {
                            type: 'line',
                            data: {
                                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                                datasets: [{
                                    label: 'Cas signalés',
                                    data: [450, 520, 480, 680, 750, 850],
                                    fill: true,
                                    backgroundColor: 'rgba(79, 70, 229, 0.2)',
                                    borderColor: '#4F46E5',
                                    tension: 0.4,
                                    pointBackgroundColor: '#4F46E5'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                },
                                scales: {
                                    y: { beginAtZero: true, grid: { display: false } },
                                    x: { grid: { display: false } }
                                }
                            }
                        });
                    } else {
                        console.error('Canvas casChart not found');
                    }

                    // Graphique des organisations
                    const orgCtx = document.getElementById('organisationsChart');
                    if (orgCtx) {
                        const orgChart = new Chart(orgCtx, {
                            type: 'doughnut',
                            data: {
                                labels: ['ONG', 'Associations', 'Institutions', 'Autres'],
                                datasets: [{
                                    data: [35, 25, 20, 20],
                                    backgroundColor: ['#4F46E5', '#EC4899', '#10B981', '#3B82F6'],
                                    borderWidth: 0
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { position: 'bottom' }
                                },
                                cutout: '70%'
                            }
                        });
                    } else {
                        console.error('Canvas organisationsChart not found');
                    }
                });
            </script>

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden hover-shadow transition-all">
                    <style>
                        .hover-shadow {
                            transition: all 0.3s ease;
                        }
                        .hover-shadow:hover {
                            transform: translateY(-2px);
                            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
                        }
                        .transition-all {
                            transition: all 0.3s ease;
                        }
                    </style>
                        <div class="card-header bg-white py-4 border-bottom-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Liste des organisations</h5>
                                <a href="/admin/create-organisation" class="btn btn-sm gradient-border hover-shadow transition-all"><i class="fas fa-plus"></i> Ajouter</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <style>
                                        .table {
                                            --bs-table-hover-bg: var(--gray-50);
                                        }
                                        .table th { 
                                            font-weight: 600; 
                                            color: var(--gray-600); 
                                            text-transform: uppercase;
                                            font-size: 0.75rem;
                                            letter-spacing: 0.05em;
                                        }
                                        .table td { 
                                            font-size: 0.875rem;
                                            color: var(--gray-700);
                                            padding-top: 1rem;
                                            padding-bottom: 1rem;
                                            vertical-align: middle;
                                        }
                                        .table tr:hover .btn-action {
                                            opacity: 1;
                                            transform: translateY(0);
                                        }
                                        .btn-action {
                                            opacity: 0.5;
                                            transform: translateY(2px);
                                            transition: all 0.2s ease;
                                        }
                                        .btn-action:hover {
                                            background-color: var(--gray-100);
                                        }
                                        .organisation-name {
                                            font-weight: 500;
                                            color: var(--gray-800);
                                        }
                                        .type-badge {
                                            font-size: 0.75rem;
                                            padding: 0.25rem 0.75rem;
                                            border-radius: 9999px;
                                            background-color: var(--gray-100);
                                            color: var(--gray-700);
                                            font-weight: 500;
                                        }
                                    </style>
                                    <thead>
                                        <tr class="border-bottom">
                                            <th class="py-3">ORGANISATION</th>
                                            <th class="py-3">TYPE</th>
                                            <th class="py-3">CONTACT</th>
                                            <th class="py-3">TÉLÉPHONE</th>
                                            <th class="py-3">CRÉATION</th>
                                            <th class="py-3 text-end pe-4">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($organisations) && count($organisations) > 0)
                                            @foreach($organisations as $organisation)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3 rounded-circle p-2" style="background-color: var(--gray-100);">
                                                            <i class="fas fa-building text-primary"></i>
                                                        </div>
                                                        <span class="organisation-name">{{ $organisation['nom_organisation'] ?? 'N/A' }}</span>
                                                    </div>
                                                </td>
                                                <td><span class="type-badge">{{ $organisation['type_organisation'] ?? 'N/A' }}</span></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-envelope text-muted me-2"></i>
                                                        {{ $organisation['email'] ?? 'N/A' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-phone text-muted me-2"></i>
                                                        {{ $organisation['telephone_organisation'] ?? 'N/A' }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-calendar text-muted me-2"></i>
                                                        {{ \Carbon\Carbon::parse($organisation['date_creation'] ?? now())->format('d/m/Y H:i') }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="/admin/show-organisation/{{ $organisation['id'] }}" class="btn btn-sm btn-light btn-action rounded-circle me-1" data-bs-toggle="tooltip" title="Voir les détails">
                                                            <i class="fas fa-eye text-primary"></i>
                                                        </a>
                                                        <a href="/admin/delete-organisation/{{ $organisation['id'] }}" class="btn btn-sm btn-light btn-action rounded-circle" data-bs-toggle="tooltip" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette organisation ?')">
                                                            <i class="fas fa-trash text-danger"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">Aucune organisation à afficher</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0 rounded-4 overflow-hidden hover-shadow transition-all">
                    <style>
                        .hover-shadow {
                            transition: all 0.3s ease;
                        }
                        .hover-shadow:hover {
                            transform: translateY(-2px);
                            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
                        }
                        .transition-all {
                            transition: all 0.3s ease;
                        }
                    </style>
                        <div class="card-header bg-white py-4 border-bottom-0">
                            <h5 class="mb-0">Activité récente</h5>
                        </div>
                        <div class="card-body">
                            <div class="timeline position-relative">
                                <style>
                                    .timeline-item::before {
                                        content: '';
                                        position: absolute;
                                        left: -8px;
                                        top: 0;
                                        width: 16px;
                                        height: 16px;
                                        border-radius: 50%;
                                        background-color: var(--primary-color);
                                        border: 3px solid var(--gray-50);
                                    }
                                    .timeline-item {
                                        border-left-color: var(--gray-200) !important;
                                    }
                                </style>
                                <div class="timeline-item pb-4 position-relative ms-4 border-start ps-4">
                                    <div class="d-flex">
                                        <div class="timeline-icon me-3 rounded-circle p-2" style="background-color: rgba(52, 152, 219, 0.1);">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div>
                                            <p class="mb-0">Aucune activité récente à afficher</p>
                                            <small class="text-muted">-</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
