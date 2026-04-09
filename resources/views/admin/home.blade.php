@extends('layouts.admin')

@section('content')
@php
    $total_mamalia = $sapi + $kerbau + $kuda + $kambing + $babi + $domba;
    $total_unggas = $ayam_ras + $ayam_buras + $ayam_petelur + $itik + $puyuh;
    $total_ternak = $total_mamalia + $total_unggas;

    $getPct = function($val) use ($total_ternak) {
        return $total_ternak > 0 ? number_format(($val / $total_ternak) * 100, 1) : 0;
    };
    $pct_mamalia = $getPct($total_mamalia);
    $pct_unggas = $getPct($total_unggas);
@endphp

<div class="content content-wrapper" style="background-color: #f4f7fb; min-height: 100vh;">
    <!-- Modern Header -->
    <div class="content-header pt-4 pb-3">
      <div class="container-fluid">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-2 mt-2">
          <div class="d-flex align-items-center mb-3 mb-md-0">
            <div class="mr-3" style="background: #1e3a5f; color: #fff; width: 45px; height: 45px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div>
                <h1 class="m-0 font-weight-bold" style="color: #1e3a5f !important; font-size: 1.6rem; letter-spacing: -0.5px;">Dashboard Populasi Ternak</h1>
                <p class="text-muted mb-0" style="font-size: 0.85rem; font-weight: 500;">Dinas PKH Provinsi NTB &nbsp;&nbsp;|&nbsp;&nbsp; Tahun {{ session()->get('tahun_data') ?? date('Y') }}</p>
            </div>
          </div>
          <div>
            <span class="badge px-4 py-2" style="background-color:#1e3a5f; color:#fff; font-size:0.95rem; font-weight:600; box-shadow: 0 4px 10px rgba(30, 58, 95, 0.3); border-radius: 8px;">
                <i class="fas fa-database mr-2"></i> Total Ternak: {{ number_format($total_ternak) }} Ekor
            </span>
          </div>
        </div>
      </div>
    </div>

    <style>
        /* Modern Cards Refactored for Overhaul Theme */
        .dashboard-header-card {
            border-radius: 14px;
            padding: 24px;
            color: #fff;
            margin-bottom: 24px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        .dashboard-header-card:hover {
            transform: translateY(-4px);
        }
        /* Match image abstract background colors */
        .bg-navy-blue { background: linear-gradient(135deg, #214373 0%, #173054 100%); }
        .bg-teal-green { background: linear-gradient(135deg, #2c8c7c 0%, #1f6b5e 100%); }
        .bg-purple-gradient { background: linear-gradient(135deg, #9333ea 0%, #7e22ce 100%); }
        
        .card-title-sm {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            opacity: 0.9;
        }
        .card-title-sm i { margin-right: 8px; font-size: 1rem; }
        
        .card-value {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 2px;
            line-height: 1.1;
            letter-spacing: -1px;
        }
        .card-subtitle {
            font-size: 0.85rem;
            opacity: 0.85;
            font-weight: 500;
        }
        .card-icon-bg {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 5rem;
            opacity: 0.15;
            transition: all 0.3s;
        }
        .dashboard-header-card:hover .card-icon-bg {
            transform: translateY(-50%) scale(1.1) rotate(-5deg);
            opacity: 0.25;
        }
        
        /* Lists */
        .detail-card {
            border-radius: 14px;
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            background: #fff;
            margin-bottom: 24px;
            overflow: hidden;
            height: calc(100% - 24px);
        }
        .detail-card-header {
            background: #1e3a5f;
            color: #fff;
            padding: 16px 20px;
            font-weight: 600;
            font-size: 1.05rem;
        }
        .detail-card-header.purple-header {
            background: #9333ea;
        }
        .detail-card-header.dark-header {
            background: #111827;
        }
        .detail-card-header i { margin-right: 8px; opacity: 0.9; }
        
        .list-item-animal {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.2s;
        }
        .list-item-animal:hover { background-color: #f8fafc; }
        .list-item-animal:last-child { border-bottom: none; }
        
        .animal-icon-container {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-right: 16px;
        }
        /* Mamalia Icons */
        .icon-sapi { background: #d1ecf1; color: #17a2b8; } /* bg-info */
        .icon-kerbau { background: #d1ecf1; color: #17a2b8; } /* bg-info */
        .icon-kuda { background: #d1ecf1; color: #17a2b8; } /* bg-info */
        .icon-kambing { background: #d4edda; color: #28a745; } /* bg-success */
        .icon-babi { background: #d4edda; color: #28a745; } /* bg-success */
        .icon-domba { background: #d4edda; color: #28a745; } /* bg-success */
        
        /* Unggas Icons */
        .icon-ayam-ras { background: #fff3cd; color: #ffc107; } /* bg-warning */
        .icon-ayam-buras { background: #fff3cd; color: #ffc107; } /* bg-warning */
        .icon-ayam-petelur { background: #fff3cd; color: #ffc107; } /* bg-warning */
        .icon-itik { background: #fff3cd; color: #ffc107; } /* bg-warning */
        .icon-puyuh { background: #fff3cd; color: #ffc107; } /* bg-warning */

        .animal-info { flex-grow: 1; }
        .animal-name { font-weight: 600; color: #475569; margin: 0; font-size: 0.95rem; }
        .animal-count { font-weight: 800; color: #0f172a; font-size: 1.15rem; margin: 0; }
        .animal-pct { font-weight: 700; font-size: 0.9rem; }
    </style>

    <section class="content">
        <div class="container-fluid">
            <!-- Top 3 Cards -->
            <div class="row">
                <div class="col-md-4">
                    <div class="dashboard-header-card bg-navy-blue">
                        <div class="card-title-sm"><i class="fas fa-layer-group"></i> TOTAL SELURUH TERNAK</div>
                        <div class="card-value">{{ number_format($total_ternak) }}</div>
                        <div class="card-subtitle mt-1">Ekor dari semua jenis</div>
                        <i class="fas fa-layer-group card-icon-bg"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-header-card bg-teal-green">
                        <div class="card-title-sm"><i class="fas fa-paw"></i> TOTAL TERNAK MAMALIA</div>
                        <div class="card-value">{{ number_format($total_mamalia) }}</div>
                        <div class="card-subtitle mt-1">{{ $pct_mamalia }}% dari keseluruhan</div>
                        <i class="fas fa-horse card-icon-bg"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-header-card bg-purple-gradient">
                        <div class="card-title-sm"><i class="fas fa-feather-alt"></i> TOTAL TERNAK UNGGAS</div>
                        <div class="card-value">{{ number_format($total_unggas) }}</div>
                        <div class="card-subtitle mt-1">{{ $pct_unggas }}% dari keseluruhan</div>
                        <i class="fas fa-dove card-icon-bg"></i>
                    </div>
                </div>
            </div>

            <!-- Details 3 Columns -->
            <div class="row mt-2">
                <!-- Mamalia Column -->
                <div class="col-md-4">
                    <div class="detail-card">
                        <div class="detail-card-header">
                            <i class="fas fa-list-ul"></i> Detail Mamalia
                            <div style="font-size: 0.75rem; font-weight: 400; margin-top: 3px; opacity: 0.8;">Jumlah & persentase tiap jenis</div>
                        </div>
                        <div class="detail-card-body p-0 pb-2">
                            <div class="list-item-animal">
                                <div class="animal-icon-container icon-sapi"><i class="fas fa-horse-head"></i></div>
                                <div class="animal-info">
                                    <p class="animal-name">Sapi</p>
                                    <p class="animal-count">{{ number_format($sapi) }}</p>
                                </div>
                                <div class="animal-pct" style="color: #17a2b8;">{{ $getPct($sapi) }}%</div>
                            </div>
                            <div class="list-item-animal">
                                <div class="animal-icon-container icon-kerbau"><i class="fas fa-paw"></i></div>
                                <div class="animal-info">
                                    <p class="animal-name">Kerbau</p>
                                    <p class="animal-count">{{ number_format($kerbau) }}</p>
                                </div>
                                <div class="animal-pct" style="color: #17a2b8;">{{ $getPct($kerbau) }}%</div>
                            </div>
                            <div class="list-item-animal">
                                <div class="animal-icon-container icon-kuda"><i class="fas fa-horse"></i></div>
                                <div class="animal-info">
                                    <p class="animal-name">Kuda</p>
                                    <p class="animal-count">{{ number_format($kuda) }}</p>
                                </div>
                                <div class="animal-pct" style="color: #17a2b8;">{{ $getPct($kuda) }}%</div>
                            </div>
                            <div class="list-item-animal">
                                <div class="animal-icon-container icon-kambing"><i class="fas fa-paw"></i></div>
                                <div class="animal-info">
                                    <p class="animal-name">Kambing</p>
                                    <p class="animal-count">{{ number_format($kambing) }}</p>
                                </div>
                                <div class="animal-pct" style="color: #28a745;">{{ $getPct($kambing) }}%</div>
                            </div>
                            <div class="list-item-animal">
                                <div class="animal-icon-container icon-babi"><i class="fas fa-piggy-bank"></i></div>
                                <div class="animal-info">
                                    <p class="animal-name">Babi</p>
                                    <p class="animal-count">{{ number_format($babi) }}</p>
                                </div>
                                <div class="animal-pct" style="color: #28a745;">{{ $getPct($babi) }}%</div>
                            </div>
                            <div class="list-item-animal">
                                <div class="animal-icon-container icon-domba"><i class="fas fa-paw"></i></div>
                                <div class="animal-info">
                                    <p class="animal-name">Domba</p>
                                    <p class="animal-count">{{ number_format($domba) }}</p>
                                </div>
                                <div class="animal-pct" style="color: #28a745;">{{ $getPct($domba) }}%</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Doughnut Chart Column -->
                <div class="col-md-4">
                    <div class="detail-card d-flex flex-column">
                        <div class="detail-card-header dark-header">
                            <i class="fas fa-chart-pie"></i> Proporsi Populasi
                            <div style="font-size: 0.75rem; font-weight: 400; margin-top: 3px; opacity: 0.8;">Persentase dari total keseluruhan</div>
                        </div>
                        <div class="p-3 flex-grow-1 d-flex flex-column align-items-center justify-content-center" style="min-height: 480px;">
                            <canvas id="populasiChart" style="width: 100%; height: 100%;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Unggas Column -->
                <div class="col-md-4">
                    <div class="detail-card">
                        <div class="detail-card-header purple-header">
                            <i class="fas fa-list-ul"></i> Detail Unggas
                            <div style="font-size: 0.75rem; font-weight: 400; margin-top: 3px; opacity: 0.8;">Jumlah & persentase tiap jenis</div>
                        </div>
                        <div class="detail-card-body p-0 pb-2">
                            <div class="list-item-animal">
                                <div class="animal-icon-container icon-ayam-ras"><i class="fas fa-dove"></i></div>
                                <div class="animal-info">
                                    <p class="animal-name">Ayam Ras</p>
                                    <p class="animal-count">{{ number_format($ayam_ras) }}</p>
                                </div>
                                <div class="animal-pct" style="color: #ffc107;">{{ $getPct($ayam_ras) }}%</div>
                            </div>
                            <div class="list-item-animal">
                                <div class="animal-icon-container icon-ayam-buras"><i class="fas fa-crow"></i></div>
                                <div class="animal-info">
                                    <p class="animal-name">Ayam Buras</p>
                                    <p class="animal-count">{{ number_format($ayam_buras) }}</p>
                                </div>
                                <div class="animal-pct" style="color: #ffc107;">{{ $getPct($ayam_buras) }}%</div>
                            </div>
                            <div class="list-item-animal">
                                <div class="animal-icon-container icon-ayam-petelur"><i class="fas fa-egg"></i></div>
                                <div class="animal-info">
                                    <p class="animal-name">Ayam Petelur</p>
                                    <p class="animal-count">{{ number_format($ayam_petelur) }}</p>
                                </div>
                                <div class="animal-pct" style="color: #ffc107;">{{ $getPct($ayam_petelur) }}%</div>
                            </div>
                            <div class="list-item-animal">
                                <div class="animal-icon-container icon-itik"><i class="fas fa-feather-alt"></i></div>
                                <div class="animal-info">
                                    <p class="animal-name">Itik</p>
                                    <p class="animal-count">{{ number_format($itik) }}</p>
                                </div>
                                <div class="animal-pct" style="color: #ffc107;">{{ $getPct($itik) }}%</div>
                            </div>
                            <div class="list-item-animal">
                                <div class="animal-icon-container icon-puyuh"><i class="fas fa-kiwi-bird"></i></div>
                                <div class="animal-info">
                                    <p class="animal-name">Puyuh</p>
                                    <p class="animal-count">{{ number_format($puyuh) }}</p>
                                </div>
                                <div class="animal-pct" style="color: #ffc107;">{{ $getPct($puyuh) }}%</div>
                            </div>
                        </div>
                        
                        <!-- Mini Bottom Extra box empty to pad space safely matching mamalia -->
                        <div class="p-3"></div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>
</div>

<!-- ChartJS Script for Doughnut Chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('populasiChart').getContext('2d');
    
    // Create custom plugin for white center border/styling if desired, but native is ok.
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Sapi', 'Kerbau', 'Kuda', 'Kambing', 'Babi', 'Domba', 'Ayam Ras', 'Ayam Buras', 'Ayam Petelur', 'Itik', 'Puyuh'],
            datasets: [{
                data: [
                    {{ $sapi }}, {{ $kerbau }}, {{ $kuda }}, {{ $kambing }}, {{ $babi }}, {{ $domba }},
                    {{ $ayam_ras }}, {{ $ayam_buras }}, {{ $ayam_petelur }}, {{ $itik }}, {{ $puyuh }}
                ],
                backgroundColor: [
                    '#17a2b8', '#17a2b8', '#17a2b8', '#28a745', '#28a745', '#28a745',
                    '#ffc107', '#ffc107', '#ffc107', '#ffc107', '#ffc107'
                ],
                borderWidth: 3,
                borderColor: '#ffffff',
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: 10
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 15,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: { size: 10, family: "'Source Sans Pro', sans-serif", weight: '600' }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleFont: { size: 13 },
                    bodyFont: { size: 13, weight: 'bold' },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed !== null) {
                                label += new Intl.NumberFormat('id-ID').format(context.parsed) + ' Ekor';
                            }
                            return label;
                        }
                    }
                }
            },
            cutout: '55%',
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
});
</script>
@endsection