@extends('layouts.app')

@section('title', 'Reports Dashboard')

@section('content')
<style>
    /* ========================================
       ULTRA PREMIUM REPORTS DASHBOARD DESIGN
    ======================================== */
    
    :root {
        --primary: #4361ee;
        --primary-dark: #3a0ca3;
        --primary-light: #4895ef;
        --secondary: #4cc9f0;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --info: #3b82f6;
        --dark: #1e293b;
        --gray: #64748b;
        --light: #f8fafc;
        --white: #ffffff;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        --radius-sm: 0.5rem;
        --radius-md: 1rem;
        --radius-lg: 1.5rem;
        --radius-xl: 2rem;
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }

    /* Header */
    .dashboard-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: var(--radius-xl);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
        animation: fadeInUp 0.5s ease;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 25%, transparent 25%),
                    linear-gradient(-45deg, rgba(255,255,255,0.1) 25%, transparent 25%);
        background-size: 40px 40px;
        animation: shimmer 15s linear infinite;
    }

    /* Stat Cards */
    .stat-card-premium {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.6s ease;
    }

    .stat-card-premium::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .stat-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .stat-card-premium:hover::after {
        transform: scaleX(1);
    }

    .stat-icon-premium {
        width: 55px;
        height: 55px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .stat-card-premium:hover .stat-icon-premium {
        transform: scale(1.05) rotate(5deg);
    }

    .stat-value-premium {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1.2;
    }

    /* Trend Card */
    .trend-card-premium {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        animation: fadeInUp 0.7s ease;
    }

    .trend-card-premium:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    /* Report Card */
    .report-card-premium {
        background: var(--white);
        border-radius: var(--radius-lg);
        padding: 2rem;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0, 0, 0, 0.05);
        animation: fadeInUp 0.8s ease;
        position: relative;
        overflow: hidden;
    }

    .report-card-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }

    .report-card-premium:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
    }

    .report-card-premium:hover::before {
        left: 100%;
    }

    .report-icon-premium {
        width: 80px;
        height: 80px;
        border-radius: 24px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .report-card-premium:hover .report-icon-premium {
        transform: scale(1.1) rotate(5deg);
    }

    /* Table */
    .table-container-premium {
        background: var(--white);
        border-radius: var(--radius-lg);
        overflow: hidden;
    }

    .table-row-premium {
        transition: all 0.2s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    .table-row-premium:hover {
        background: linear-gradient(90deg, #f8f9ff, transparent);
        transform: translateX(3px);
    }

    /* Insight Cards */
    .insight-card-premium {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: var(--radius-lg);
        padding: 1.2rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .insight-card-premium:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .progress-premium {
        height: 8px;
        border-radius: 10px;
        background: #e2e8f0;
        overflow: hidden;
    }

    .progress-bar-premium {
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        border-radius: 10px;
        position: relative;
        overflow: hidden;
    }

    .progress-bar-premium::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        animation: shimmer 2s infinite;
    }

    .trend-badge-premium {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    @media (max-width: 768px) {
        .stat-value-premium {
            font-size: 1.5rem;
        }
        .report-icon-premium {
            width: 60px;
            height: 60px;
        }
        .report-icon-premium i {
            font-size: 1.5rem;
        }
    }
</style>

<div class="container-fluid px-4 py-4">
    
    <!-- Premium Header -->
    <div class="dashboard-header mb-4">
        <div class="p-4 position-relative">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="text-white">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <i class="fas fa-chart-pie fa-3x opacity-75"></i>
                        <div>
                            <h1 class="display-5 fw-bold mb-1">Reports Dashboard</h1>
                            <p class="mb-0 opacity-90 fs-5">View analytics and insights about your organization</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white bg-opacity-20 rounded-pill px-4 py-2 mt-3 mt-sm-0">
                    <i class="fas fa-calendar-alt me-2"></i>
                    <span class="fw-semibold">{{ now()->format('F Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-5">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon-premium bg-primary bg-opacity-10">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                </div>
                <div class="stat-value-premium text-primary">{{ $totalEmployees ?? 0 }}</div>
                <div class="text-muted mb-2">Total Employees</div>
                <div class="progress-premium">
                    <div class="progress-bar-premium" style="width: 75%"></div>
                </div>
                <div class="mt-2">
                    <small class="text-success"><i class="fas fa-chart-line me-1"></i>Active workforce</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon-premium bg-success bg-opacity-10">
                        <i class="fas fa-building fa-2x text-success"></i>
                    </div>
                </div>
                <div class="stat-value-premium text-success">{{ $totalDepartments ?? 0 }}</div>
                <div class="text-muted mb-2">Active Departments</div>
                <div class="progress-premium">
                    <div class="progress-bar-premium bg-success" style="width: 60%"></div>
                </div>
                <div class="mt-2">
                    <small class="text-success"><i class="fas fa-chart-line me-1"></i>Department structure</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon-premium bg-info bg-opacity-10">
                        <i class="fas fa-user-check fa-2x text-info"></i>
                    </div>
                </div>
                <div class="stat-value-premium text-info">{{ $presentToday ?? 0 }}</div>
                <div class="text-muted mb-2">Present Today</div>
                <div class="progress-premium">
                    @php
                        $attendanceRate = isset($totalEmployees) && $totalEmployees > 0 ? (($presentToday ?? 0) / $totalEmployees) * 100 : 0;
                    @endphp
                    <div class="progress-bar-premium bg-info" style="width: {{ $attendanceRate }}%"></div>
                </div>
                <div class="mt-2">
                    <small class="text-info"><i class="fas fa-chart-line me-1"></i>Attendance rate: {{ round($attendanceRate, 1) }}%</small>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card-premium">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="stat-icon-premium bg-warning bg-opacity-10">
                        <i class="fas fa-dollar-sign fa-2x text-warning"></i>
                    </div>
                </div>
                <div class="stat-value-premium text-warning">${{ number_format($totalSalaries ?? 0, 0) }}</div>
                <div class="text-muted mb-2">Total Salary Paid</div>
                <div class="progress-premium">
                    <div class="progress-bar-premium bg-warning" style="width: 85%"></div>
                </div>
                <div class="mt-2">
                    <small class="text-warning"><i class="fas fa-chart-line me-1"></i>This month payroll</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Trend Table -->
    <div class="trend-card-premium mb-5">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                    <i class="fas fa-chart-line text-primary"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Attendance Trend</h5>
                    <p class="text-muted small mb-0">Last 6 months overview</p>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3">Month</th>
                            <th class="py-3">Present</th>
                            <th class="py-3">Absent</th>
                            <th class="py-3">Late</th>
                            <th class="py-3">Attendance Rate</th>
                        </thead>
                    <tbody>
                        @forelse($attendanceTrend ?? [] as $trend)
                        @php
                            $total = ($trend['present'] ?? 0) + ($trend['absent'] ?? 0) + ($trend['late'] ?? 0);
                            $rate = $total > 0 ? round(($trend['present'] / $total) * 100, 1) : 0;
                        @endphp
                        <tr class="table-row-premium">
                            <td class="px-4 py-3 fw-semibold">{{ $trend['month'] }}</td>
                            <td class="py-3">
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i>{{ $trend['present'] }}
                                </span>
                             </td>
                            <td class="py-3">
                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">
                                    <i class="fas fa-times-circle me-1"></i>{{ $trend['absent'] }}
                                </span>
                             </td>
                            <td class="py-3">
                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">
                                    <i class="fas fa-clock me-1"></i>{{ $trend['late'] }}
                                </span>
                             </td>
                            <td class="py-3">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-semibold">{{ $rate }}%</span>
                                    <div class="progress flex-grow-1" style="height: 6px;">
                                        <div class="progress-bar bg-primary" style="width: {{ $rate }}%"></div>
                                    </div>
                                </div>
                             </td>
                         </tr>
                        @empty
                         <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-chart-line fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0">No attendance data available</p>
                             </td>
                         </tr>
                        @endforelse
                    </tbody>
                 </table>
            </div>
        </div>
    </div>

    <!-- Report Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <a href="{{ route('reports.employees') }}" class="text-decoration-none">
                <div class="report-card-premium">
                    <div class="report-icon-premium bg-primary bg-opacity-10 mx-auto">
                        <i class="fas fa-users fa-3x text-primary"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Employees Report</h5>
                    <p class="text-muted small mb-3">View and export employee data</p>
                    <div class="trend-badge-premium mx-auto d-inline-flex">
                        <i class="fas fa-download"></i> Export CSV
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('reports.attendance') }}" class="text-decoration-none">
                <div class="report-card-premium">
                    <div class="report-icon-premium bg-success bg-opacity-10 mx-auto">
                        <i class="fas fa-calendar-check fa-3x text-success"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Attendance Report</h5>
                    <p class="text-muted small mb-3">Monthly attendance summary</p>
                    <div class="trend-badge-premium mx-auto d-inline-flex">
                        <i class="fas fa-chart-line"></i> View Details
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('reports.salary') }}" class="text-decoration-none">
                <div class="report-card-premium">
                    <div class="report-icon-premium bg-warning bg-opacity-10 mx-auto">
                        <i class="fas fa-dollar-sign fa-3x text-warning"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Salary Report</h5>
                    <p class="text-muted small mb-3">Payroll summary and export</p>
                    <div class="trend-badge-premium mx-auto d-inline-flex">
                        <i class="fas fa-download"></i> Export CSV
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Quick Insights -->
    @if(isset($attendanceTrend) && count($attendanceTrend) > 0)
    <div class="row g-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                            <i class="fas fa-lightbulb text-primary"></i>
                        </div>
                        <h5 class="fw-bold mb-0">Quick Insights</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="insight-card-premium">
                                <i class="fas fa-chart-line fa-2x text-primary mb-2"></i>
                                <h6 class="fw-bold mb-1">Best Month</h6>
                                @php
                                    $bestMonth = collect($attendanceTrend)->sortByDesc('present')->first();
                                @endphp
                                <p class="mb-0 fw-semibold">{{ $bestMonth['month'] ?? 'N/A' }}</p>
                                <small class="text-muted">{{ $bestMonth['present'] ?? 0 }} present</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="insight-card-premium">
                                <i class="fas fa-chart-line fa-2x text-warning mb-2"></i>
                                <h6 class="fw-bold mb-1">Worst Month</h6>
                                @php
                                    $worstMonth = collect($attendanceTrend)->sortBy('present')->first();
                                @endphp
                                <p class="mb-0 fw-semibold">{{ $worstMonth['month'] ?? 'N/A' }}</p>
                                <small class="text-muted">{{ $worstMonth['present'] ?? 0 }} present</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="insight-card-premium">
                                <i class="fas fa-chart-line fa-2x text-success mb-2"></i>
                                <h6 class="fw-bold mb-1">Average Attendance</h6>
                                @php
                                    $avgAttendance = collect($attendanceTrend)->avg('present');
                                @endphp
                                <p class="mb-0 fw-semibold">{{ round($avgAttendance, 0) }}</p>
                                <small class="text-muted">employees/month</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection