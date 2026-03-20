<div class="instoretxt">

  <h3><?php echo e(__('Satın Alınan İlan Paketi Detayları')); ?></h3>
  <div class="table-responsive">
    <table class="table table-bordered mb-0">
      <thead class="table-dark">
        <tr>
          <th scope="col"><?php echo e(__('Paket Adı')); ?></th>
          <th scope="col"><?php echo e(__('Fiyat')); ?></th>
          <th scope="col"><?php echo e(__('Kullanılabilir Kota')); ?></th>
          <th scope="col"><?php echo e(__('Satın Alma Tarihi')); ?></th>
          <th scope="col"><?php echo e(__('Paket Bitiş Tarihi')); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th><?php echo e($package->package_title); ?></th>
          <td><?php echo e($package->package_price); ?> ₺</td>
          <td>
            <strong><?php echo e(Auth::guard('company')->user()->availed_jobs_quota); ?></strong> /
            <strong><?php echo e(Auth::guard('company')->user()->jobs_quota); ?></strong>
          </td>
          <td>
            <strong><?php echo e($company->package_start_date ? \Carbon\Carbon::parse($company->package_start_date)->translatedFormat('d F Y') : ''); ?></strong>
          </td>
          <td>
            <strong><?php echo e($company->package_end_date ? \Carbon\Carbon::parse($company->package_end_date)->translatedFormat('d F Y') : ''); ?></strong>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div><?php /**PATH /home/personelnoktasit/public_html/resources/views/includes/company_package_msg.blade.php ENDPATH**/ ?>