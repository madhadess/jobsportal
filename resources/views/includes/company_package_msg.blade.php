<div class="instoretxt">

  <h3>{{__('Satın Alınan İlan Paketi Detayları')}}</h3>
  <div class="table-responsive">
    <table class="table table-bordered mb-0">
      <thead class="table-dark">
        <tr>
          <th scope="col">{{__('Paket Adı')}}</th>
          <th scope="col">{{__('Fiyat')}}</th>
          <th scope="col">{{__('Kullanılabilir Kota')}}</th>
          <th scope="col">{{__('Satın Alma Tarihi')}}</th>
          <th scope="col">{{__('Paket Bitiş Tarihi')}}</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>{{$package->package_title}}</th>
          <td>{{ $package->package_price }} ₺</td>
          <td>
            <strong>{{ Auth::guard('company')->user()->availed_jobs_quota }}</strong> /
            <strong>{{ Auth::guard('company')->user()->jobs_quota }}</strong>
          </td>
          <td>
            <strong>{{ $company->package_start_date ? \Carbon\Carbon::parse($company->package_start_date)->translatedFormat('d F Y') : '' }}</strong>
          </td>
          <td>
            <strong>{{ $company->package_end_date ? \Carbon\Carbon::parse($company->package_end_date)->translatedFormat('d F Y') : '' }}</strong>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>