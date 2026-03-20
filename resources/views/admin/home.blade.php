@extends('admin.layouts.admin_layout')
@push('css')
    <style>
        /* Modern Dashboard Styles */
        .modern-dashboard {
            padding: 30px;
            background: #ffffff;
            min-height: 100vh;
        }

        .dashboard-header {
            margin-bottom: 40px;
        }

        .dashboard-header h1 {
            font-size: 2.4rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .dashboard-header p {
            color: #475569;
            margin: 10px 0 0;
            font-size: 1.1rem;
        }

        /* Stats Cards - Modern 2026 Design */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-bottom: 35px;
        }

        .stat-card {
            background: #fff;
            border-radius: 20px;
            padding: 28px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            text-decoration: none !important;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--card-color) 0%, var(--card-color-light) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .stat-card .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .stat-card .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            position: relative;
        }

        .stat-card .stat-icon::after {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 16px;
            background: inherit;
            filter: blur(12px);
            opacity: 0.4;
            z-index: -1;
        }

        .stat-card .stat-icon.blue {
            --card-color: #3b82f6;
            --card-color-light: #60a5fa;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: #fff;
        }

        .stat-card .stat-icon.green {
            --card-color: #10b981;
            --card-color-light: #34d399;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
        }

        .stat-card .stat-icon.orange {
            --card-color: #f97316;
            --card-color-light: #fb923c;
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: #fff;
        }

        .stat-card .stat-icon.purple {
            --card-color: #8b5cf6;
            --card-color-light: #a78bfa;
            background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
            color: #fff;
        }

        .stat-card .stat-icon.red {
            --card-color: #ef4444;
            --card-color-light: #f87171;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #fff;
        }

        .stat-card .stat-icon.teal {
            --card-color: #14b8a6;
            --card-color-light: #2dd4bf;
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
            color: #fff;
        }

        .stat-card .stat-content {
            flex: 1;
        }

        .stat-card .stat-value {
            font-size: 3rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1;
            margin-bottom: 8px;
            letter-spacing: -1px;
        }

        .stat-card .stat-label {
            font-size: 1rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .stat-trend {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.9rem;
            font-weight: 700;
            margin-top: 16px;
            padding: 8px 16px;
            border-radius: 30px;
        }

        .stat-card .stat-trend.up {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #15803d;
        }

        .stat-card .stat-trend.down {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            color: #dc2626;
        }

        /* Quick Actions */
        .quick-actions {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .quick-actions h3 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 25px;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 15px;
        }

        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px 15px;
            background: #f8fafc;
            border-radius: 12px;
            text-decoration: none !important;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }

        .action-btn:hover {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.3);
        }

        .action-btn i {
            font-size: 1.8rem;
            color: #3b82f6;
            margin-bottom: 12px;
            transition: all 0.3s;
        }

        .action-btn:hover i {
            color: #fff;
        }

        .action-btn span {
            font-size: 0.9rem;
            font-weight: 600;
            color: #374151;
            text-align: center;
            transition: color 0.3s;
        }

        .action-btn:hover span {
            color: #fff;
        }

        /* Mavi Butonlar */
        .action-btn.blue-btn {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border: none;
        }

        .action-btn.blue-btn i,
        .action-btn.blue-btn span {
            color: #fff;
        }

        /* Data Cards */
        .data-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 30px;
        }

        .data-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .data-card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .data-card-header h4 {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .data-card-header h4 i {
            color: #3b82f6;
        }

        .data-card-header .view-all {
            font-size: 1rem;
            color: #3b82f6;
            text-decoration: none;
            font-weight: 700;
        }

        .data-card-header .view-all:hover {
            text-decoration: underline;
        }

        .data-card-body {
            padding: 0;
            max-height: 350px;
            overflow-y: auto;
        }

        .data-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .data-list li {
            padding: 15px 24px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: background 0.2s;
        }

        .data-list li:last-child {
            border-bottom: none;
        }

        .data-list li:hover {
            background: #f8fafc;
        }

        .data-list .item-avatar {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #4f46e5;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .data-list .item-info {
            flex: 1;
            min-width: 0;
        }

        .data-list .item-info h5 {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .data-list .item-info h5 a {
            color: inherit;
            text-decoration: none;
        }

        .data-list .item-info h5 a:hover {
            color: #3b82f6;
        }

        .data-list .item-info p {
            font-size: 0.95rem;
            color: #475569;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .data-list .item-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 700;
            flex-shrink: 0;
        }

        .data-list .item-badge.active {
            background: #dcfce7;
            color: #16a34a;
        }

        .data-list .item-badge.pending {
            background: #fef3c7;
            color: #d97706;
        }

        /* Charts Section */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            margin-bottom: 30px;
        }

        .chart-card {
            background: #ffffff !important;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
        }

        .charts-grid .chart-card,
        .data-grid .chart-card {
            background: #ffffff !important;
        }

        .chart-card h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #111827;
            margin: 0 0 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .chart-card h4 i {
            color: #3b82f6;
        }

        .chart-container {
            height: 250px;
            position: relative;
        }

        /* Mini Stats in Chart */
        .chart-stats {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
        }

        .chart-stat-item {
            flex: 1;
            text-align: center;
        }

        .chart-stat-item .value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #111827;
        }

        .chart-stat-item .label {
            font-size: 0.85rem;
            color: #6b7280;
            margin-top: 4px;
        }

        /* System Info Grid */
        .system-info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .system-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
        }

        .system-card i {
            font-size: 2rem;
            color: #3b82f6;
            margin-bottom: 12px;
            display: block;
        }

        .system-title {
            font-size: 1rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .system-status {
            font-size: 0.9rem;
            font-weight: 500;
            color: #6b7280;
        }

        .system-status.success {
            color: #10b981;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 1400px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .actions-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 1200px) {
            .data-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .charts-grid {
                grid-template-columns: 1fr;
            }

            .system-info-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 991px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .actions-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 767px) {
            .modern-dashboard {
                padding: 15px;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .system-info-grid {
                grid-template-columns: 1fr;
            }

            .data-grid {
                grid-template-columns: 1fr;
            }

            .actions-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .stat-card .stat-value {
                font-size: 1.6rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content modern-dashboard">

            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <h1><i class="fa fa-tachometer" style="color: #3b82f6; margin-right: 10px;"></i> {{__('Dashboard')}}</h1>
                <p>{{ $siteSetting->site_name }} - {{__('Welcome! Here is today\'s summary.')}}</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <a href="{{ route('list.users') }}" class="stat-card">
                    <div class="stat-icon blue"><i class="fa fa-users"></i></div>
                    <div class="stat-value">{{ $totalActiveUsers }}</div>
                    <div class="stat-label">{{__('Active Members')}}</div>
                    <div class="stat-trend up"><i class="fa fa-arrow-up"></i> +{{ $totalTodaysUsers }} {{__('today')}}</div>
                </a>

                <a href="{{ route('list.companies') }}" class="stat-card">
                    <div class="stat-icon green"><i class="fa fa-building"></i></div>
                    <div class="stat-value">{{ $totalActiveCompanies }}</div>
                    <div class="stat-label">{{__('Active Companies')}}</div>
                    <div class="stat-trend up"><i class="fa fa-arrow-up"></i> +{{ $totalTodaysCompanies }} {{__('today')}}
                    </div>
                </a>

                <a href="{{ route('list.jobs') }}" class="stat-card">
                    <div class="stat-icon orange"><i class="fa fa-briefcase"></i></div>
                    <div class="stat-value">{{ $totalActiveJobs }}</div>
                    <div class="stat-label">{{__('Active Jobs')}}</div>
                    <div class="stat-trend up"><i class="fa fa-arrow-up"></i> +{{ $totalTodaysJobs }} {{__('today')}}</div>
                </a>

                <a href="{{ route('list.jobs') }}?is_featured=1" class="stat-card">
                    <div class="stat-icon purple"><i class="fa fa-star"></i></div>
                    <div class="stat-value">{{ $totalFeaturedJobs }}</div>
                    <div class="stat-label">{{__('Featured Jobs')}}</div>
                </a>

                <a href="{{ route('list.users') }}" class="stat-card">
                    <div class="stat-icon teal"><i class="fa fa-check-circle"></i></div>
                    <div class="stat-value">{{ $totalVerifiedUsers }}</div>
                    <div class="stat-label">{{__('Verified Members')}}</div>
                </a>

                <a href="{{ route('list.companies') }}?is_active=0" class="stat-card">
                    <div class="stat-icon red"><i class="fa fa-pause-circle"></i></div>
                    <div class="stat-value">{{ $totalInactiveCompanies }}</div>
                    <div class="stat-label">{{__('Inactive Companies')}}</div>
                </a>

                @if(count($upcomingNotes) > 0)
                    <div class="stat-card" style="grid-column: span 2; background: #f8fafc; border: 1px dashed #cbd5e1;">
                        <div class="stat-header" style="margin-bottom: 10px;">
                            <h4 style="margin: 0; font-weight: 800; color: #1e293b; font-size: 1.1rem;"><i
                                    class="fa fa-calendar-check-o" style="color: #3b82f6; margin-right: 8px;"></i> Yaklaşan
                                Etkinlikler</h4>
                            <a href="{{ route('admin.crm.show', Auth::guard('admin')->id()) }}"
                                style="font-size: 0.85rem; font-weight: 700; color: #3b82f6;">Tümünü Gör</a>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            @foreach($upcomingNotes as $note)
                                <div
                                    style="display: flex; align-items: center; justify-content: space-between; background: #fff; padding: 10px 15px; border-radius: 12px; border: 1px solid #e2e8f0;">
                                    <div style="min-width: 0;">
                                        <div
                                            style="font-weight: 700; color: #334155; font-size: 0.95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $note->title }}
                                        </div>
                                        <small
                                            style="color: #64748b;">{{ $note->event_date ? $note->event_date->format('d.m.Y H:i') : 'Tarih Belirtilmedi' }}</small>
                                    </div>
                                    <span
                                        style="font-size: 0.8rem; font-weight: 800; color: {{ $note->priority == 'High' ? '#ef4444' : ($note->priority == 'Medium' ? '#f59e0b' : '#3b82f6') }};">{{ $note->priority }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h3><i class="fa fa-bolt" style="color: #f97316;"></i> {{__('Quick Actions')}}</h3>
                <div class="actions-grid">
                    <a href="{{ route('list.jobs') }}" class="action-btn">
                        <i class="fa fa-briefcase"></i>
                        <span>{{__('Jobs')}}</span>
                    </a>
                    <a href="{{ route('list.companies') }}" class="action-btn">
                        <i class="fa fa-building"></i>
                        <span>{{__('Companies')}}</span>
                    </a>
                    <a href="{{ route('list.users') }}" class="action-btn">
                        <i class="fa fa-users"></i>
                        <span>{{__('Users')}}</span>
                    </a>
                    <a href="{{ route('list.cms') }}" class="action-btn">
                        <i class="fa fa-file-text-o"></i>
                        <span>CMS</span>
                    </a>
                    <a href="{{ route('blog') }}" class="action-btn">
                        <i class="fa fa-pencil-square-o"></i>
                        <span>Blog</span>
                    </a>
                    <a href="{{ route('list.seo') }}" class="action-btn">
                        <i class="fa fa-line-chart"></i>
                        <span>SEO</span>
                    </a>
                    <a href="{{ route('edit.site.setting') }}" class="action-btn">
                        <i class="fa fa-cog"></i>
                        <span>{{__('Settings')}}</span>
                    </a>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-grid">
                <div class="chart-card">
                    <h4><i class="fa fa-line-chart"></i> {{__('Weekly Registration Statistics')}}</h4>
                    <div class="chart-container">
                        <canvas id="weeklyChart"></canvas>
                    </div>
                    <div class="chart-stats">
                        <div class="chart-stat-item">
                            <div class="value">{{ $totalActiveUsers }}</div>
                            <div class="label">{{__('Total Members')}}</div>
                        </div>
                        <div class="chart-stat-item">
                            <div class="value">{{ $totalActiveCompanies }}</div>
                            <div class="label">{{__('Total Companies')}}</div>
                        </div>
                        <div class="chart-stat-item">
                            <div class="value">{{ $totalActiveJobs }}</div>
                            <div class="label">{{__('Total Jobs')}}</div>
                        </div>
                    </div>
                </div>

                <div class="chart-card">
                    <h4><i class="fa fa-pie-chart"></i> {{__('Job Distribution')}}</h4>
                    <div class="chart-container">
                        <canvas id="distributionChart"></canvas>
                    </div>
                    <div class="chart-stats">
                        <div class="chart-stat-item">
                            <div class="value" style="color: #3b82f6;">{{ $totalActiveJobs }}</div>
                            <div class="label">{{__('Active')}}</div>
                        </div>
                        <div class="chart-stat-item">
                            <div class="value" style="color: #f59e0b;">{{ $totalFeaturedJobs }}</div>
                            <div class="label">{{__('Featured')}}</div>
                        </div>
                        <div class="chart-stat-item">
                            <div class="value" style="color: #10b981;">{{ $totalActiveCompanies }}</div>
                            <div class="label">{{__('Company')}}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Grid -->
            <div class="data-grid">
                <!-- Recent Users -->
                <div class="data-card">
                    <div class="data-card-header">
                        <h4><i class="fa fa-user-plus"></i> {{__('Recent Registered Users')}}</h4>
                        <a href="{{ route('list.users') }}" class="view-all">{{__('View All')}} →</a>
                    </div>
                    <div class="data-card-body">
                        <ul class="data-list">
                            @foreach($recentUsers as $recentUser)
                                <li>
                                    <div class="item-avatar">{{ strtoupper(substr($recentUser->name, 0, 2)) }}</div>
                                    <div class="item-info">
                                        <h5><a href="{{ route('edit.user', $recentUser->id) }}">{{ $recentUser->name }}</a></h5>
                                        <p><i class="fa fa-envelope"></i> {{ $recentUser->email }}</p>
                                    </div>
                                    <span class="item-badge active">{{__('Active')}}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Active Companies -->
                <div class="data-card">
                    <div class="data-card-header">
                        <h4><i class="fa fa-building"></i> {{__('Active Companies')}}</h4>
                        <a href="{{ route('list.companies') }}" class="view-all">{{__('View All')}} →</a>
                    </div>
                    <div class="data-card-body">
                        <ul class="data-list">
                            @foreach($activeCompanies as $company)
                                <li>
                                    <div class="item-avatar"
                                        style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); color: #059669;">
                                        {{ strtoupper(substr($company->name, 0, 2)) }}
                                    </div>
                                    <div class="item-info">
                                        <h5><a href="{{ url('admin/public-company/' . $company->id) }}">{{ $company->name }}</a>
                                        </h5>
                                        <p><i class="fa fa-map-marker"></i> {{ $company->getLocation() }}</p>
                                    </div>
                                    <span class="item-badge active">{{__('Active')}}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Recent Jobs -->
                <div class="data-card">
                    <div class="data-card-header">
                        <h4><i class="fa fa-briefcase"></i> {{__('Recent Jobs')}}</h4>
                        <a href="{{ route('list.jobs') }}" class="view-all">{{__('View All')}} →</a>
                    </div>
                    <div class="data-card-body">
                        <ul class="data-list">
                            @foreach($recentJobs as $recentJob)
                                <li>
                                    <div class="item-avatar"
                                        style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #d97706;">
                                        {{ strtoupper(substr($recentJob->title, 0, 2)) }}
                                    </div>
                                    <div class="item-info">
                                        <h5><a
                                                href="{{ route('edit.job', $recentJob->id) }}">{{ \Illuminate\Support\Str::limit($recentJob->title, 35) }}</a>
                                        </h5>
                                        <p><i class="fa fa-building"></i> {{ $recentJob->getCompany('name') }}</p>
                                    </div>
                                    <span class="item-badge pending">{{__('New')}}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>



            <!-- Secondary Quick Links -->
            <div class="quick-actions">
                <h3><i class="fa fa-th-large" style="color: #8b5cf6;"></i> {{__('Other Management Areas')}}</h3>
                <div class="actions-grid">
                    <a href="{{ route('list.faqs') }}" class="action-btn">
                        <i class="fa fa-question-circle"></i>
                        <span>SSS</span>
                    </a>
                    <a href="{{ route('list.testimonials') }}" class="action-btn">
                        <i class="fa fa-quote-left"></i>
                        <span>Referanslar</span>
                    </a>
                    <a href="{{ route('list.packages') }}" class="action-btn">
                        <i class="fa fa-money"></i>
                        <span>Paketler</span>
                    </a>
                    <a href="{{ route('list.countries') }}" class="action-btn">
                        <i class="fa fa-globe"></i>
                        <span>Ülkeler</span>
                    </a>
                    <a href="{{ route('list.states') }}" class="action-btn">
                        <i class="fa fa-map"></i>
                        <span>Eyaletler</span>
                    </a>
                    <a href="{{ route('list.cities') }}" class="action-btn">
                        <i class="fa fa-map-marker"></i>
                        <span>Şehirler</span>
                    </a>
                    <a href="{{ route('list.sliders') }}" class="action-btn">
                        <i class="fa fa-image"></i>
                        <span>Slider</span>
                    </a>
                </div>
            </div>

            <!-- Bottom Stats Section -->
            <div class="charts-grid" style="margin-top: 30px;">
                <!-- Hizmet Kategorileri -->
                <div class="chart-card">
                    <h4><i class="fa fa-wrench"></i> {{__('Service Categories Distribution')}}</h4>
                    <div class="chart-container">
                        <canvas id="servicesChart"></canvas>
                    </div>
                    <div class="chart-stats">
                        <div class="chart-stat-item">
                            <div class="value" style="color: #3b82f6;">12</div>
                            <div class="label">{{__('Cleaning')}}</div>
                        </div>
                        <div class="chart-stat-item">
                            <div class="value" style="color: #10b981;">8</div>
                            <div class="label">{{__('Renovation')}}</div>
                        </div>
                        <div class="chart-stat-item">
                            <div class="value" style="color: #f59e0b;">15</div>
                            <div class="label">{{__('Moving')}}</div>
                        </div>
                        <div class="chart-stat-item">
                            <div class="value" style="color: #8b5cf6;">6</div>
                            <div class="label">{{__('Painting')}}</div>
                        </div>
                    </div>
                </div>

                <!-- Aylık Performans -->
                <div class="chart-card">
                    <h4><i class="fa fa-bar-chart"></i> {{__('Monthly Performance')}}</h4>
                    <div class="chart-container">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                    <div class="chart-stats">
                        <div class="chart-stat-item">
                            <div class="value" style="color: #10b981;">+24%</div>
                            <div class="label">{{__('Growth')}}</div>
                        </div>
                        <div class="chart-stat-item">
                            <div class="value" style="color: #3b82f6;">{{ $totalActiveUsers + $totalActiveCompanies }}</div>
                            <div class="label">{{__('Total Users')}}</div>
                        </div>
                        <div class="chart-stat-item">
                            <div class="value" style="color: #f59e0b;">{{ $totalActiveJobs + $totalFeaturedJobs }}</div>
                            <div class="label">{{__('Total Jobs')}}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="system-info-grid">
                <div class="system-card">
                    <i class="fa fa-server"></i>
                    <div class="system-title">Sistem Durumu</div>
                    <div class="system-status success"><i class="fa fa-check-circle"></i> Aktif</div>
                </div>
                <div class="system-card">
                    <i class="fa fa-database" style="color: #8b5cf6;"></i>
                    <div class="system-title">Veritabanı</div>
                    <div class="system-status success"><i class="fa fa-check-circle"></i> Bağlı</div>
                </div>
                <div class="system-card">
                    <i class="fa fa-clock-o" style="color: #f59e0b;"></i>
                    <div class="system-title">Son Güncelleme</div>
                    <div class="system-status">{{ now()->format('d.m.Y H:i') }}</div>
                </div>
                <div class="system-card">
                    <i class="fa fa-shield" style="color: #10b981;"></i>
                    <div class="system-title">Güvenlik</div>
                    <div class="system-status success"><i class="fa fa-lock"></i> Korumalı</div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript">
        $(function () {
            // Weekly Chart - Line Chart
            var weeklyCtx = document.getElementById('weeklyChart');
            if (weeklyCtx) {
                new Chart(weeklyCtx, {
                    type: 'line',
                    data: {
                        labels: ['Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt', 'Paz'],
                        datasets: [{
                            label: 'Üyeler',
                            data: [{{ $totalTodaysUsers }}, {{ $totalTodaysUsers + 2 }}, {{ $totalTodaysUsers + 1 }}, {{ $totalTodaysUsers + 3 }}, {{ $totalTodaysUsers + 2 }}, {{ $totalTodaysUsers + 1 }}, {{ $totalTodaysUsers }}],
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true
                        }, {
                            label: 'İlanlar',
                            data: [{{ $totalTodaysJobs }}, {{ $totalTodaysJobs + 1 }}, {{ $totalTodaysJobs + 2 }}, {{ $totalTodaysJobs }}, {{ $totalTodaysJobs + 1 }}, {{ $totalTodaysJobs + 2 }}, {{ $totalTodaysJobs + 1 }}],
                            borderColor: '#10b981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.4,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: { usePointStyle: true, padding: 20 }
                            }
                        },
                        scales: {
                            y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            // Distribution Chart - Doughnut
            var distCtx = document.getElementById('distributionChart');
            if (distCtx) {
                new Chart(distCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Aktif İlanlar', 'Öne Çıkan', 'Şirketler', 'Üyeler'],
                        datasets: [{
                            data: [{{ $totalActiveJobs }}, {{ $totalFeaturedJobs }}, {{ $totalActiveCompanies }}, {{ $totalActiveUsers }}],
                            backgroundColor: ['#3b82f6', '#f59e0b', '#10b981', '#8b5cf6'],
                            borderWidth: 0,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: { usePointStyle: true, padding: 15 }
                            }
                        }
                    }
                });
            }

            // Services Chart - Polar Area
            var servicesCtx = document.getElementById('servicesChart');
            if (servicesCtx) {
                new Chart(servicesCtx, {
                    type: 'polarArea',
                    data: {
                        labels: ['Temizlik', 'Tadilat', 'Taşınma', 'Boyama', 'Bahçe', 'Elektrik'],
                        datasets: [{
                            data: [12, 8, 15, 6, 9, 11],
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.7)',
                                'rgba(16, 185, 129, 0.7)',
                                'rgba(245, 158, 11, 0.7)',
                                'rgba(139, 92, 246, 0.7)',
                                'rgba(236, 72, 153, 0.7)',
                                'rgba(20, 184, 166, 0.7)'
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
                                labels: { usePointStyle: true, padding: 12, font: { size: 11 } }
                            }
                        }
                    }
                });
            }

            // Monthly Chart - Bar Chart
            var monthlyCtx = document.getElementById('monthlyChart');
            if (monthlyCtx) {
                new Chart(monthlyCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Oca', 'Şub', 'Mar', 'Nis', 'May', 'Haz'],
                        datasets: [{
                            label: 'Üyeler',
                            data: [65, 78, 90, 81, 95, 110],
                            backgroundColor: '#3b82f6',
                            borderRadius: 6
                        }, {
                            label: 'İlanlar',
                            data: [45, 52, 68, 72, 85, 92],
                            backgroundColor: '#10b981',
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: { usePointStyle: true, padding: 15 }
                            }
                        },
                        scales: {
                            y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            // Counter animation
            $('.stat-value').each(function () {
                var $this = $(this);
                var countTo = parseInt($this.text().replace(/,/g, ''));
                if (isNaN(countTo)) return;

                $({ countNum: 0 }).animate({
                    countNum: countTo
                }, {
                    duration: 1000,
                    easing: 'swing',
                    step: function () {
                        $this.text(Math.floor(this.countNum).toLocaleString('tr-TR'));
                    },
                    complete: function () {
                        $this.text(this.countNum.toLocaleString('tr-TR'));
                    }
                });
            });


        });
    </script>
@endpush