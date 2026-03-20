@extends('admin.layouts.admin_layout')

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Modern DataTables Örneği</h1>
            </div>
        </div>

        <!-- Sayfa Geçiş Butonları -->
        <div class="page-navigation">
            <h3>📊 Admin Panel Sayfaları</h3>
            <div class="nav-buttons">
                <a href="{{ route('admin.home') }}" class="nav-btn primary">
                    <i class="fa fa-home"></i> Ana Sayfa
                </a>
                <a href="#" class="nav-btn success">
                    <i class="fa fa-users"></i> Kullanıcılar
                </a>
                <a href="#" class="nav-btn warning">
                    <i class="fa fa-briefcase"></i> İş İlanları
                </a>
                <a href="#" class="nav-btn info">
                    <i class="fa fa-building"></i> Şirketler
                </a>
                <a href="#" class="nav-btn danger">
                    <i class="fa fa-cog"></i> Ayarlar
                </a>
                <a href="#" class="nav-btn">
                    <i class="fa fa-chart-bar"></i> Raporlar
                </a>
                <a href="#" class="nav-btn">
                    <i class="fa fa-envelope"></i> Mesajlar
                </a>
                <a href="#" class="nav-btn">
                    <i class="fa fa-file-alt"></i> Sayfalar
                </a>
            </div>
        </div>

        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject font-dark sbold uppercase">Premium DataTables</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-responsive" style="overflow-x: auto !important; -webkit-overflow-scrolling: touch;">
                    <table class="table table-striped table-hover table-bordered" id="modern-datatable" style="min-width: 900px;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Başlık</th>
                                <th>Açıklama</th>
                                <th>Durum</th>
                                <th>Tarih</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Modern DataTables Örneği</td>
                                <td>Premium tasarım ile geliştirilmiş tablo örneği.</td>
                                <td><span class="badge badge-success">Aktif</span></td>
                                <td>01.01.2024</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i> Düzenle
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i> Sil
                                        </button>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a href="#"><i class="fa fa-eye"></i> Görüntüle</a></li>
                                                <li><a href="#"><i class="fa fa-copy"></i> Kopyala</a></li>
                                                <li><a href="#"><i class="fa fa-download"></i> İndir</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Responsive Tasarım</td>
                                <td>Mobil uyumlu ve modern arayüz.</td>
                                <td><span class="badge badge-warning">Pasif</span></td>
                                <td>02.01.2024</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i> Düzenle
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i> Sil
                                        </button>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a href="#"><i class="fa fa-eye"></i> Görüntüle</a></li>
                                                <li><a href="#"><i class="fa fa-copy"></i> Kopyala</a></li>
                                                <li><a href="#"><i class="fa fa-download"></i> İndir</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Export Özellikleri</td>
                                <td>Excel, PDF, CSV export desteği.</td>
                                <td><span class="badge badge-success">Aktif</span></td>
                                <td>03.01.2024</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i> Düzenle
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i> Sil
                                        </button>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a href="#"><i class="fa fa-eye"></i> Görüntüle</a></li>
                                                <li><a href="#"><i class="fa fa-copy"></i> Kopyala</a></li>
                                                <li><a href="#"><i class="fa fa-download"></i> İndir</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Türkçe Dil Desteği</td>
                                <td>Tam Türkçe arayüz ve dil desteği.</td>
                                <td><span class="badge badge-info">Test</span></td>
                                <td>04.01.2024</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i> Düzenle
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i> Sil
                                        </button>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a href="#"><i class="fa fa-eye"></i> Görüntüle</a></li>
                                                <li><a href="#"><i class="fa fa-copy"></i> Kopyala</a></li>
                                                <li><a href="#"><i class="fa fa-download"></i> İndir</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Modern Animasyonlar</td>
                                <td>Smooth hover efektleri ve animasyonlar.</td>
                                <td><span class="badge badge-success">Aktif</span></td>
                                <td>05.01.2024</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i> Düzenle
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i> Sil
                                        </button>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-warning dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-right">
                                                <li><a href="#"><i class="fa fa-eye"></i> Görüntüle</a></li>
                                                <li><a href="#"><i class="fa fa-copy"></i> Kopyala</a></li>
                                                <li><a href="#"><i class="fa fa-download"></i> İndir</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- İkinci Sayfa Geçiş Butonları -->
        <div class="page-navigation">
            <h3>🔧 Yönetim Paneli</h3>
            <div class="nav-buttons">
                <a href="#" class="nav-btn primary">
                    <i class="fa fa-graduation-cap"></i> Eğitim Seviyeleri
                </a>
                <a href="#" class="nav-btn success">
                    <i class="fa fa-map-marker"></i> Lokasyonlar
                </a>
                <a href="#" class="nav-btn warning">
                    <i class="fa fa-tags"></i> Kategoriler
                </a>
                <a href="#" class="nav-btn info">
                    <i class="fa fa-certificate"></i> Yetenekler
                </a>
                <a href="#" class="nav-btn danger">
                    <i class="fa fa-bell"></i> Bildirimler
                </a>
                <a href="#" class="nav-btn">
                    <i class="fa fa-shield"></i> Güvenlik
                </a>
                <a href="#" class="nav-btn">
                    <i class="fa fa-database"></i> Veritabanı
                </a>
                <a href="#" class="nav-btn">
                    <i class="fa fa-plug"></i> API Ayarları
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Modern DataTables başlatma - table-responsive ile
    var table = $('#modern-datatable').DataTable({
        // Temel ayarlar
        responsive: false,
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tümü"]],
        order: [[0, 'desc']],
        
        // ScrollX kapalı - table-responsive kullanıyoruz
        scrollX: false,
        scrollCollapse: false,
        autoWidth: false,
        
        // DOM yapısı
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
             "<'row'<'col-sm-12'B>>",
        
        // Butonlar
        buttons: [
            {
                extend: 'copy',
                className: 'btn btn-primary btn-sm',
                text: '<i class="fa fa-copy"></i> Kopyala'
            },
            {
                extend: 'csv',
                className: 'btn btn-success btn-sm',
                text: '<i class="fa fa-file-csv"></i> CSV'
            },
            {
                extend: 'excel',
                className: 'btn btn-success btn-sm',
                text: '<i class="fa fa-file-excel"></i> Excel'
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                text: '<i class="fa fa-file-pdf"></i> PDF'
            },
            {
                extend: 'print',
                className: 'btn btn-info btn-sm',
                text: '<i class="fa fa-print"></i> Yazdır'
            },
            {
                extend: 'colvis',
                className: 'btn btn-warning btn-sm',
                text: '<i class="fa fa-eye"></i> Sütunlar'
            }
        ],
        
        // Sütun ayarları
        columnDefs: [
            {
                targets: -1, // Son sütun (İşlemler)
                orderable: false,
                searchable: false,
                width: 180,
                className: 'text-center'
            },
            {
                targets: '_all',
                className: 'dt-center'
            }
        ],
        
        // Dil ayarları
        language: {
            "emptyTable": "Tabloda veri bulunmuyor",
            "info": "_TOTAL_ kayıttan _START_ - _END_ arası gösteriliyor",
            "infoEmpty": "Kayıt bulunamadı",
            "infoFiltered": "(_MAX_ kayıt içinden filtrelendi)",
            "lengthMenu": "_MENU_ kayıt göster",
            "search": "Ara:",
            "zeroRecords": "Eşleşen kayıt bulunamadı",
            "paginate": {
                "first": "İlk",
                "last": "Son",
                "next": "Sonraki",
                "previous": "Önceki"
            }
        },
        
        // Başlangıçta
        initComplete: function(settings, json) {
            // Butonları modernleştir
            $('.dt-buttons').addClass('btn-group');
            $('.dt-buttons .btn').removeClass('dt-button');
            
            // Dropdown z-index düzeltmesi
            $('.dataTables_wrapper').on('click', '.dropdown-toggle', function() {
                $(this).parent().css('z-index', '99999');
            });
        }
    });
});
</script>
@endpush
@endsection
