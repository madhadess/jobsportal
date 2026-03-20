@extends('layouts.app')

@section('content') 
<!-- Header start --> 
@include('includes.header') 
<!-- Header end --> 

@push('styles')
<style>
    .payment-history-table thead.table-dark {
        background: #000;
    }

    .payment-history-table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        border: 1px solid #eee;
        font-size: 14px;
    }

    .payment-history-table th {
        color: #fff;
        padding: 8px 10px;
        border-right: 1px solid #eee;
    }

    .payment-history-table td {
        padding: 8px 10px;
        text-align: center;
        border-top: 1px solid #eee;
    }

    .payment-history-table .btn-primary {
        padding: 7px 15px;
        font-size: 14px;
    }
</style>
@endpush


<!-- Inner Page Title start --> 
@include('includes.inner_page_title', ['page_title' => __('Payment History')]) 
<!-- Inner Page Title end -->
<div class="listpgWraper payment-history-wrap">
    <div class="container">
        <div class="row">
            @include('includes.company_dashboard_menu')
            <div class="col-md-9 col-sm-8 company-dashboard-content"> 
                @include('flash::message') 
                <table class="table table-striped table-bordered table-hover payment-history-table">
                    <thead class="table-dark">
                        <tr>
                            <th>Paket Adı</th>
                            <th>Fiyat</th>
                            <th>İlan Kotası</th>
                            <th>Ödeme Yöntemi</th>
                            <th>Paket Başlangıç Tarihi</th>
                            <th>Paket Bitiş Tarihi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($companies as $company)
                            <tr>
                                <td>{{ $company->package->package_title ?? 'N/A' }}</td>
                                <td>{{ $company->package->package_price ?? 'N/A' }} {{ $siteSetting->default_currency_code ?? '' }}</td>
                                <td>{{ $company->jobs_quota ?? 'N/A' }}</td>
                                <td>
                                    @if (!empty($company->payment_method) && $company->payment_method !== 'offline')
                                        {{ __($company->payment_method) }}
                                    @else
                                        {{ __('Çevrim Dışı (Admin tarafından eklendi)') }}
                                    @endif
                                </td>
                                <td>{{ $company->package_start_date ? \Carbon\Carbon::parse($company->package_start_date)->translatedFormat('d F Y') : 'N/A' }}</td>
                                <td>{{ $company->package_end_date ? \Carbon\Carbon::parse($company->package_end_date)->translatedFormat('d F Y') : 'N/A' }}</td>
                                
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Kayıt bulunamadı</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



@include('includes.footer')
@endsection

@push('scripts')
<!-- jsPDF Library -->



@endpush


