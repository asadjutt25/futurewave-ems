@extends('layouts.app')

@section('title', 'Salary Details')

@section('content')
<style>
    /* ========================================
       ULTRA PREMIUM SALARY DETAILS DESIGN
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

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Header */
    .page-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: var(--radius-xl);
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
        animation: fadeInUp 0.5s ease;
    }

    .page-header::before {
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

    /* Info Cards */
    .info-card-premium {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
        animation: fadeInUp 0.6s ease;
    }

    .info-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .info-header-premium {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .info-header-premium h5, .info-header-premium h6 {
        font-weight: 700;
        margin-bottom: 0;
        color: var(--dark);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-header-premium i {
        color: var(--primary);
    }

    .info-body-premium {
        padding: 1.5rem;
    }

    .info-row-premium {
        display: flex;
        padding: 0.9rem 0;
        border-bottom: 1px solid #f1f5f9;
        transition: all 0.2s ease;
    }

    .info-row-premium:hover {
        transform: translateX(5px);
    }

    .info-row-premium:last-child {
        border-bottom: none;
    }

    .info-label-premium {
        width: 140px;
        font-weight: 600;
        color: var(--gray);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-label-premium i {
        width: 20px;
        color: var(--primary);
    }

    .info-value-premium {
        flex: 1;
        color: var(--dark);
        font-weight: 500;
    }

    /* Avatar */
    .avatar-premium {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-weight: 700;
        font-size: 2rem;
        margin: 0 auto;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-lg);
    }

    .avatar-premium:hover {
        transform: scale(1.05) rotate(5deg);
        box-shadow: var(--shadow-xl);
    }

    /* Breakdown Card */
    .breakdown-card-premium {
        background: linear-gradient(135deg, #f8fafc, #ffffff);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        animation: slideInRight 0.7s ease;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .breakdown-card-premium:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .breakdown-item-premium {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }

    .breakdown-item-premium:hover {
        transform: translateX(5px);
    }

    .breakdown-item-premium:last-child {
        border-bottom: none;
    }

    .breakdown-label-premium {
        font-weight: 600;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .breakdown-amount-premium {
        font-weight: 700;
        font-size: 1.1rem;
    }

    .breakdown-total-premium {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: var(--white);
        padding: 1.2rem;
        border-radius: 20px;
        margin-top: 1rem;
        transition: all 0.3s ease;
    }

    .breakdown-total-premium:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* Badges */
    .badge-status-premium {
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .badge-paid {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
    }

    .badge-pending {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
    }

    /* Buttons */
    .btn-download-premium {
        background: linear-gradient(135deg, #10b981, #059669);
        border: none;
        padding: 0.7rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-download-premium::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s ease;
    }

    .btn-download-premium:hover::before {
        left: 100%;
    }

    .btn-download-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
    }

    .btn-back-premium {
        background: #f1f5f9;
        border: none;
        color: #475569;
        padding: 0.7rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-back-premium:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

    /* Notes Card */
    .notes-card-premium {
        background: #fef9e7;
        border-left: 4px solid #f59e0b;
        border-radius: 20px;
        padding: 1.2rem;
        transition: all 0.3s ease;
    }

    .notes-card-premium:hover {
        transform: translateX(5px);
    }

    /* Quick Stats */
    .quick-stats-premium {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border-radius: 20px;
        padding: 1.2rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .quick-stats-premium:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    @media (max-width: 768px) {
        .info-label-premium {
            width: 100px;
            font-size: 0.85rem;
        }
        .avatar-premium {
            width: 70px;
            height: 70px;
            font-size: 1.5rem;
        }
        .breakdown-amount-premium {
            font-size: 0.9rem;
        }
    }
</style>

<div class="container-fluid px-4 py-4">
    
    <!-- Premium Header -->
    <div class="page-header mb-4">
        <div class="p-4 position-relative">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="text-white">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <i class="fas fa-file-invoice-dollar fa-3x opacity-75"></i>
                        <div>
                            <h1 class="display-5 fw-bold mb-1">Salary Details</h1>
                            <p class="mb-0 opacity-90 fs-5">View complete salary information</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-3 mt-sm-0">
                    <a href="{{ route('salary.download', $salary) }}" class="btn-download-premium btn">
                        <i class="fas fa-download me-2"></i>Download Slip
                    </a>
                    <a href="{{ route('salary.index') }}" class="btn-back-premium btn">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Employee Info Card -->
        <div class="col-lg-5">
            <div class="info-card-premium">
                <div class="info-header-premium text-center">
                    <div class="avatar-premium mx-auto mb-3">
                        {{ strtoupper(substr($salary->employee->name ?? 'U', 0, 1)) }}
                    </div>
                    <h5 class="fw-bold mb-1">{{ $salary->employee->name ?? 'N/A' }}</h5>
                    <p class="text-muted small mb-0">{{ $salary->employee->email ?? 'N/A' }}</p>
                </div>
                <div class="info-body-premium">
                    <div class="info-row-premium">
                        <div class="info-label-premium">
                            <i class="fas fa-building"></i> Department
                        </div>
                        <div class="info-value-premium">{{ optional($salary->employee->department)->department_name ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row-premium">
                        <div class="info-label-premium">
                            <i class="fas fa-briefcase"></i> Position
                        </div>
                        <div class="info-value-premium">{{ $salary->employee->position ?? 'N/A' }}</div>
                    </div>
                    <div class="info-row-premium">
                        <div class="info-label-premium">
                            <i class="fas fa-calendar-alt"></i> Joining Date
                        </div>
                        <div class="info-value-premium">{{ $salary->employee->joining_date ? \Carbon\Carbon::parse($salary->employee->joining_date)->format('d M Y') : 'N/A' }}</div>
                    </div>
                    <div class="info-row-premium">
                        <div class="info-label-premium">
                            <i class="fas fa-phone"></i> Phone
                        </div>
                        <div class="info-value-premium">{{ $salary->employee->phone ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Info Card -->
        <div class="col-lg-7">
            <div class="info-card-premium">
                <div class="info-header-premium">
                    <h6 class="mb-0">
                        <i class="fas fa-credit-card me-2"></i>Payment Information
                    </h6>
                </div>
                <div class="info-body-premium">
                    <div class="info-row-premium">
                        <div class="info-label-premium">
                            <i class="fas fa-calendar-alt"></i> Month/Year
                        </div>
                        <div class="info-value-premium fw-semibold">{{ $salary->month }} {{ $salary->year }}</div>
                    </div>
                    <div class="info-row-premium">
                        <div class="info-label-premium">
                            <i class="fas fa-credit-card"></i> Payment Method
                        </div>
                        <div class="info-value-premium">
                            @if($salary->payment_method == 'bank')
                                🏦 Bank Transfer
                            @elseif($salary->payment_method == 'cash')
                                💵 Cash
                            @else
                                📝 Check
                            @endif
                        </div>
                    </div>
                    <div class="info-row-premium">
                        <div class="info-label-premium">
                            <i class="fas fa-qrcode"></i> Transaction ID
                        </div>
                        <div class="info-value-premium">
                            @if($salary->transaction_id)
                                <code>{{ $salary->transaction_id }}</code>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </div>
                    </div>
                    <div class="info-row-premium">
                        <div class="info-label-premium">
                            <i class="fas fa-calendar-check"></i> Payment Date
                        </div>
                        <div class="info-value-premium">{{ $salary->payment_date->format('d F Y') }}</div>
                    </div>
                    <div class="info-row-premium">
                        <div class="info-label-premium">
                            <i class="fas fa-chart-line"></i> Status
                        </div>
                        <div class="info-value-premium">
                            @if($salary->status == 'paid')
                                <span class="badge-status-premium badge-paid">
                                    <i class="fas fa-check-circle"></i> Paid
                                </span>
                            @else
                                <span class="badge-status-premium badge-pending">
                                    <i class="fas fa-hourglass-half"></i> Pending
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Salary Breakdown Card -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="breakdown-card-premium">
                <div class="info-header-premium">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-pie me-2"></i>Salary Breakdown
                    </h6>
                </div>
                <div class="info-body-premium">
                    <div class="breakdown-item-premium">
                        <div class="breakdown-label-premium">
                            <i class="fas fa-dollar-sign text-primary"></i> Basic Salary
                        </div>
                        <div class="breakdown-amount-premium text-primary">${{ number_format($salary->basic_salary, 2) }}</div>
                    </div>
                    <div class="breakdown-item-premium">
                        <div class="breakdown-label-premium">
                            <i class="fas fa-plus-circle text-success"></i> Allowances
                        </div>
                        <div class="breakdown-amount-premium text-success">+ ${{ number_format($salary->allowances, 2) }}</div>
                    </div>
                    <div class="breakdown-item-premium">
                        <div class="breakdown-label-premium">
                            <i class="fas fa-minus-circle text-danger"></i> Deductions
                        </div>
                        <div class="breakdown-amount-premium text-danger">- ${{ number_format($salary->deductions, 2) }}</div>
                    </div>
                    <div class="breakdown-item-premium">
                        <div class="breakdown-label-premium">
                            <i class="fas fa-chart-line text-warning"></i> Tax
                        </div>
                        <div class="breakdown-amount-premium text-warning">- ${{ number_format($salary->tax, 2) }}</div>
                    </div>
                    <div class="breakdown-total-premium">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-calculator me-2"></i>
                                <strong>Net Salary</strong>
                            </div>
                            <div>
                                <span class="fs-2 fw-bold">${{ number_format($salary->net_salary, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes Section -->
    @if($salary->notes)
    <div class="row mt-4">
        <div class="col-12">
            <div class="notes-card-premium">
                <div class="d-flex gap-3">
                    <div class="bg-warning bg-opacity-10 rounded-circle p-2">
                        <i class="fas fa-sticky-note text-warning fa-lg"></i>
                    </div>
                    <div>
                        <strong class="d-block mb-1">Additional Notes</strong>
                        <p class="mb-0 text-muted">{{ $salary->notes }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Stats -->
    <div class="row mt-4 g-3">
        <div class="col-md-4">
            <div class="quick-stats-premium">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-2">
                    <i class="fas fa-calendar-alt fa-2x text-primary"></i>
                </div>
                <h6 class="fw-bold mb-1">{{ $salary->month }} {{ $salary->year }}</h6>
                <small class="text-muted">Salary Month</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="quick-stats-premium">
                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-3 mb-2">
                    <i class="fas fa-chart-line fa-2x text-success"></i>
                </div>
                <h6 class="fw-bold mb-1">{{ round(($salary->net_salary / max($salary->basic_salary, 1)) * 100, 1) }}%</h6>
                <small class="text-muted">Net vs Basic Ratio</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="quick-stats-premium">
                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex p-3 mb-2">
                    <i class="fas fa-clock fa-2x text-warning"></i>
                </div>
                <h6 class="fw-bold mb-1">{{ $salary->created_at->format('d M Y') }}</h6>
                <small class="text-muted">Processed On</small>
            </div>
        </div>
    </div>
</div>
@endsection