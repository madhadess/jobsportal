@extends('admin.layouts.admin_layout')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li><a href="{{ route('admin.home') }}">Ana Sayfa</a><i class="fa fa-circle"></i></li>
                <li><span>Eşleşme Kural Ağırlıkları</span></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">Eşleşme Kural Ağırlıkları</span>
                        </div>
                        <div class="actions">
                            <form action="{{ route('admin.match-rules.reset') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-warning"
                                    onclick="return confirm('Varsayılan değerlere sıfırlanacak. Devam?')">
                                    <i class="fa fa-refresh"></i> Varsayılana Sıfırla
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="portlet-body">
                        @php
                            $totalColor = abs($total - 100) <= 0.5 ? 'success' : 'danger';
                        @endphp
                        <div class="alert alert-{{ $totalColor }}" style="margin-bottom:20px;">
                            <strong>Toplam Ağırlık: %{{ $total }}</strong>
                            @if(abs($total - 100) <= 0.5)
                                — ✅ Dengeli (ideal: %100)
                            @else
                                — ⚠️ Toplam %100 olmalı! Fark: {{ round(abs($total - 100), 1) }}%
                            @endif
                        </div>

                        {{-- Visual weights chart --}}
                        <div class="weight-chart" style="margin-bottom:25px;">
                            @foreach($rules as $rule)
                                @if($rule->is_active)
                                <div style="margin-bottom:10px;">
                                    <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:3px;">
                                        <span style="font-weight:600;">{{ $rule->rule_label }}</span>
                                        <span>%{{ $rule->weight }}</span>
                                    </div>
                                    <div style="background:#f3f4f6;border-radius:6px;height:10px;overflow:hidden;">
                                        <div style="width:{{ $rule->weight }}%;height:100%;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:6px;"></div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kural Anahtarı</th>
                                    <th>Etiket</th>
                                    <th>Ağırlık (%)</th>
                                    <th>Aktif</th>
                                    <th>Güncelle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rules as $rule)
                                    <tr>
                                        <td><code>{{ $rule->rule_key }}</code></td>
                                        <td>{{ $rule->rule_label }}</td>
                                        <td>
                                            <form action="{{ route('admin.match-rules.update', $rule->id) }}" method="POST" class="form-inline">
                                                @csrf @method('PUT')
                                                <input type="number" name="weight" value="{{ $rule->weight }}"
                                                    min="0" max="100" step="1" style="width:80px;" class="form-control input-sm">
                                        </td>
                                        <td>
                                                <div class="toggle">
                                                    <input type="hidden" name="is_active" value="0">
                                                    <input type="checkbox" name="is_active" value="1" {{ $rule->is_active ? 'checked' : '' }}
                                                        class="toggle-checkbox">
                                                </div>
                                        </td>
                                        <td>
                                                <button type="submit" class="btn btn-xs btn-primary">
                                                    <i class="fa fa-save"></i> Kaydet
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="alert alert-info" style="margin-top:15px; font-size:13px;">
                            <i class="fa fa-info-circle"></i>
                            Ağırlıklar toplamı <strong>%100</strong> olmalıdır.
                            Değişiklikler yeni yapılan başvurularda hemen uygulanır.
                            Mevcut başvuruların skorları güncellenmez.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
