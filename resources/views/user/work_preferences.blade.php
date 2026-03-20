@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title' => __('Çalışma Tercihlerim')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container">
            <div class="row">
                @include('includes.user_dashboard_menu')
                <div class="col-lg-9">
                    <div class="userccount">
                        <div class="formpanel mt-0">
                            <h3>{{__('Otomatik İş Eşleştirme Tercihleri')}}</h3>
                            <p>{{__('Hizmet taleplerinin size otomatik olarak atanması için tercihlerinizi buradan güncelleyebilirsiniz.')}}
                            </p>
                            <hr>
                            <form action="{{ route('personnel.update_preferences') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="formrow">
                                            <label
                                                class="d-block mb-2"><strong>{{__('Otomatik Atama Durumu')}}</strong></label>
                                            <div class="radio-list mt-2 mb-2">
                                                <label class="radio-inline mr-3" style="margin-right: 15px;">
                                                    <input type="radio" name="is_eligible_for_auto_assignment" value="1" {{ $user->is_eligible_for_auto_assignment ? 'checked' : '' }}> {{__('Aktif')}}
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="is_eligible_for_auto_assignment" value="0" {{ !$user->is_eligible_for_auto_assignment ? 'checked' : '' }}> {{__('Pasif')}}
                                                </label>
                                            </div>
                                            <span
                                                class="help-block text-muted d-block mt-1">{{__('Aktif edildiğinde, yetkinliklerinize uygun işler size otomatik olarak atanacaktır.')}}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="formrow">
                                            <label><strong>{{__('Verdiğiniz Hizmetler')}}</strong></label>
                                            <select name="service_types[]" class="form-control select2-multiple"
                                                multiple="multiple" style="height: 150px;">
                                                @foreach($services as $service)
                                                    <option value="{{ $service->id }}" {{ is_array($user->service_types) && in_array($service->id, $user->service_types) ? 'selected' : '' }}>
                                                        {{ $service->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="formrow">
                                            <label><strong>{{__('Hizmet Verdiğiniz İller')}}</strong></label>
                                            <select name="work_locations[]" class="form-control select2-multiple"
                                                multiple="multiple" style="height: 150px;">
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}" {{ is_array($user->work_locations) && in_array($state->id, $user->work_locations) ? 'selected' : '' }}>
                                                        {{ $state->state }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="formrow">
                                            <label><strong>{{__('Günlük Maksimum İş Sayısı')}}</strong></label>
                                            <input type="number" name="max_daily_tasks" class="form-control"
                                                value="{{ $user->max_daily_tasks ?? 5 }}" min="1" max="20">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <hr>
                                        <div class="formrow">
                                            <label><strong>{{__('Müsaitlik Takvimi')}}</strong></label>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>{{__('Gün')}}</th>
                                                            <th>{{__('Durum')}}</th>
                                                            <th>{{__('Başlangıç Saat')}}</th>
                                                            <th>{{__('Bitiş Saat')}}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $days = [
                                                                'monday' => 'Pazartesi',
                                                                'tuesday' => 'Salı',
                                                                'wednesday' => 'Çarşamba',
                                                                'thursday' => 'Perşembe',
                                                                'friday' => 'Cuma',
                                                                'saturday' => 'Cumartesi',
                                                                'sunday' => 'Pazar'
                                                            ];
                                                            $calendar = $user->getAvailabilitySchedule();
                                                        @endphp
                                                        @foreach($days as $key => $label)
                                                            <tr>
                                                                <td>{{ __($label) }}</td>
                                                                <td>
                                                                    <input type="checkbox" name="availability_calendar[{{ $key }}][active]" value="1" {{ $calendar[$key]['active'] ? 'checked' : '' }}>
                                                                </td>
                                                                <td>
                                                                    <input type="time" name="availability_calendar[{{ $key }}][start]" class="form-control" value="{{ $calendar[$key]['start'] ?? '08:00' }}">
                                                                </td>
                                                                <td>
                                                                    <input type="time" name="availability_calendar[{{ $key }}][end]" class="form-control" value="{{ $calendar[$key]['end'] ?? '20:00' }}">
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="formrow">
                                            <button type="submit"
                                                class="btn btn-primary">{{__('Tercihlerimi Güncelle')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection
@push('styles')
    <style type="text/css">
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ced4da;
            min-height: 100px;
        }
    </style>
@endpush