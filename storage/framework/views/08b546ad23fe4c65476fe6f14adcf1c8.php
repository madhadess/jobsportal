
<?php $__env->startSection('content'); ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li> <a href="<?php echo e(route('admin.home')); ?>">Anasayfa</a> <i class="fa fa-circle"></i> </li>
                    <li> <span>Sistem Güvenlik Ayarları</span> </li>
                </ul>
            </div>

            <h3 class="page-title"> Güvenlik Mesaj Merkesi <small>Sistem Kritik Ayarı</small> </h3>

            <div class="row">
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo">
                                <i class="icon-settings font-red-sunglo"></i>
                                <span class="caption-subject bold uppercase"> Güvenlik Konfigürasyonu</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form action="<?php echo e(route('admin.security.update')); ?>" method="POST" role="form">
                                <?php echo csrf_field(); ?>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label>Bakım Modu</label>
                                        <select name="maintenance_mode" class="form-control">
                                            <option value="0" <?php echo e(($configs->where('key', 'maintenance_mode')->first()->value ?? '0') == '0' ? 'selected' : ''); ?>>Kapalı</option>
                                            <option value="1" <?php echo e(($configs->where('key', 'maintenance_mode')->first()->value ?? '0') == '1' ? 'selected' : ''); ?>>Açık</option>
                                        </select>
                                        <p class="help-block">Sistemi tüm kullanıcılar için kapatır (Yalnızca Adminler
                                            girebilir).</p>
                                    </div>

                                    <div class="form-group">
                                        <label>IP Beyaz Listesi (Whitelist)</label>
                                        <textarea name="ip_whitelist" class="form-control" rows="3"
                                            placeholder="Örn: 127.0.0.1, 192.168.1.1"><?php echo e($configs->where('key', 'ip_whitelist')->first()->value ?? ''); ?></textarea>
                                        <p class="help-block">Virgülle ayırarak giriniz.</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Admin Oturum Süresi (Dakika)</label>
                                        <input type="number" name="admin_session_lifetime" class="form-control"
                                            value="<?php echo e($configs->where('key', 'admin_session_lifetime')->first()->value ?? '120'); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Brute Force Koruması (Hatalı Giriş Sınırı)</label>
                                        <input type="number" name="login_attempts_limit" class="form-control"
                                            value="<?php echo e($configs->where('key', 'login_attempts_limit')->first()->value ?? '5'); ?>">
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn blue">Ayarları Kaydet</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-blue">
                                <i class="icon-clock font-blue"></i>
                                <span class="caption-subject bold uppercase"> Personel & Mesai Ayarları</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form action="<?php echo e(route('admin.security.update')); ?>" method="POST" role="form">
                                <?php echo csrf_field(); ?>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label>Mesai Başlangıç Saati</label>
                                        <input type="time" name="work_start_time" class="form-control"
                                            value="<?php echo e($configs->where('key', 'work_start_time')->first()->value ?? '09:00'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Mesai Bitiş Saati</label>
                                        <input type="time" name="work_end_time" class="form-control"
                                            value="<?php echo e($configs->where('key', 'work_end_time')->first()->value ?? '18:00'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Günlük Mola Hakkı (Dakika)</label>
                                        <input type="number" name="daily_break_limit" class="form-control"
                                            value="<?php echo e($configs->where('key', 'daily_break_limit')->first()->value ?? '60'); ?>">
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn blue">Mesai Ayarlarını Kaydet</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-shield font-blue"></i>
                                <span class="caption-subject font-blue bold uppercase"> Güvenlik Bilgilendirme</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="alert alert-warning">
                                <strong>Önemli:</strong> Bu sayfadaki ayarlar sistemin temel güvenliğini etkiler. Değişiklik
                                yaparken dikkatli olun.
                            </div>
                            <p>Bu modül sadece <strong>Süper Admin</strong> yetkisine sahip kullanıcılar tarafından
                                görülebilir ve yönetilebilir. Standart moderatörlerin bu ayarları değiştirme veya sayfayı
                                görme yetkisi yoktur.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/security/index.blade.php ENDPATH**/ ?>