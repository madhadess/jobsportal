<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->

<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->

<!--[if !IE]><!-->

<html lang="en">

<!--<![endif]-->

<!-- BEGIN HEAD -->

<head>

    <meta charset="utf-8" />

    <title><?php echo e($siteSetting->site_name); ?> | Admin Paneli</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta content="width=device-width, initial-scale=1" name="viewport" />

    <meta content="" name="description" />

    <meta content="" name="author" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- BEGIN GLOBAL MANDATORY STYLES -->

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
        type="text/css" />

    <link href="<?php echo e(asset('/')); ?>admin_assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"
        type="text/css" />

    <link href="<?php echo e(asset('/')); ?>admin_assets/global/plugins/simple-line-icons/simple-line-icons.min.css"
        rel="stylesheet" type="text/css" />

    <link href="<?php echo e(asset('/')); ?>admin_assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"
        type="text/css" />

    <link href="<?php echo e(asset('/')); ?>admin_assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet"
        type="text/css" />

    <link href="<?php echo e(asset('/')); ?>admin_assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"
        rel="stylesheet" type="text/css" />

    <link href="<?php echo e(asset('/')); ?>admin_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"
        rel="stylesheet" type="text/css" />

    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN THEME GLOBAL STYLES -->

    <link href="<?php echo e(asset('/')); ?>admin_assets/global/css/components.min.css" rel="stylesheet" id="style_components"
        type="text/css" />

    <link href="<?php echo e(asset('/')); ?>admin_assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />

    <!-- END THEME GLOBAL STYLES -->

    <!-- BEGIN THEME LAYOUT STYLES -->

    <link href="<?php echo e(asset('/')); ?>admin_assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo e(asset('/')); ?>admin_assets/layouts/layout/css/themes/default.min.css" rel="stylesheet" type="text/css"
        id="style_color" />

    <link href="<?php echo e(asset('/')); ?>admin_assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />

    <!-- END THEME LAYOUT STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->

    <!-- Modern DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.datatables.net/select/1.7.0/css/select.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet"
        type="text/css" />

    <link href="<?php echo e(asset('/')); ?>admin_assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
        rel="stylesheet" type="text/css" />

    <link href="<?php echo e(asset('/')); ?>admin_assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"
        rel="stylesheet" type="text/css" />

    <link
        href="<?php echo e(asset('/')); ?>admin_assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"
        rel="stylesheet" type="text/css" />

    <link href="<?php echo e(asset('/')); ?>admin_assets/global/plugins/clockface/css/clockface.css" rel="stylesheet"
        type="text/css" />

    <link href="<?php echo e(asset('/')); ?>admin_assets/global/plugins/select2/css/select2.min.css" rel="stylesheet"
        type="text/css" />

    <link href="<?php echo e(asset('/')); ?>admin_assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
        type="text/css" />

    <!-- Premium Pagination & Table Layout Styles -->
    <style>
        /* Premium Pagination - Highly Refined */
        .dataTables_paginate {
            padding: 1.5rem 0.5rem !important;
            display: flex !important;
            justify-content: flex-end !important;
            align-items: center !important;
        }

        /* Container for buttons */
        .dataTables_paginate .pagination,
        .dataTables_paginate>span {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            padding: 4px !important;
            margin: 0 !important;
            list-style: none !important;
        }

        /* Individual Button Styling */
        .dataTables_paginate .paginate_button {
            margin: 0 2px !important;
            padding: 0 !important;
            border: none !important;
            background: none !important;
            display: inline-block !important;
        }

        /* The actual link or text inside the button */
        .dataTables_paginate .paginate_button a,
        .dataTables_paginate .paginate_button.current,
        .dataTables_paginate .paginate_button.next,
        .dataTables_paginate .paginate_button.previous {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 40px !important;
            height: 40px !important;
            padding: 0 16px !important;
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            color: #475569 !important;
            background-color: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            text-decoration: none !important;
            cursor: pointer !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        }

        /* Active/Current Page */
        .dataTables_paginate .paginate_button.active a,
        .dataTables_paginate .paginate_button.current {
            z-index: 3 !important;
            color: #ffffff !important;
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3) !important;
        }

        /* Hover Effect */
        .dataTables_paginate .paginate_button:hover:not(.disabled):not(.active):not(.current) a,
        .dataTables_paginate .paginate_button:hover:not(.disabled):not(.active):not(.current) {
            color: #1e293b !important;
            background-color: #f8fafc !important;
            border-color: #cbd5e1 !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
        }

        /* Disabled State */
        .dataTables_paginate .paginate_button.disabled a,
        .dataTables_paginate .paginate_button.disabled {
            color: #94a3b8 !important;
            pointer-events: none !important;
            background-color: #f1f5f9 !important;
            border-color: #e2e8f0 !important;
            opacity: 0.6 !important;
        }

        /* Previous/Next styling */
        .dataTables_paginate .paginate_button.previous,
        .dataTables_paginate .paginate_button.next {
            font-weight: 700 !important;
            text-transform: capitalize !important;
            background-color: #f8fafc !important;
        }

        /* Info & Length Styling */
        .dataTables_info {
            padding: 2rem 0.5rem !important;
            font-size: 0.875rem !important;
            color: #64748b !important;
            font-weight: 500 !important;
        }

        .dataTables_length {
            padding: 1rem 0 !important;
            color: #475569 !important;
            font-size: 0.875rem !important;
        }

        .dataTables_length select {
            padding: 0.5rem 2rem 0.5rem 0.75rem !important;
            font-size: 0.875rem !important;
            border-radius: 8px !important;
            border: 1px solid #e2e8f0 !important;
            background-color: #fff !important;
            margin: 0 8px !important;
            outline: none !important;
            cursor: pointer !important;
        }

        /* Table Alignment & Synchronization Fixes */
        .dataTables_scroll {
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            overflow: hidden !important;
        }

        .dataTables_scrollHeadInner,
        .dataTables_scrollHeadInner table,
        .dataTables_scrollBody table {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .dataTables_scrollBody {
            border-top: 1px solid #e2e8f0 !important;
        }

        /* Ensure cells have consistent sizing */
        table.dataTable th,
        table.dataTable td {
            box-sizing: border-box !important;
        }

        /* Critical synchronization for scrolling DataTables */
        .dataTables_scrollHeadInner,
        .dataTables_scrollHeadInner table,
        .dataTables_scrollBody table {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }
    </style>
    <link type="text/css" rel="stylesheet" media="all" href="<?php echo e(asset('/')); ?>admin_assets/custom.css" />
    <link rel="shortcut icon" href="<?php echo e(asset('/')); ?>favicon.ico" />
    <link href="<?php echo e(asset('jquery.filer/css/jquery.filer.css')); ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo e(asset('jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css')); ?>" type="text/css"
        rel="stylesheet" />

    <?php echo $__env->yieldPushContent('css'); ?>

    <script>
        var APP_URL = "<?php echo url('/'); ?>"
        var base_url = "<?php echo url('/'); ?>"
    </script>

    <!-- END PAGE LEVEL PLUGINS -->

    <style>
        .jFiler-item-info {
            display: none !important;
        }

        .jFiler-item-thumb-image {
            position: absolute;
            top: 0;
            left: 0;
        }

        /* Modern Portlet & Container Styles */
        .portlet.light {
            border-radius: 12px !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
            overflow: hidden !important;
            margin-bottom: 25px !important;
        }

        .portlet-title {
            padding: 15px 20px !important;
            border-bottom: 1px solid #f1f5f9 !important;
            background: #ffffff !important;
        }

        .portlet-body {
            padding: 20px !important;
        }

        /* Modern Form Elements */
        .form-control {
            border-radius: 8px !important;
            border: 1px solid #cbd5e1 !important;
            padding: 10px 15px !important;
            height: auto !important;
            font-size: 14px !important;
            transition: all 0.2s ease !important;
            box-shadow: none !important;
        }

        .form-control:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1) !important;
        }

        /* Modern Buttons */
        .btn {
            border-radius: 8px !important;
            font-weight: 600 !important;
            padding: 8px 20px !important;
            transition: all 0.2s ease !important;
            text-transform: none !important;
            letter-spacing: 0.025em !important;
        }

        .btn-success {
            background-color: #10b981 !important;
            border-color: #10b981 !important;
        }

        .btn-success:hover {
            background-color: #059669 !important;
            transform: translateY(-1px) !important;
        }

        .btn-primary {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
        }

        .btn-primary:hover {
            background-color: #2563eb !important;
            transform: translateY(-1px) !important;
        }

        /* Custom Scrollbar for the whole page */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    <style>
        /* MODERN DATATABLES TASARIMI */
        /* ===================================================== */

        /* ===================================================== */
        /* MODERN DATATABLES TASARIMI - GÜNCELLENMİŞ */
        /* ===================================================== */

        /* DataTables Genel Tasarım - Mobil Uyumlu */
        .dataTables_wrapper {
            padding: 24px;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            border: 1px solid #e2e8f0;
            margin: 20px 0;
            position: relative;
            overflow: hidden !important;
            max-width: 100%;
        }

        /* DataTables Table - Mobil Uyumlu */
        .dataTables_wrapper .dataTable {
            border: none !important;
            margin: 0 !important;
            border-radius: 12px;
            overflow: hidden;
            width: 100% !important;
            background: #ffffff !important;
        }

        /* Tablo container için kaydırma - TAŞMA SORUNU ÇÖZÜLDÜ */
        .dataTables_wrapper .dataTables_scroll {
            overflow-x: auto !important;
            overflow-y: hidden !important;
            background: #ffffff !important;
            border-radius: 12px !important;
            width: 100% !important;
            max-width: 100% !important;
            position: relative !important;
        }

        .dataTables_wrapper .dataTables_scrollBody {
            overflow-x: auto !important;
            overflow-y: hidden !important;
            background: #ffffff !important;
            width: 100% !important;
            max-width: 100% !important;
            border-bottom-left-radius: 12px !important;
            border-bottom-right-radius: 12px !important;
        }

        /* Genel kaydırma */
        .dataTables_scrollBody table {
            min-width: 800px;
            max-width: none !important;
            width: auto !important;
            background: #ffffff !important;
        }

        /* DataTables body için arka plan */
        .dataTables_wrapper .dataTable tbody {
            background: #ffffff !important;
        }

        .dataTables_wrapper .dataTable tbody tr {
            background: #ffffff !important;
        }

        .dataTables_wrapper .dataTable tbody td {
            background: #ffffff !important;
        }

        /* ===================================================== */
        /* MOBİL UYUMLU TABLO - TÜM TABLOLAR İÇİN KESİN ÇÖZÜM */
        /* ===================================================== */

        /* Table container - scroll için */
        .table-container {
            overflow-x: auto !important;
            overflow-y: visible !important;
            -webkit-overflow-scrolling: touch !important;
            width: 100% !important;
            display: block !important;
        }

        /* Tüm DataTables wrapper'ları için mobil scroll */
        .dataTables_wrapper {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
            width: 100% !important;
        }

        /* Tüm tablolar için */
        .dataTables_wrapper table.dataTable,
        .table-container table,
        .portlet-body table {
            width: 100% !important;
            min-width: 900px !important;
        }

        /* Portlet body içindeki tablolar */
        .portlet-body {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }

        /* Table scrollable - genel */
        .table-scrollable {
            overflow-x: auto !important;
            overflow-y: visible !important;
            -webkit-overflow-scrolling: touch !important;
            display: block !important;
            width: 100% !important;
        }

        /* Mobilde kesinlikle çalışsın */
        @media screen and (max-width: 767px) {

            /* Ana container */
            .page-content {
                overflow-x: hidden !important;
                padding: 10px !important;
            }

            /* Portlet */
            .portlet {
                overflow: visible !important;
            }

            /* Portlet body */
            .portlet-body {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch !important;
                padding: 10px !important;
            }

            /* Table container - EN ÖNEMLİ */
            .table-container {
                overflow-x: scroll !important;
                -webkit-overflow-scrolling: touch !important;
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                background: #fff !important;
            }

            /* DataTables wrapper */
            .dataTables_wrapper {
                overflow-x: scroll !important;
                -webkit-overflow-scrolling: touch !important;
                width: 100% !important;
                max-width: 100% !important;
                background: #fff !important;
            }

            /* Tablo minimum genişlik - ZORUNLU */
            .dataTables_wrapper table.dataTable,
            .table-container table,
            .portlet-body table,
            .table {
                min-width: 900px !important;
                width: 900px !important;
                max-width: none !important;
                background: #fff !important;
            }

            /* Hücrelerde satır kırılması yok ve ARKA PLAN */
            .dataTables_wrapper table.dataTable th,
            .dataTables_wrapper table.dataTable td,
            .table-container table th,
            .table-container table td,
            .table th,
            .table td {
                white-space: nowrap !important;
                padding: 8px 6px !important;
                background: #fff !important;
            }

            /* Satır arka planları */
            .dataTables_wrapper table.dataTable tbody tr,
            .table-container table tbody tr,
            .table tbody tr {
                background: #fff !important;
            }

            .dataTables_wrapper table.dataTable tbody tr:nth-child(odd),
            .table-container table tbody tr:nth-child(odd),
            .table-striped tbody tr:nth-child(odd) {
                background: #f9f9f9 !important;
            }

            .dataTables_wrapper table.dataTable tbody tr:nth-child(odd) td,
            .table-container table tbody tr:nth-child(odd) td,
            .table-striped tbody tr:nth-child(odd) td {
                background: #f9f9f9 !important;
            }

            /* Table scrollable container */
            .table-scrollable {
                overflow-x: scroll !important;
                -webkit-overflow-scrolling: touch !important;
                display: block !important;
                width: 100% !important;
                background: #fff !important;
            }
        }

        /* Mobilde tablo container */
        @media (max-width: 768px) {
            .dataTables_wrapper .dataTables_scroll {
                background: #ffffff !important;
                border-radius: 12px !important;
                overflow-x: scroll !important;
                overflow-y: hidden !important;
                width: 100% !important;
                max-width: 100% !important;
            }

            .dataTables_wrapper .dataTables_scrollBody {
                background: #ffffff !important;
                width: 100% !important;
                max-width: 100% !important;
                overflow-x: scroll !important;
                overflow-y: hidden !important;
            }

            .dataTables_scrollBody table {
                min-width: 800px !important;
                width: 800px !important;
            }
        }

        /* DataTables Header - Daha İyi Layout */
        .dataTables_wrapper .row:first-child {
            margin-bottom: 24px;
            align-items: center;
        }

        /* DataTables Modern Scroll ve Sıkışma Önleme */
        .dataTables_wrapper .dataTables_scroll {
            margin: 15px 0;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .dataTables_wrapper .dataTables_scrollBody {
            border-top: 1px solid #e2e8f0 !important;
        }

        table.dataTable {
            width: 100% !important;
            margin: 0 !important;
            border-collapse: collapse !important;
            table-layout: auto !important;
            /* Otomatik genişlik */
        }

        table.dataTable thead th,
        table.dataTable tbody td {
            white-space: nowrap !important;
            /* Sıkışmayı önle */
            padding: 12px 15px !important;
            vertical-align: middle !important;
        }

        table.dataTable thead th {
            background-color: #f8fafc !important;
            color: #475569 !important;
            font-weight: 600 !important;
            border-bottom: 2px solid #e2e8f0 !important;
        }

        .dataTables_wrapper .dataTables_length {
            margin: 0;
        }

        .dataTables_wrapper .dataTables_length label {
            font-weight: 600;
            color: #475569;
            margin-right: 12px;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 16px;
            font-size: 14px;
            font-weight: 500;
            background: #ffffff;
            transition: all 0.3s ease;
            min-width: 120px;
            cursor: pointer;
        }

        .dataTables_wrapper .dataTables_length select:hover {
            border-color: #cbd5e1;
        }

        .dataTables_wrapper .dataTables_length select:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        /* DataTables Search - Modern Arama */
        .dataTables_wrapper .dataTables_filter {
            margin: 0;
            text-align: right;
        }

        .dataTables_wrapper .dataTables_filter label {
            font-weight: 600;
            color: #475569;
            margin-right: 12px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            background: #ffffff;
            transition: all 0.3s ease;
            width: 280px;
            cursor: text;
        }

        .dataTables_wrapper .dataTables_filter input::placeholder {
            color: #94a3b8;
        }

        .dataTables_wrapper .dataTables_filter input:hover {
            border-color: #cbd5e1;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            width: 320px;
        }

        /* DataTables Table - Geliştirilmiş ve Mobil Uyumlu */
        .dataTables_wrapper .dataTable {
            border: none !important;
            margin: 0 !important;
            border-radius: 12px;
            overflow: hidden;
            width: 100% !important;
            table-layout: auto !important;
        }

        .dataTables_wrapper .dataTable thead th {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
            border: none !important;
            color: #475569 !important;
            font-weight: 700 !important;
            font-size: 12px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.8px !important;
            padding: 18px 16px !important;
            border-bottom: 3px solid #cbd5e1 !important;
            white-space: nowrap;
            min-width: 120px;
        }

        /* Sütun genişlikleri - Dinamik olarak ayarlanmalı */
        .dataTables_wrapper .dataTable thead th {
            min-width: 120px;
        }

        /* İşlemler */

        .dataTables_wrapper .dataTable thead th.sorting:after,
        .dataTables_wrapper .dataTable thead th.sorting_asc:after,
        .dataTables_wrapper .dataTable thead th.sorting_desc:after {
            opacity: 0.6;
            font-size: 10px;
        }

        .dataTables_wrapper .dataTable tbody td {
            border: none !important;
            padding: 12px 16px !important;
            font-size: 13px !important;
            color: #334155 !important;
            border-bottom: 1px solid #f1f5f9 !important;
            vertical-align: middle !important;
            font-weight: 500;
            min-width: 120px;
            max-width: 300px;
            white-space: normal !important;
            word-wrap: break-word !important;
            overflow-wrap: break-word !important;
            line-height: 1.4 !important;
        }

        .dataTables_wrapper .dataTable tbody tr:hover td {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
        }

        .dataTables_wrapper .dataTable tbody tr:hover {
            transform: scale(1.01);
            transition: all 0.2s ease;
        }

        /* Mobilde tablo genişliği düzeltme */
        @media (max-width: 768px) {
            .dataTables_wrapper .dataTable {
                min-width: 800px !important;
                width: 800px !important;
            }

            .dataTables_wrapper .dataTables_scrollBody table {
                min-width: 800px !important;
                width: 800px !important;
            }
        }

        .dataTables_wrapper .dataTable th:last-child,
        .dataTables_wrapper .dataTable td:last-child {
            text-align: center !important;
            width: 120px !important;
            min-width: 120px !important;
            white-space: nowrap !important;
            padding: 12px 8px !important;
        }

        /* Metin taşması önleme */
        .dataTables_wrapper .dataTable td {
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            max-width: 100% !important;
        }

        /* Açıklama sütunu için özel stil */

        /* Z-INDEX FIX FOR MODALS */
        .modal-backdrop {
            z-index: 99998 !important;
        }

        .modal {
            z-index: 99999 !important;
        }

        .modal-dialog {
            z-index: 100000 !important;
            /* Extra assurance */
        }

        .dataTables_wrapper .dataTable td:nth-child(3) {
            max-height: 60px !important;
            overflow-y: auto !important;
            line-height: 1.3 !important;
        }

        /* Mobil uyumlu metin */
        @media screen and (max-width: 768px) {
            .dataTables_wrapper .dataTable td {
                font-size: 12px !important;
                padding: 8px 6px !important;
            }

            .dataTables_wrapper .dataTable td:nth-child(3) {
                max-height: 40px !important;
            }
        }

        /* Modern Butonlar - Premium Tasarım */
        .dataTables_wrapper .btn {
            border-radius: 10px !important;
            font-weight: 600 !important;
            font-size: 12px !important;
            padding: 10px 18px !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            border: none !important;
            margin: 3px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            position: relative !important;
            overflow: hidden !important;
        }

        .dataTables_wrapper .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .dataTables_wrapper .btn:hover::before {
            left: 100%;
        }

        .dataTables_wrapper .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%) !important;
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.4) !important;
            color: #ffffff !important;
        }

        .dataTables_wrapper .btn-primary:hover {
            transform: translateY(-2px) scale(1.05) !important;
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.5) !important;
        }

        .dataTables_wrapper .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.4) !important;
            color: #ffffff !important;
        }

        .dataTables_wrapper .btn-success:hover {
            transform: translateY(-2px) scale(1.05) !important;
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.5) !important;
        }

        .dataTables_wrapper .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
            box-shadow: 0 4px 16px rgba(239, 68, 68, 0.4) !important;
            color: #ffffff !important;
        }

        .dataTables_wrapper .btn-danger:hover {
            transform: translateY(-2px) scale(1.05) !important;
            box-shadow: 0 8px 24px rgba(239, 68, 68, 0.5) !important;
        }

        .dataTables_wrapper .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
            box-shadow: 0 4px 16px rgba(245, 158, 11, 0.4) !important;
            color: #ffffff !important;
        }

        .dataTables_wrapper .btn-warning:hover {
            transform: translateY(-2px) scale(1.05) !important;
            box-shadow: 0 8px 24px rgba(245, 158, 11, 0.5) !important;
        }

        .dataTables_wrapper .btn-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
            box-shadow: 0 4px 16px rgba(6, 182, 212, 0.4) !important;
            color: #ffffff !important;
        }

        .dataTables_wrapper .btn-info:hover {
            transform: translateY(-2px) scale(1.05) !important;
            box-shadow: 0 8px 24px rgba(6, 182, 212, 0.5) !important;
        }

        /* Button Group - Daha İyi Gruplama ve Yerleşim */
        .dataTables_wrapper .dt-buttons {
            float: left;
            margin-bottom: 20px;
            margin-top: 10px;
        }

        .dataTables_wrapper .btn-group {
            display: inline-flex !important;
            gap: 6px !important;
            border-radius: 12px !important;
            padding: 4px !important;
            background: rgba(248, 250, 252, 0.8) !important;
            backdrop-filter: blur(10px) !important;
            position: relative !important;
            margin-bottom: 0 !important;
        }

        /* Paginate and Info separation */
        .dataTables_wrapper .dataTables_info {
            clear: both;
            float: left;
            padding-top: 20px;
        }

        .dataTables_wrapper .dataTables_paginate {
            float: right;
            padding-top: 20px;
        }

        /* ===================================================== */
        /* İŞLEMLER MODAL SİSTEMİ - DROPDOWN YERİNE */
        /* ===================================================== */

        /* Eski dropdown'ları gizle */
        .dropdown-menu {
            display: none !important;
        }

        /* İşlemler Modal */
        #actionsModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 999999;
        }

        #actionsModal.show {
            display: block;
        }

        #actionsModal .modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        #actionsModal .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);
            min-width: 300px;
            max-width: 350px;
            overflow: hidden;
            animation: modalSlideIn 0.2s ease;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.9);
            }

            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        #actionsModal .modal-header {
            padding: 16px 20px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #fff;
        }

        #actionsModal .modal-header h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        #actionsModal .modal-header .close-btn {
            position: absolute;
            top: 12px;
            right: 16px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: #fff;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #actionsModal .modal-header .close-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        #actionsModal .modal-body {
            padding: 8px 0;
            max-height: 400px;
            overflow-y: auto;
        }

        #actionsModal .modal-body .action-item {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            color: #334155;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.15s ease;
            cursor: pointer;
            border-left: 3px solid transparent;
        }

        #actionsModal .modal-body .action-item:hover {
            background: #f1f5f9;
            color: #3b82f6;
            border-left-color: #3b82f6;
        }

        #actionsModal .modal-body .action-item i {
            width: 24px;
            margin-right: 12px;
            font-size: 15px;
            text-align: center;
        }

        #actionsModal .modal-body .action-item.text-danger {
            color: #dc2626;
        }

        #actionsModal .modal-body .action-item.text-danger:hover {
            background: #fef2f2;
            border-left-color: #dc2626;
        }

        #actionsModal .modal-footer {
            padding: 12px 20px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
        }

        #actionsModal .modal-footer .btn-close-modal {
            background: #e2e8f0;
            border: none;
            padding: 10px 24px;
            border-radius: 8px;
            color: #64748b;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        #actionsModal .modal-footer .btn-close-modal:hover {
            background: #cbd5e1;
            color: #334155;
        }

        /* ===================================================== */
        /* MODERN HEADER TASARIMI - TEMIZ VE MODERN */
        /* ===================================================== */

        /* Ana Header */
        .page-header.navbar-fixed-top {
            background: #ffffff !important;
            border-bottom: 1px solid #e5e7eb !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
            padding: 0 !important;
            height: auto !important;
            position: relative !important;
        }

        /* Header Inner Container */
        .page-header-inner {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 10px 16px !important;
            gap: 16px !important;
        }

        /* Logo Alanı */
        .page-logo {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            flex-shrink: 0 !important;
        }

        .page-logo a {
            display: flex !important;
            align-items: center !important;
            text-decoration: none !important;
            transition: opacity 0.2s ease !important;
        }

        .page-logo a:hover {
            opacity: 0.8 !important;
        }

        .page-logo img {
            max-width: 160px !important;
            max-height: 35px !important;
            display: block !important;
        }

        /* Menu Toggler */
        .menu-toggler.sidebar-toggler {
            background: #f3f4f6 !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 8px !important;
            width: 40px !important;
            height: 40px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            color: #6b7280 !important;
            font-size: 18px !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .menu-toggler.sidebar-toggler::before {
            content: '☰' !important;
            display: block !important;
            font-size: 18px !important;
            color: #6b7280 !important;
        }

        .menu-toggler.sidebar-toggler:hover {
            background: #e5e7eb !important;
            border-color: #d1d5db !important;
            color: #374151 !important;
        }

        .menu-toggler.sidebar-toggler:hover::before {
            color: #374151 !important;
        }

        /* Top Menu */
        .top-menu {
            display: flex !important;
            align-items: center !important;
            margin-left: auto !important;
        }

        .top-menu .nav {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .top-menu .nav>li {
            list-style: none !important;
            display: flex !important;
            align-items: center !important;
        }

        /* Dropdown User */
        .dropdown-user>a {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
            padding: 8px 16px !important;
            color: #374151 !important;
            text-decoration: none !important;
            border-radius: 8px !important;
            transition: all 0.2s ease !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            position: relative !important;
            z-index: 1000 !important;
        }

        .dropdown-user>a:hover {
            background: #f3f4f6 !important;
            color: #1f2937 !important;
        }

        .dropdown-user>a i {
            font-size: 12px !important;
            color: #9ca3af !important;
        }

        .dropdown-user>a:hover i {
            color: #6b7280 !important;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            border: 1px solid #e5e7eb !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
            padding: 8px 0 !important;
            background: #ffffff !important;
            min-width: 200px !important;
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            z-index: 1001 !important;
            display: none !important;
        }

        .dropdown-user.open .dropdown-menu,
        .dropdown-user:hover .dropdown-menu {
            display: block !important;
        }

        .dropdown-menu>li>a {
            padding: 10px 16px !important;
            color: #374151 !important;
            font-size: 13px !important;
            transition: all 0.2s ease !important;
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
        }

        .dropdown-menu>li>a:hover {
            background: #f3f4f6 !important;
            color: #1f2937 !important;
        }

        .dropdown-menu>li>a i {
            width: 16px !important;
            text-align: center !important;
            color: #9ca3af !important;
        }

        .dropdown-menu>li>a:hover i {
            color: #6b7280 !important;
        }

        .dropdown-menu>li.divider {
            height: 1px !important;
            background: #e5e7eb !important;
            margin: 4px 0 !important;
        }

        /* Username */
        .username {
            font-weight: 600 !important;
            color: #1f2937 !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header-inner {
                padding: 10px 16px !important;
                gap: 12px !important;
            }

            .page-logo img {
                max-width: 140px !important;
                max-height: 30px !important;
            }

            .username-hide-on-mobile {
                display: none !important;
            }

            .top-menu .nav {
                gap: 4px !important;
            }

            .dropdown-user>a {
                padding: 6px 12px !important;
                font-size: 13px !important;
            }
        }

        /* ===================================================== */
        /* MODERN FOOTER TASARIMI - TEMIZ VE MODERN */
        /* ===================================================== */

        /* Ana Footer */
        .page-footer {
            background: #ffffff !important;
            border-top: 1px solid #e5e7eb !important;
            padding: 16px 32px !important;
            margin-top: 32px !important;
            box-shadow: 0 -1px 3px rgba(0, 0, 0, 0.1) !important;
        }

        /* Footer Inner */
        .page-footer-inner {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #6b7280 !important;
            font-size: 13px !important;
            font-weight: 500 !important;
        }

        /* Scroll to Top */
        .scroll-to-top {
            display: none !important;
        }

        .scroll-to-top.in {
            display: flex !important;
            position: fixed !important;
            bottom: 32px !important;
            right: 32px !important;
            width: 44px !important;
            height: 44px !important;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
            border-radius: 12px !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            color: #ffffff !important;
            font-size: 18px !important;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3) !important;
            transition: all 0.3s ease !important;
            z-index: 100 !important;
        }

        .scroll-to-top.in:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4) !important;
        }

        /* Responsive Footer */
        @media (max-width: 768px) {
            .page-footer {
                padding: 12px 16px !important;
                margin-top: 24px !important;
            }

            .page-footer-inner {
                font-size: 12px !important;
            }

            .scroll-to-top.in {
                bottom: 16px !important;
                right: 16px !important;
                width: 40px !important;
                height: 40px !important;
                font-size: 16px !important;
            }
        }

        /* ===================================================== */
        /* MODERN SAYFA TASARIMI - GENEL */
        /* ===================================================== */


        /* Portlet - Premium Modern Kart Tasarımı */
        .portlet {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            border-radius: 24px !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12) !important;
            margin-bottom: 32px !important;
            overflow: hidden !important;
            position: relative !important;
            z-index: 1 !important;
            transition: all 0.3s ease !important;
        }

        .portlet:hover {
            transform: translateY(-4px) !important;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15) !important;
        }

        .portlet.light {
            background: rgba(255, 255, 255, 0.95) !important;
        }

        .portlet.bordered {
            border: 1px solid rgba(226, 232, 240, 0.5) !important;
        }

        /* Portlet Başlık - Premium */
        .portlet-title {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(248, 250, 252, 0.9) 100%) !important;
            backdrop-filter: blur(10px) !important;
            border-bottom: 1px solid rgba(226, 232, 240, 0.5) !important;
            padding: 24px 32px !important;
            margin: 0 !important;
            min-height: auto !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            position: relative !important;
        }

        .portlet-title::before {
            content: '' !important;
            position: absolute !important;
            bottom: 0 !important;
            left: 32px !important;
            right: 32px !important;
            height: 2px !important;
            background: linear-gradient(90deg, #3b82f6 0%, #10b981 50%, #f59e0b 100%) !important;
            opacity: 0.3 !important;
        }

        .portlet-title .caption {
            display: flex !important;
            align-items: center !important;
            gap: 16px !important;
        }

        .portlet-title .caption i {
            font-size: 24px !important;
            color: #3b82f6 !important;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%) !important;
            padding: 12px !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2) !important;
        }

        .portlet-title .caption-subject {
            font-size: 18px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            text-transform: none !important;
            letter-spacing: -0.2px !important;
        }

        /* Portlet Actions - Premium Butonlar */
        .portlet-title .actions {
            display: flex !important;
            gap: 12px !important;
        }

        .portlet-title .actions .btn {
            border-radius: 12px !important;
            padding: 12px 24px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            border: none !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            position: relative !important;
            overflow: hidden !important;
        }

        .portlet-title .actions .btn::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: -100% !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent) !important;
            transition: left 0.6s !important;
        }

        .portlet-title .actions .btn:hover::before {
            left: 100% !important;
        }

        .portlet-title .actions .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
            color: #fff !important;
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4) !important;
        }

        .portlet-title .actions .btn-success:hover {
            transform: translateY(-3px) !important;
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.5) !important;
        }

        /* Portlet Body - Premium */
        .portlet-body {
            padding: 32px !important;
            background: rgba(255, 255, 255, 0.9) !important;
            position: relative !important;
        }

        /* Filtre Alanı - Modern Tasarım */
        .portlet-body .control-label {
            font-weight: 600;
            color: #374151;
            font-size: 12px !important;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .portlet-body .form-control {
            border: 2px solid #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 8px 12px !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            background: #ffffff !important;
            transition: all 0.2s ease !important;
            width: 100% !important;
            box-sizing: border-box !important;
            min-height: 38px !important;
        }

        .portlet-body .form-control:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
            outline: none !important;
        }

        /* Filtre butonları - daha küçük */
        .portlet-body .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 8px 16px !important;
            font-weight: 600 !important;
            font-size: 12px !important;
            transition: all 0.2s ease !important;
            white-space: nowrap;
            min-width: auto !important;
        }

        .portlet-body .btn-primary:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3) !important;
        }

        .portlet-body .btn-default {
            background: #f3f4f6 !important;
            border: 1px solid #d1d5db !important;
            color: #6b7280 !important;
            border-radius: 8px !important;
            padding: 8px 16px !important;
            font-weight: 600 !important;
            font-size: 12px !important;
            transition: all 0.2s ease !important;
            white-space: nowrap;
            min-width: auto !important;
        }

        .portlet-body .btn-default:hover {
            background: #e5e7eb !important;
            color: #4b5563 !important;
        }

        /* Filtre satırı için daha az padding */
        .portlet-body .row {
            margin-bottom: 12px !important;
        }

        .portlet-body .row:last-child {
            margin-bottom: 0 !important;
        }

        /* Select2 dropdown için */
        .portlet-body .select2-container--default .select2-selection--single {
            border: 2px solid #e2e8f0 !important;
            border-radius: 8px !important;
            min-height: 38px !important;
        }

        .portlet-body .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 34px !important;
            padding-left: 12px !important;
            font-size: 13px !important;
        }

        /* Heading Satırı */
        .heading th {
            background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;
            color: #ffffff !important;
            font-weight: 600 !important;
            font-size: 12px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            padding: 14px 12px !important;
            border: none !important;
        }

        /* DataTables gizli sütunları TAMAMEN KALDIR */
        .dataTables_sizing {
            display: none !important;
        }

        /* Height 0px olan satırları gizle */
        .dataTables_wrapper .dataTables_scrollHead thead tr[style*="height: 0px"],
        .dataTables_wrapper .dataTables_scrollHead thead tr[style*="height:0px"],
        .dataTables_wrapper table thead tr[style*="height: 0px"],
        .dataTables_wrapper table thead tr[style*="height:0px"] {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            overflow: hidden !important;
        }

        /* DataTables sizing div'lerini gizle */
        .dataTables_sizing {
            display: none !important;
            height: 0 !important;
            overflow: hidden !important;
        }

        /* Padding 0px olan th'leri düzelt */
        .dataTables_wrapper table thead th[style*="padding-top: 0px"],
        .dataTables_wrapper table thead th[style*="padding-bottom: 0px"],
        .dataTables_wrapper table thead th[style*="border-top-width: 0px"],
        .dataTables_wrapper table thead th[style*="border-bottom-width: 0px"] {
            padding: 14px 12px !important;
            border-bottom: 3px solid #cbd5e1 !important;
            height: auto !important;
        }

        /* Gizli DataTables satırlarını tamamen kaldır */
        .dataTables_scrollHead .dataTables_sizing,
        .dataTables_scrollBody .dataTables_sizing,
        .dataTables_scrollFoot .dataTables_sizing {
            display: none !important;
            height: 0 !important;
            width: 0 !important;
            overflow: hidden !important;
            position: absolute !important;
            left: -9999px !important;
        }

        /* Boş sütunları gizle - DAHA GÜÇLÜ */
        .heading th:empty,
        .filter td:empty,
        table thead th:empty,
        table tbody td:empty,
        table.dataTable thead th:empty,
        table.dataTable tbody td:empty,
        .dataTables_wrapper table thead th:empty,
        .dataTables_wrapper table tbody td:empty {
            display: none !important;
            width: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            visibility: hidden !important;
        }

        /* İçeriği olmayan th/td gizle */
        th:not(:has(*)):empty,
        td:not(:has(*)):empty,
        th:empty:not(:has(*)),
        td:empty:not(:has(*)) {
            display: none !important;
            visibility: hidden !important;
            width: 0 !important;
            height: 0 !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        /* DataTables select sütunu gizle */
        .dataTables_wrapper table tbody tr td:first-child:has(input[type="checkbox"]),
        .dataTables_wrapper table thead tr th:first-child:has(input[type="checkbox"]) {
            display: none !important;
            visibility: hidden !important;
        }

        /* Checkbox içeren sütun gizle */
        td:has(input[type="checkbox"]),
        th:has(input[type="checkbox"]) {
            display: none !important;
            visibility: hidden !important;
        }

        /* Tablo ve container taşma düzeltme */
        .table-container {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }

        .table-container form {
            width: 100% !important;
        }

        /* Tablo genişlik kontrolü */
        .table-container table {
            width: 100% !important;
            table-layout: auto !important;
        }

        /* DataTables wrapper */
        .dataTables_wrapper {
            width: 100% !important;
            overflow: visible !important;
        }

        /* DataTables üst ve alt kısım */
        .dataTables_wrapper>.row {
            margin: 0 !important;
            padding: 12px 0 !important;
        }

        /* DataTables Pagination - Premium Modern */
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 32px !important;
            text-align: center !important;
            padding: 20px !important;
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px) !important;
            border-radius: 16px !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06) !important;
        }

        .dataTables_wrapper .dataTables_paginate .pagination {
            border: none !important;
            gap: 6px !important;
            justify-content: center !important;
            display: flex !important;
            align-items: center !important;
            flex-wrap: wrap !important;
        }

        .dataTables_wrapper .dataTables_paginate .pagination>li {
            margin: 0 !important;
            display: inline-flex !important;
        }

        .dataTables_wrapper .dataTables_paginate .pagination>li>a,
        .dataTables_wrapper .dataTables_paginate .pagination>li>span {
            border: none !important;
            border-radius: 10px !important;
            margin: 0 2px !important;
            padding: 10px 14px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #64748b !important;
            background: #ffffff !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            min-width: 40px !important;
            text-align: center !important;
            position: relative !important;
            overflow: hidden !important;
        }

        .dataTables_wrapper .dataTables_paginate .pagination>li>a::before {
            content: '' !important;
            position: absolute !important;
            top: 0 !important;
            left: -100% !important;
            width: 100% !important;
            height: 100% !important;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent) !important;
            transition: left 0.6s !important;
        }

        .dataTables_wrapper .dataTables_paginate .pagination>li>a:hover::before {
            left: 100% !important;
        }

        .dataTables_wrapper .dataTables_paginate .pagination>li>a:hover {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
            color: #ffffff !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3) !important;
        }

        .dataTables_wrapper .dataTables_paginate .pagination>li.active>a,
        .dataTables_wrapper .dataTables_paginate .pagination>li.active>span {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3) !important;
            transform: translateY(-1px) !important;
        }

        .dataTables_wrapper .dataTables_paginate .pagination>li.disabled>a,
        .dataTables_wrapper .dataTables_paginate .pagination>li.disabled>span {
            background: #f3f4f6 !important;
            color: #9ca3af !important;
            cursor: not-allowed !important;
            opacity: 0.6 !important;
            transform: none !important;
        }

        .dataTables_wrapper .dataTables_paginate .pagination>li.disabled>a:hover,
        .dataTables_wrapper .dataTables_paginate .pagination>li.disabled>span:hover {
            background: #f3f4f6 !important;
            color: #9ca3af !important;
            transform: none !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
        }

        /* Pagination ikonları */
        .dataTables_wrapper .dataTables_paginate .pagination>li.previous>a::before,
        .dataTables_wrapper .dataTables_paginate .pagination>li.next>a::before {
            font-family: FontAwesome !important;
            font-size: 14px !important;
        }

        .dataTables_wrapper .dataTables_paginate .pagination>li.previous>a::before {
            content: "\f060" !important;
        }

        .dataTables_wrapper .dataTables_paginate .pagination>li.next>a::before {
            content: "\f061" !important;
        }

        .dataTables_wrapper .dataTables_paginate .pagination>li.previous>a,
        .dataTables_wrapper .dataTables_paginate .pagination>li.next>a {
            padding: 10px 16px !important;
            min-width: 44px !important;
        }

        /* Pagination info */
        .dataTables_wrapper .dataTables_info {
            color: #64748b !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            margin-top: 16px !important;
            text-align: center !important;
            padding: 12px !important;
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px) !important;
            border-radius: 12px !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
        }

        /* DataTables Buttons - Premium */
        .dt-buttons {
            margin-bottom: 24px !important;
            display: flex !important;
            gap: 8px !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
        }

        .dt-buttons .btn {
            margin: 0 !important;
            min-width: 120px;
        }

        /* Responsive - Mobil Uyumlu */
        @media (max-width: 768px) {
            .dataTables_wrapper {
                padding: 16px;
                margin: 12px 0;
                overflow-x: auto;
            }

            .dataTables_wrapper .row:first-child {
                flex-direction: column;
                gap: 16px;
            }

            .dataTables_wrapper .dataTables_filter {
                text-align: left;
            }

            .dataTables_wrapper .dataTables_filter input {
                width: 100%;
            }

            .dataTables_wrapper .dataTable {
                min-width: 800px !important;
                width: 800px !important;
            }

            .dataTables_wrapper .dataTable th,
            .dataTables_wrapper .dataTable td {
                padding: 8px 6px !important;
                font-size: 12px !important;
            }

            .dataTables_wrapper .dataTable th:last-child,
            .dataTables_wrapper .dataTable td:last-child {
                width: 120px !important;
                min-width: 120px !important;
            }

            .dataTables_wrapper .btn {
                padding: 6px 8px !important;
                font-size: 11px !important;
                margin: 1px !important;
            }

            .dataTables_wrapper .btn i {
                display: none !important;
            }

            .dt-buttons {
                justify-content: flex-start;
                flex-wrap: wrap !important;
            }

            .dt-buttons .btn {
                min-width: 80px;
                font-size: 10px;
                padding: 6px 8px;
                margin: 2px !important;
            }

            .page-navigation {
                padding: 12px;
            }

            .page-navigation .nav-buttons {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .page-navigation .nav-btn {
                padding: 10px 12px;
                font-size: 12px;
            }
        }

        /* ===================================================== */
        /* GEÇİŞ BUTONLARI - SAYFALAR ARASI NAVİGASYON */
        /* ===================================================== */

        .page-navigation {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 16px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }

        .page-navigation h3 {
            color: #475569;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .page-navigation .nav-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
        }

        .page-navigation .nav-btn {
            display: flex;
            align-items: center;
            padding: 14px 20px;
            background: #ffffff;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            text-decoration: none;
            color: #475569;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .page-navigation .nav-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
            transition: left 0.5s;
        }

        .page-navigation .nav-btn:hover::before {
            left: 100%;
        }

        .page-navigation .nav-btn:hover {
            border-color: #3b82f6;
            color: #3b82f6;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.15);
        }

        .page-navigation .nav-btn i {
            font-size: 18px;
            margin-right: 12px;
            transition: transform 0.3s ease;
        }

        .page-navigation .nav-btn:hover i {
            transform: scale(1.2);
        }

        .page-navigation .nav-btn.primary {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #ffffff;
            border-color: #3b82f6;
        }

        .page-navigation .nav-btn.primary:hover {
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.3);
        }

        .page-navigation .nav-btn.success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #ffffff;
            border-color: #10b981;
        }

        .page-navigation .nav-btn.success:hover {
            box-shadow: 0 8px 24px rgba(16, 185, 129, 0.3);
        }

        .page-navigation .nav-btn.warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #ffffff;
            border-color: #f59e0b;
        }

        .page-navigation .nav-btn.warning:hover {
            box-shadow: 0 8px 24px rgba(245, 158, 11, 0.3);
        }

        .page-navigation .nav-btn.danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: #ffffff;
            border-color: #ef4444;
        }

        .page-navigation .nav-btn.danger:hover {
            box-shadow: 0 8px 24px rgba(239, 68, 68, 0.3);
        }

        @media (max-width: 768px) {
            .page-navigation .nav-buttons {
                grid-template-columns: 1fr;
            }

            .page-navigation .nav-btn {
                padding: 12px 16px;
                font-size: 13px;
            }
        }

        /* ===== GLOBAL ADMIN MODERNIZATION ===== */

        /* Modern Page Headers */
        .page-title {
            font-size: 32px !important;
            font-weight: 700 !important;
            color: #2c3e50 !important;
            margin-bottom: 8px !important;
            text-shadow: none !important;
            letter-spacing: -0.5px !important;
        }

        .page-bar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-radius: 12px !important;
            padding: 20px 25px !important;
            margin-bottom: 25px !important;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3) !important;
        }

        .page-bar .page-breadcrumb {
            margin: 0 !important;
            padding: 0 !important;
            background: none !important;
        }

        .page-bar .page-breadcrumb>li {
            margin: 0 !important;
            padding: 0 !important;
        }

        .page-bar .page-breadcrumb>li>a {
            color: rgba(255, 255, 255, 0.9) !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            padding: 6px 12px !important;
            border-radius: 20px !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
        }

        .page-bar .page-breadcrumb>li>a:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.15) !important;
            transform: translateY(-1px) !important;
        }

        .page-bar .page-breadcrumb>li>.fa {
            color: rgba(255, 255, 255, 0.7) !important;
            font-size: 10px !important;
            margin: 0 5px !important;
        }

        .page-bar .page-breadcrumb>li>span {
            color: #fff !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            background: rgba(255, 255, 255, 0.2) !important;
            padding: 6px 12px !important;
            border-radius: 20px !important;
        }

        /* Modern Portlets */
        .portlet {
            border-radius: 12px !important;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08) !important;
            border: none !important;
            overflow: hidden !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease !important;
        }

        .portlet:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12) !important;
        }

        .portlet-title {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: 18px 25px !important;
        }

        .portlet-title .caption {
            margin: 0 !important;
        }

        .portlet-title .caption>span {
            font-size: 16px !important;
            font-weight: 600 !important;
            color: #2c3e50 !important;
            text-transform: none !important;
            letter-spacing: 0.2px !important;
        }

        .portlet-title .caption>i {
            font-size: 18px !important;
            margin-right: 10px !important;
            color: #667eea !important;
        }

        .portlet-body {
            padding: 25px !important;
        }

        /* Modern Tables */
        .table {
            border-radius: 8px !important;
            overflow: hidden !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05) !important;
        }

        .table>thead>tr>th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: #fff !important;
            font-weight: 600 !important;
            font-size: 13px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            border: none !important;
            padding: 15px 12px !important;
        }

        .table>tbody>tr {
            transition: background-color 0.2s ease !important;
        }

        .table>tbody>tr:hover {
            background-color: #f8fafc !important;
        }

        .table>tbody>tr>td {
            padding: 15px 12px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #f1f5f9 !important;
        }

        /* Modern Forms */
        .form-control {
            border-radius: 8px !important;
            border: 2px solid #e2e8f0 !important;
            padding: 12px 15px !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
        }

        .form-control:focus {
            border-color: #667eea !important;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
        }

        .form-group label {
            font-weight: 600 !important;
            color: #475569 !important;
            margin-bottom: 8px !important;
            font-size: 13px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        /* Modern Buttons */
        .btn {
            border-radius: 8px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            padding: 12px 24px !important;
            transition: all 0.3s ease !important;
            text-transform: none !important;
            letter-spacing: 0.2px !important;
            border: none !important;
        }

        .btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        .btn-success {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%) !important;
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        }

        .btn-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        }

        /* Modern Labels */
        .label {
            border-radius: 20px !important;
            font-weight: 600 !important;
            font-size: 11px !important;
            padding: 6px 12px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        .label-success {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%) !important;
        }

        .label-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%) !important;
        }

        .label-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
        }

        .label-info {
            background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
        }

        .label-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        /* Modern Badges */
        .badge {
            border-radius: 20px !important;
            font-weight: 600 !important;
            font-size: 11px !important;
            padding: 5px 10px !important;
        }

        /* Modern Pagination */
        .pagination>li>a,
        .pagination>li>span {
            border-radius: 8px !important;
            margin: 0 3px !important;
            border: none !important;
            color: #667eea !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
        }

        .pagination>li>a:hover,
        .pagination>.active>a,
        .pagination>.active>span {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: #fff !important;
            transform: translateY(-1px) !important;
        }

        /* Modern Alerts */
        .alert {
            border-radius: 10px !important;
            border: none !important;
            font-weight: 500 !important;
        }

        /* Modern Progress Bars */
        .progress {
            border-radius: 20px !important;
            height: 8px !important;
            background: #f1f5f9 !important;
        }

        .progress-bar {
            border-radius: 20px !important;
        }

        /* Sidebar z-index yükseltme - TÜM EKRAN BOYUTLARI İÇİN */
        .page-sidebar-wrapper {
            z-index: 1000 !important;
            position: relative !important;
        }

        .page-sidebar {
            z-index: 1000 !important;
            position: relative !important;
        }

        /* Responsive Improvements - TAŞMA SORUNLARI ÇÖZÜMÜ */
        @media (max-width: 1200px) {

            /* Page wrapper pozisyon düzeltmeleri */
            .page-content-wrapper {
                overflow-x: hidden !important;
                position: relative !important;
                z-index: 0 !important;
                margin-left: 0 !important;
                padding-left: 0 !important;
            }

            .page-content {
                overflow-x: hidden !important;
                padding: 15px !important;
                position: relative !important;
                z-index: 0 !important;
                background: #fff !important;
            }

            .portlet {
                overflow: visible !important;
                margin-bottom: 20px !important;
                position: relative !important;
                z-index: 1 !important;
            }

            .portlet-body {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch !important;
                padding: 15px !important;
                position: relative !important;
                z-index: 1 !important;
            }

            .table-responsive {
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch !important;
                position: relative !important;
                z-index: 1 !important;
            }

            .table {
                min-width: 800px !important;
                width: auto !important;
                position: relative !important;
            }
        }

        @media (max-width: 992px) {
            .page-content-wrapper {
                position: relative !important;
                z-index: 0 !important;
                margin-left: 0 !important;
            }

            .page-content {
                padding: 10px !important;
                position: relative !important;
                z-index: 0 !important;
                background: #fff !important;
            }

            .portlet-body {
                padding: 10px !important;
                position: relative !important;
                z-index: 1 !important;
            }

            .table {
                min-width: 700px !important;
                position: relative !important;
            }

            .table>thead>tr>th,
            .table>tbody>tr>td {
                padding: 12px 8px !important;
                font-size: 12px !important;
                white-space: nowrap !important;
            }

            .btn {
                padding: 10px 16px !important;
                font-size: 13px !important;
                margin-bottom: 5px !important;
            }

            .form-control {
                font-size: 13px !important;
                padding: 10px 12px !important;
            }
        }

        @media (max-width: 768px) {
            .page-content-wrapper {
                position: relative !important;
                z-index: 0 !important;
                margin-left: 0 !important;
                padding-left: 0 !important;
            }

            .page-content {
                position: relative !important;
                z-index: 0 !important;
                background: #fff !important;
                padding-left: 0 !important;
            }

            .page-title {
                font-size: 22px !important;
                margin-bottom: 15px !important;
            }

            .page-bar {
                padding: 15px 20px !important;
                margin-bottom: 20px !important;
                position: relative !important;
                z-index: 1 !important;
            }

            .page-bar .page-breadcrumb>li>a,
            .page-bar .page-breadcrumb>li>span {
                font-size: 11px !important;
                padding: 4px 8px !important;
            }

            .portlet {
                position: relative !important;
                z-index: 1 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .portlet-body {
                padding: 8px !important;
                overflow-x: auto !important;
                position: relative !important;
                z-index: 1 !important;
            }

            .table {
                min-width: 600px !important;
                font-size: 11px !important;
                position: relative !important;
            }

            .table>thead>tr>th,
            .table>tbody>tr>td {
                padding: 8px 6px !important;
                font-size: 11px !important;
                white-space: nowrap !important;
            }

            .btn {
                padding: 8px 12px !important;
                font-size: 12px !important;
                margin-bottom: 5px !important;
                display: inline-block !important;
            }

            .form-group {
                margin-bottom: 15px !important;
            }

            .form-control {
                font-size: 12px !important;
                padding: 8px 10px !important;
            }

            .form-group label {
                font-size: 11px !important;
                margin-bottom: 5px !important;
            }

            .label {
                font-size: 9px !important;
                padding: 3px 6px !important;
            }

            .badge {
                font-size: 9px !important;
                padding: 3px 6px !important;
            }

            /* Row overflow kontrolü */
            .row {
                margin: 0 -5px !important;
                position: relative !important;
                z-index: 1 !important;
            }

            .row>div[class*="col-"] {
                padding: 0 5px !important;
                margin-bottom: 10px !important;
                position: relative !important;
                z-index: 1 !important;
            }
        }

        @media (max-width: 480px) {
            .page-content-wrapper {
                position: relative !important;
                z-index: 0 !important;
                margin-left: 0 !important;
                padding-left: 0 !important;
            }

            .page-content {
                padding: 5px !important;
                position: relative !important;
                z-index: 0 !important;
                background: #fff !important;
                padding-left: 0 !important;
            }

            .page-title {
                font-size: 18px !important;
            }

            .portlet {
                position: relative !important;
                z-index: 1 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }

            .portlet-body {
                padding: 5px !important;
                position: relative !important;
                z-index: 1 !important;
            }

            .table {
                min-width: 500px !important;
                font-size: 10px !important;
                position: relative !important;
            }

            .table>thead>tr>th,
            .table>tbody>tr>td {
                padding: 6px 4px !important;
                font-size: 10px !important;
            }

            .btn {
                padding: 6px 10px !important;
                font-size: 11px !important;
                width: 100% !important;
                margin-bottom: 8px !important;
            }

            .form-control {
                font-size: 12px !important;
                padding: 6px 8px !important;
            }
        }

        /* CUSTOM MOBILE SIDEBAR TOGGLE FIX */
        @media (max-width: 991px) {
            .page-sidebar-wrapper {
                display: none !important;
                position: fixed !important;
                top: 50px !important;
                /* Adjust based on header height */
                left: 0 !important;
                bottom: 0 !important;
                width: 260px !important;
                /* Wider sidebar for better touch targets */
                z-index: 99999 !important;
                background-color: #ffffff !important;
                /* Light background to match sidebar */
                overflow-y: auto !important;
                transition: transform 0.3s ease !important;
                box-shadow: 5px 0 25px rgba(0, 0, 0, 0.15) !important;
                border-right: 1px solid #eee;
            }

            /* Ensure internal sidebar elements are visible and NOT transformed */
            body.page-sidebar-mobile-open .page-sidebar-wrapper .page-sidebar {
                display: block !important;
                width: 100% !important;
                margin: 0 !important;
                background-color: transparent !important;
                transform: none !important;
                /* Override any existing transform */
                position: relative !important;
                left: 0 !important;
                visibility: visible !important;
            }

            .page-sidebar-wrapper .page-sidebar-menu {
                display: block !important;
                margin-top: 0 !important;
            }

            body.page-sidebar-mobile-open .page-sidebar-wrapper {
                display: block !important;
                animation: slideRight 0.3s ease forwards;
            }

            /* Overlay effect when menu is open */
            body.page-sidebar-mobile-open::before {
                content: '';
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 9999;
            }

            @keyframes slideRight {
                from {
                    transform: translateX(-100%);
                }

                to {
                    transform: translateX(0);
                }
            }
        }
    </style>

</head>

<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">

    <!-- BEGIN HEADER -->

    <div class="page-header navbar navbar-fixed-top">

        <!-- BEGIN HEADER INNER -->

        <div class="page-header-inner ">

            <!-- BEGIN LOGO -->

            <div class="page-logo"> <a href="<?php echo e(route('admin.home')); ?>"> <img
                        src="<?php echo e(asset('/')); ?>sitesetting_images/thumb/<?php echo e($siteSetting->site_logo); ?>" alt="logo"
                        style="max-width:170px; max-height:40px;" /> <!-- class="logo-default" --></a>

                <div class="menu-toggler sidebar-toggler"> </div>

            </div>

            <!-- END LOGO -->

            <!-- BEGIN RESPONSIVE MENU TOGGLER -->

            <!-- FIXED: Direct Sidebar Toggle for Mobile -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" id="mobileDirectSidebarToggle">
                <i class="fa fa-bars"></i>
            </a>

            <!-- END RESPONSIVE MENU TOGGLER -->

            <!-- BEGIN TOP NAVIGATION MENU -->

            <?php echo $__env->make('admin.shared.top_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <!-- END TOP NAVIGATION MENU -->

        </div>

        <!-- END HEADER INNER -->

    </div>

    <!-- END HEADER -->

    <!-- BEGIN HEADER & CONTENT DIVIDER -->

    <div class="clearfix"> </div>

    <!-- END HEADER & CONTENT DIVIDER -->

    <!-- BEGIN CONTAINER -->

    <div class="page-container">

        <!-- BEGIN SIDEBAR -->

        <div class="page-sidebar-wrapper"> <?php echo $__env->make('admin.shared.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </div>

        <!-- END SIDEBAR -->

        <!-- BEGIN CONTENT -->

        <!-- BEGIN CONTENT -->

        <?php if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->role && Auth::guard('admin')->user()->role->role_name != 'SUPER_ADMIN' && !Auth::guard('admin')->user()->is_manager): ?>
            <?php
                $u = Auth::guard('admin')->user();
                $now = \Carbon\Carbon::now();
                $today = $now->toDateString();
                $accumulatedInCall = ($u->today_date == $today) ? $u->today_in_call_seconds : 0;
                $accumulatedBreak = ($u->today_date == $today) ? $u->today_break_seconds : 0;

                // Add current status duration if not offline
                if ($u->status_updated_at && $u->current_status != 'OFFLINE') {
                    $diff = $now->diffInSeconds(\Carbon\Carbon::parse($u->status_updated_at));
                    if ($u->current_status == 'BREAK')
                        $accumulatedBreak += $diff;
                    if ($u->current_status == 'IN_CALL')
                        $accumulatedInCall += $diff;
                }

                $limitMins = \App\Models\SystemConfig::where('key', 'daily_break_limit')->first()->value ?? 60;
                $limitSeconds = $limitMins * 60;
                $remainingBreak = max(0, $limitSeconds - $accumulatedBreak);
            ?>
            <!-- Hidden Template for Control Panel -->
            <div id="global-control-panel-template" style="display: none;">
                <!-- MODERN CONTROL PANEL -->
                <div class="row" style="margin-bottom: 25px;">
                    <div class="col-md-12">
                        <div class="portlet light bordered"
                            style="background: #fff; margin-bottom: 0 !important; border-radius: 16px !important; border: none !important; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.04), 0 4px 6px -2px rgba(0,0,0,0.02) !important;">
                            <div class="portlet-body"
                                style="padding: 15px 30px !important; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">

                                <!-- Left: Branding & Title -->
                                <div style="display: flex; align-items: center; gap: 18px;">
                                    <div
                                        style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2);">
                                        <i class="icon-speedometer" style="font-size: 22px; color: #fff;"></i>
                                    </div>
                                    <div class="hidden-xs">
                                        <h4
                                            style="margin: 0; font-weight: 800; color: #1e293b; letter-spacing: -0.5px; font-size: 16px;">
                                            KONTROL PANELİ</h4>
                                        <span
                                            style="font-size: 12px; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Durum
                                            Yönetimi</span>
                                    </div>
                                </div>

                                <!-- Center: Live Timer (Emphasized) -->
                                <div
                                    style="background: #f8fafc; padding: 10px 25px; border-radius: 14px; border: 1px solid #f1f5f9; display: flex; align-items: center; gap: 12px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.01);">
                                    <i class="fa fa-clock-o" style="color: #64748b; font-size: 20px;"></i>
                                    <span id="global-status-timer-display"
                                        style="font-family: 'JetBrains Mono', monospace; font-size: 24px; font-weight: 800; color: #334155; letter-spacing: -1px;">00:00:00</span>
                                </div>

                                <!-- Right: Stats & Actions Group -->
                                <div style="display: flex; align-items: center; gap: 30px; flex-wrap: wrap;">
                                    <!-- Live Stats -->
                                    <div class="hidden-sm hidden-xs"
                                        style="display: flex; gap: 25px; align-items: center; padding-right: 30px; border-right: 1px solid #f1f5f9;">
                                        <div style="text-align: center;">
                                            <div
                                                style="font-size: 10px; color: #94a3b8; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px;">
                                                ÇAĞRI</div>
                                            <div id="header-stats-incall"
                                                style="font-size: 14px; font-weight: 800; color: #3b82f6;"
                                                data-seconds="<?php echo e($accumulatedInCall ?? 0); ?>">
                                                <?php echo e(gmdate("H:i:s", $accumulatedInCall ?? 0)); ?>

                                            </div>
                                        </div>
                                        <div style="text-align: center;">
                                            <div
                                                style="font-size: 10px; color: #94a3b8; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px;">
                                                MOLA</div>
                                            <div id="header-stats-break"
                                                style="font-size: 14px; font-weight: 800; color: #f59e0b;"
                                                data-seconds="<?php echo e($accumulatedBreak ?? 0); ?>">
                                                <?php echo e(gmdate("H:i:s", $accumulatedBreak ?? 0)); ?>

                                            </div>
                                        </div>
                                        <div style="text-align: center;">
                                            <div
                                                style="font-size: 10px; color: #94a3b8; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px;">
                                                KALAN</div>
                                            <div id="header-stats-remaining"
                                                style="font-size: 14px; font-weight: 800; color: <?php echo e(($remainingBreak ?? 0) > 0 ? '#10b981' : '#ef4444'); ?>;"
                                                data-seconds="<?php echo e($remainingBreak ?? 0); ?>"
                                                data-limit="<?php echo e($limitSeconds ?? 3600); ?>">
                                                <?php echo e(floor(($remainingBreak ?? 0) / 60)); ?>:<?php echo e(str_pad(($remainingBreak ?? 0) % 60, 2, '0', STR_PAD_LEFT)); ?>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status Badge & Dropdown -->
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <?php
                                            $currentStatus = Auth::guard('admin')->user()->current_status ?? 'OFFLINE';
                                            $statusConfig = [
                                                'ONLINE' => ['class' => 'success', 'text' => 'Çevrimiçi', 'icon' => 'check-circle'],
                                                'BREAK' => ['class' => 'warning', 'text' => 'Molada', 'icon' => 'coffee'],
                                                'IN_CALL' => ['class' => 'primary', 'text' => 'Çağrıda', 'icon' => 'phone'],
                                                'SYSTEM_ERROR' => ['class' => 'danger', 'text' => 'Sistem Hatası', 'icon' => 'exclamation-triangle'],
                                                'OFFLINE' => ['class' => 'default', 'text' => 'Çevrimdışı', 'icon' => 'power-off']
                                            ];
                                            $conf = $statusConfig[$currentStatus] ?? $statusConfig['OFFLINE'];
                                        ?>

                                        <span id="global-status-badge" class="badge badge-<?php echo e($conf['class']); ?>"
                                            style="padding: 10px 18px; font-size: 12px; font-weight: 700; border-radius: 10px; text-transform: uppercase; letter-spacing: 0.5px;">
                                            <i class="fa fa-<?php echo e($conf['icon']); ?>" style="margin-right: 6px;"></i>
                                            <span id="global-status-text"><?php echo e($conf['text']); ?></span>
                                        </span>

                                        <div class="btn-group">
                                            <button type="button" class="btn btn-default dropdown-toggle"
                                                data-toggle="dropdown" aria-expanded="false"
                                                style="border-radius: 12px; border: 1px solid #e2e8f0; background: #fff; padding: 10px 20px; font-weight: 700; color: #475569; transition: all 0.2s;">
                                                <i class="fa fa-refresh" style="margin-right: 8px; color: #94a3b8;"></i>
                                                Durum Değiştir <i class="fa fa-angle-down" style="margin-left: 8px;"></i>
                                            </button>
                                            <ul class="dropdown-menu pull-right" role="menu"
                                                style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.1); margin-top: 10px; padding: 8px;">
                                                <li><a href="javascript:;" onclick="updateGlobalStatus('ONLINE')"
                                                        style="padding: 10px 15px; font-weight: 600; border-radius: 8px;"><i
                                                            class="fa fa-check-circle text-success"
                                                            style="width: 20px;"></i> Çevrimiçi</a></li>
                                                <li><a href="javascript:;" onclick="updateGlobalStatus('BREAK')"
                                                        style="padding: 10px 15px; font-weight: 600; border-radius: 8px;"><i
                                                            class="fa fa-coffee text-warning" style="width: 20px;"></i>
                                                        Molada</a></li>
                                                <li><a href="javascript:;" onclick="updateGlobalStatus('IN_CALL')"
                                                        style="padding: 10px 15px; font-weight: 600; border-radius: 8px;"><i
                                                            class="fa fa-phone text-primary" style="width: 20px;"></i>
                                                        Çağrıda</a></li>
                                                <li class="divider" style="margin: 4px 0;"></li>
                                                <li><a href="<?php echo e(route('admin.logout')); ?>"
                                                        style="padding: 10px 15px; font-weight: 600; border-radius: 8px; color: #ef4444;"><i
                                                            class="fa fa-sign-out" style="width: 20px;"></i> Güvenli
                                                        Çıkış</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /MODERN CONTROL PANEL -->
                </div>
            </div>

            <script>
                // Inject Control Panel into page content on load
                document.addEventListener("DOMContentLoaded", function () {
                    var content = document.querySelector('.page-content');
                    var panelFragment = document.getElementById('global-control-panel-template');
                    if (content && panelFragment) {
                        content.insertAdjacentHTML('afterbegin', panelFragment.innerHTML);
                        panelFragment.remove(); // Remove template to prevent ID duplication
                    }
                });
            </script>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>

        <!-- END CONTENT -->

    </div>

    <!-- END CONTAINER -->

    <!-- BEGIN FOOTER -->

    <div class="page-footer">

        <div class="page-footer-inner"> <?php echo e(date('Y')); ?> © <?php echo e($siteSetting->site_name); ?>. Admin Panel. </div>

        <div class="scroll-to-top"> <i class="icon-arrow-up"></i> </div>

    </div>

    <!-- END FOOTER -->

    <!-- İŞLEMLER MODAL -->
    <div id="actionsModal">
        <div class="modal-overlay"></div>
        <div class="modal-content">
            <div class="modal-header">
                <h4><i class="fa fa-cog"></i> İşlemler</h4>
                <button type="button" class="close-btn" onclick="closeActionsModal()">&times;</button>
            </div>
            <div class="modal-body" id="actionsModalBody">
                <!-- İşlemler buraya yüklenecek -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-close-modal" onclick="closeActionsModal()">Kapat</button>
            </div>
        </div>
    </div>

    <!--[if lt IE 9]>

                <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/respond.min.js"></script>

                <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/excanvas.min.js"></script> 

                <![endif]-->

    <!-- BEGIN CORE PLUGINS -->

    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/jquery.min.js" type="text/javascript"></script>

    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/bootstrap/js/bootstrap.min.js"
        type="text/javascript"></script>

    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/jquery-ui/jquery-ui.min.js"
        type="text/javascript"></script>

    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>

    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js"
        type="text/javascript"></script>

    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js"
        type="text/javascript"></script>

    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>

    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/uniform/jquery.uniform.min.js"
        type="text/javascript"></script>

    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"
        type="text/javascript"></script>

    <!-- END CORE PLUGINS -->

    <!-- BEGIN THEME GLOBAL SCRIPTS -->

    <script src="<?php echo e(asset('/')); ?>admin_assets/global/scripts/app.min.js" type="text/javascript"></script>

    <!-- END THEME GLOBAL SCRIPTS -->

    <!-- BEGIN THEME LAYOUT SCRIPTS -->

    <script src="<?php echo e(asset('/')); ?>admin_assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>

    <script src="<?php echo e(asset('/')); ?>admin_assets/layouts/layout/scripts/demo.js" type="text/javascript"></script>

    <script src="<?php echo e(asset('/')); ?>admin_assets/layouts/global/scripts/quick-sidebar.min.js"
        type="text/javascript"></script>

    <!-- END THEME LAYOUT SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS -->

    <!-- Modern DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/select/1.7.0/js/select.bootstrap5.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"
        type="text/javascript"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"
        type="text/javascript"></script>

    <!-- Export Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>

    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/jquery.scrollTo.min.js" type="text/javascript"></script>

    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"
        type="text/javascript"></script>

    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/datatables/datatables.min.js"
        type="text/javascript"></script>

    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"
        type="text/javascript"></script>

    <script
        src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"
        type="text/javascript"></script>

    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>

    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/Bootstrap-3-Typeahead/bootstrap3-typeahead.min.js"
        type="text/javascript"></script>
    <script src="<?php echo e(asset('jquery.filer/js/jquery.filer.min.js')); ?>"></script>
    <!-- END PAGE LEVEL PLUGINS -->

    <!-- Duplicate script removed -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->

    <script src="<?php echo e(asset('/')); ?>admin_assets/pages/scripts/components-date-time-pickers.min.js"
        type="text/javascript"></script>

    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/select2/js/select2.full.min.js"
        type="text/javascript"></script>

    <!-- END PAGE LEVEL SCRIPTS -->




    <script>
        $('#flash-overlay-modal').modal();

        // Global Turkish Localization for DataTables
        window.dataTableTurkish = {
            "emptyTable": "Tabloda herhangi bir veri mevcut değil",
            "info": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
            "infoEmpty": "Kayıt bulunamadı",
            "infoFiltered": "(_MAX_ kayıt içinden filtrelendi)",
            "infoThousands": ".",
            "lengthMenu": "_MENU_ kayıt göster",
            "loadingRecords": "Yükleniyor...",
            "processing": "İşleniyor...",
            "search": "Ara:",
            "zeroRecords": "Eşleşen kayıt bulunamadı",
            "paginate": {
                "first": "İlk",
                "last": "Son",
                "next": "Sonraki",
                "previous": "Önceki"
            },
            "aria": {
                "sortAscending": ": artan sıralama",
                "sortDescending": ": azalan sıralama"
            },
            "select": {
                "rows": {
                    "_": "%d satır seçildi",
                    "1": "1 satır seçildi"
                }
            },
            "buttons": {
                "copy": "Kopyala",
                "colvis": "Sütunlar",
                "excel": "Excel",
                "pdf": "PDF",
                "print": "Yazdır"
            }
        };

        // DataTables Defaults
        $.extend(true, $.fn.dataTable.defaults, {
            language: window.dataTableTurkish,
            responsive: false,
            scrollX: true,
            autoWidth: false,
            pageLength: 25,
            pagingType: 'full_numbers',
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            initComplete: function () {
                var api = this.api();
                setTimeout(function () {
                    api.columns.adjust().draw(false);
                }, 500);
            },
            drawCallback: function () {
                var api = this.api();
                // Avoid infinite loops by checking if we just adjusted
                if (!this.adjusting) {
                    this.adjusting = true;
                    setTimeout(function () {
                        api.columns.adjust();
                        this.adjusting = false;
                    }.bind(this), 100);
                }
            }
        });

        $(window).on('resize', function () {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
        });

        // Global DataTables helper
        window.initModernDataTable = function (selector, options = {}) {
            var defaultOptions = {
                dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" +
                    "<'row'<'col-sm-12'B>>",
                buttons: [
                    { extend: 'copy', className: 'btn btn-primary btn-sm' },
                    { extend: 'excel', className: 'btn btn-success btn-sm' },
                    { extend: 'pdf', className: 'btn btn-danger btn-sm' },
                    { extend: 'print', className: 'btn btn-info btn-sm' },
                    { extend: 'colvis', className: 'btn btn-warning btn-sm' }
                ],
                initComplete: function (settings, json) {
                    $('.dt-buttons').addClass('btn-group mt-3');
                    $('.dt-buttons .btn').removeClass('dt-button');
                    var api = this.api();
                    setTimeout(function () {
                        api.columns.adjust();
                    }, 200);
                }
            };

            var finalOptions = $.extend(true, {}, defaultOptions, options);
            return $(selector).DataTable(finalOptions);
        };
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>

    <!-- Global Notification Modal -->
    <div class="modal fade" id="globalNotificationModal" tabindex="-1" role="dialog" style="z-index: 10001;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <h4 class="modal-title text-primary bold"><i class="fa fa-bell"></i> SİSTEM BİLDİRİMİ</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center" style="padding: 30px;">
                    <p id="globalNotificationMessage" style="font-size: 18px; color: #333;"></p>
                </div>
                <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0;">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Anladım</button>
                </div>
            </div>
        </div>
    </div>

    <?php if(Auth::guard('admin')->check()): ?>
        <script>
            $(document).ready(function () {
                function checkNotifications() {
                    $.get("<?php echo e(route('admin.crm.getMyNotifications')); ?>", function (data) {
                        if (data && data.length > 0) {
                            data.forEach(function (notification) {
                                let modalTitle = 'SİSTEM BİLDİRİMİ';
                                let modalIcon = 'fa-bell';
                                let headerBg = 'linear-gradient(135deg, #6e8efb, #a777e3)'; // Default Blue
                                let iconColor = 'text-primary';

                                if (notification.type === 'alert') {
                                    modalTitle = 'KRİTİK UYARI';
                                    modalIcon = 'fa-exclamation-triangle';
                                    headerBg = 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)'; // Red/Warning
                                    iconColor = 'text-danger';
                                } else if (notification.type === 'toast') {
                                    modalTitle = 'BİLGİ';
                                    modalIcon = 'fa-check-circle';
                                    headerBg = 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)'; // Green/Success
                                    iconColor = 'text-success';
                                }

                                // Apply Styles
                                $('#notificationHeader').css('background', headerBg);
                                $('#globalNotificationModal .modal-title').html(`<i class="fa ${modalIcon}"></i> ${modalTitle}`);
                                $('#notificationIconContainer').html(`<i class="fa ${modalIcon} ${iconColor} animate__animated animate__bounceIn"></i>`);
                                $('#globalNotificationMessage').text(notification.message);

                                $('#globalNotificationModal').modal('show');

                                $.post("<?php echo e(route('admin.crm.markNotificationRead')); ?>", {
                                    _token: "<?php echo e(csrf_token()); ?>",
                                    id: notification.id
                                });
                            });
                        }
                    });
                }
                setInterval(checkNotifications, 20000);
                setTimeout(checkNotifications, 3000);
            });
        </script>
    <?php endif; ?>

    <script type="text/JavaScript">

            $(document).ready(function(){

            $(document).scrollTo('.msg_cls_for_focus', 2000);
            
            // =====================================================
            // GLOBAL MODAL SİSTEMİ - TÜM TABLOLAR İÇİN
            // =====================================================
            
            // Dropdown toggle tıklaması - Modal aç
            $(document).on('click', '.dropdown-toggle, [data-toggle="dropdown"]', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                var $btn = $(this);
                var $parent = $btn.parent();
                var $menu = $parent.find('.dropdown-menu');
                
                // Menü içeriğini al
                var menuItems = [];
                $menu.find('li a, > a').each(function() {
                    var $a = $(this);
                    var href = $a.attr('href') || '#';
                    var onclick = $a.attr('onclick') || '';
                    var text = $a.text().trim();
                    var icon = '';
                    
                    // İkon varsa al
                    var $icon = $a.find('i');
                    if ($icon.length) {
                        icon = $icon.attr('class') || '';
                    }
                    
                    // Danger class kontrolü
                    var isDanger = $a.hasClass('text-danger') || text.toLowerCase().includes('sil');
                    
                    menuItems.push({
                        href: href,
                        onclick: onclick,
                        text: text,
                        icon: icon,
                        isDanger: isDanger
                    });
                });
                
                // Modal içeriğini oluştur
                var modalContent = '';
                menuItems.forEach(function(item) {
                    var dangerClass = item.isDanger ? ' text-danger' : '';
                    var iconHtml = item.icon ? '<i class="' + item.icon + '"></i>' : '<i class="fa fa-circle-o"></i>';
                    
                    if (item.onclick) {
                        // onclick varsa - fonksiyonu çalıştır ve modal'ı kapat
                        modalContent += '<a class="action-item' + dangerClass + '" href="javascript:;" data-onclick="' + item.onclick.replace(/"/g, '&quot;') + '">' + iconHtml + ' ' + item.text + '</a>';
                    } else if (item.href && item.href !== '#' && item.href !== 'javascript:void(0)' && item.href !== 'javascript:;') {
                        modalContent += '<a class="action-item' + dangerClass + '" href="' + item.href + '">' + iconHtml + ' ' + item.text + '</a>';
                    } else {
                        modalContent += '<a class="action-item' + dangerClass + '" href="javascript:;">' + iconHtml + ' ' + item.text + '</a>';
                    }
                });
                
                // Modal'ı aç
                $('#actionsModalBody').html(modalContent);
                $('#actionsModal').addClass('show');
            });
            
            // Modal overlay tıklaması
            $(document).on('click', '#actionsModal .modal-overlay', function() {
                closeActionsModal();
            });
            
            // Modal içindeki action-item tıklaması
            $(document).on('click', '#actionsModal .action-item', function(e) {
                var $this = $(this);
                var onclick = $this.data('onclick');
                var href = $this.attr('href');
                
                // Modal'ı kapat
                closeActionsModal();
                
                // onclick varsa çalıştır
                if (onclick) {
                    e.preventDefault();
                    setTimeout(function() {
                        eval(onclick);
                    }, 100);
                    return false;
                }
                
                // href varsa yönlendir
                if (href && href !== 'javascript:;' && href !== '#') {
                    window.location.href = href;
                    return false;
                }
            });
            
            // ESC tuşu ile kapat
            $(document).on('keyup', function(e) {
                if (e.keyCode === 27) {
                    closeActionsModal();
                }
            });

            });

            // Modal kapatma fonksiyonu
            function closeActionsModal() {
                $('#actionsModal').removeClass('show');
            }
            
            // Global erişim için
            window.closeActionsModal = closeActionsModal;

            function showProcessingForm(btn_id){		

            $("#"+btn_id).val( 'Processing .....' );

            $("#"+btn_id).attr('disabled','disabled');

            }

        </script>

    <!-- Global Report Styles -->
    <style>
        /* Modern Report Header Styles */
        .report-page-header {
            background: linear-gradient(135deg, #059669 0%, #10b981 100%);
            border-radius: 12px;
            padding: 25px 30px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        }

        .report-page-header.service-requests {
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
        }

        .report-page-header.jobs {
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .report-page-header.companies {
            background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
        }

        .report-page-header.applications {
            background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .report-page-header .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .report-page-header .header-left {
            flex: 1;
        }

        .breadcrumb-modern {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 15px;
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 15px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .breadcrumb-modern a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 4px 8px;
            border-radius: 12px;
        }

        .breadcrumb-modern a:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }

        .breadcrumb-modern .separator {
            color: rgba(255, 255, 255, 0.6);
            font-size: 10px;
            opacity: 0.8;
        }

        .breadcrumb-modern .current {
            color: #fff;
            font-weight: 700;
            font-size: 12px;
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 12px;
        }

        .page-title-modern {
            color: #fff;
            font-size: 32px;
            font-weight: 800;
            margin: 0 0 8px 0;
            display: flex;
            align-items: center;
            gap: 15px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            letter-spacing: -0.5px;
        }

        .page-title-modern i {
            opacity: 0.95;
            font-size: 28px;
            background: rgba(255, 255, 255, 0.2);
            padding: 10px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 15px;
            margin: 0;
            font-weight: 400;
            letter-spacing: 0.2px;
            line-height: 1.4;
        }

        .btn-outline-back {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-outline-back:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        /* Global Stat Cards */
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 22px;
            text-align: center;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            border-left: 5px solid;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        }

        .stat-card .stat-number {
            font-size: 36px;
            font-weight: 700;
        }

        .stat-card .stat-label {
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
        }

        .stat-blue {
            border-left-color: #3b82f6;
        }

        .stat-blue .stat-number {
            color: #3b82f6;
        }

        .stat-green {
            border-left-color: #22c55e;
        }

        .stat-green .stat-number {
            color: #22c55e;
        }

        .stat-purple {
            border-left-color: #8b5cf6;
        }

        .stat-purple .stat-number {
            color: #8b5cf6;
        }

        .stat-orange {
            border-left-color: #f59e0b;
        }

        .stat-orange .stat-number {
            color: #f59e0b;
        }

        .stat-red {
            border-left-color: #ef4444;
        }

        .stat-red .stat-number {
            color: #ef4444;
        }

        .stat-info {
            border-left-color: #06b6d4;
        }

        .stat-info .stat-number {
            color: #06b6d4;
        }

        .stat-warning {
            border-left-color: #f59e0b;
        }

        .stat-warning .stat-number {
            color: #f59e0b;
        }

        /* Portlet Improvements */
        .portlet.light.bordered {
            border-radius: 10px;
            overflow: hidden;
        }

        .portlet-title {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
    </style>

    <!-- Global Premium Notification Modal -->
    <div class="modal fade" id="globalNotificationModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content"
                style="border-radius: 15px; border: none; overflow: hidden; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
                <div class="modal-header" id="notificationHeader"
                    style="background: linear-gradient(135deg, #6e8efb, #a777e3); color: white; border: none; padding: 15px 20px;">
                    <h5 class="modal-title" style="font-weight: 600; letter-spacing: 0.5px; color: white !important;">
                        <i class="fa fa-bell"></i> SİSTEM BİLDİRİMİ
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        style="color: white; opacity: 0.8;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center" style="padding: 30px 20px;">
                    <div id="notificationIconContainer" style="font-size: 50px; margin-bottom: 20px;">
                        <i class="fa fa-info-circle text-primary"></i>
                    </div>
                    <p id="globalNotificationMessage"
                        style="font-size: 16px; color: #444; line-height: 1.6; font-weight: 500; margin-bottom: 0;">
                        ...
                    </p>
                </div>
                <div class="modal-footer" style="border: none; justify-content: center; padding-bottom: 25px;">
                    <button type="button" class="btn btn-primary px-4" data-dismiss="modal"
                        style="border-radius: 12px; font-weight: 600; padding: 10px 30px; box-shadow: 0 4px 15px rgba(110, 142, 251, 0.4); background-color: #3b82f6 !important; border:none;">Anladım</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Global Notification Modal -->

    <!-- Mobile Sidebar Toggle Fix -->
    <script>
        $(document).ready(function () {
            // Mobile Menu Toggle Fix
            $('#mobileDirectSidebarToggle').on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                // Toggle proper Metronic mobile sidebar class
                $('body').toggleClass('page-sidebar-mobile-open');

                // Optional: Close top menu if open
                $('.navbar-collapse').collapse('hide');
            });

            // Close sidebar when clicking overlay
            $(document).on('click', function (e) {
                if ($('body').hasClass('page-sidebar-mobile-open')) {
                    // Check if click is OUTSIDE sidebar and OUTSIDE toggle button
                    if (!$(e.target).closest('.page-sidebar-wrapper').length && !$(e.target).closest('#mobileDirectSidebarToggle').length) {
                        $('body').removeClass('page-sidebar-mobile-open');
                    }
                }
            });
        });
    </script>

    <!-- Mandatory Status Modal -->
    <div class="modal fade" id="mandatoryStatusModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content"
                style="border-radius: 20px; border: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);">
                <div class="modal-header text-center"
                    style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; padding: 25px; border-top-left-radius: 20px; border-top-right-radius: 20px;">
                    <i class="fa fa-lock" style="font-size: 40px; margin-bottom: 10px; opacity: 0.9;"></i>
                    <h4 class="modal-title" style="font-weight: 700; margin: 0; letter-spacing: 0.5px;">SİSTEM KİLİTLİ
                    </h4>
                    <p style="margin: 5px 0 0; opacity: 0.9; font-size: 14px;">Devam etmek için bir durum
                        bildirmelisiniz.</p>
                </div>
                <div class="modal-body p-4" style="background: #f9fafb;">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <button onclick="updateGlobalStatus('ONLINE')" class="btn btn-block"
                                style="background: white; border: 2px solid #2ecc71; color: #2ecc71; padding: 20px; border-radius: 12px; font-weight: 600; font-size: 16px; transition: all 0.2s;">
                                <i class="fa fa-check-circle"
                                    style="font-size: 24px; display: block; margin-bottom: 8px;"></i>
                                Çevrimiçi
                            </button>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button onclick="updateGlobalStatus('BREAK')" class="btn btn-block"
                                style="background: white; border: 2px solid #f59e0b; color: #f59e0b; padding: 20px; border-radius: 12px; font-weight: 600; font-size: 16px; transition: all 0.2s;">
                                <i class="fa fa-coffee"
                                    style="font-size: 24px; display: block; margin-bottom: 8px;"></i>
                                Molada
                            </button>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button onclick="updateGlobalStatus('IN_CALL')" class="btn btn-block"
                                style="background: white; border: 2px solid #3b82f6; color: #3b82f6; padding: 20px; border-radius: 12px; font-weight: 600; font-size: 16px; transition: all 0.2s;">
                                <i class="fa fa-phone" style="font-size: 24px; display: block; margin-bottom: 8px;"></i>
                                Çağrıda
                            </button>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button onclick="updateGlobalStatus('SYSTEM_ERROR')" class="btn btn-block"
                                style="background: white; border: 2px solid #ef4444; color: #ef4444; padding: 20px; border-radius: 12px; font-weight: 600; font-size: 16px; transition: all 0.2s;">
                                <i class="fa fa-exclamation-triangle"
                                    style="font-size: 24px; display: block; margin-bottom: 8px;"></i>
                                Acil Durum
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #fff; text-align: center; display: block; padding: 15px;">
                    <a href="<?php echo e(route('admin.logout')); ?>" class="btn btn-link"
                        style="color: #64748b; font-weight: 600; text-decoration: none;">
                        <i class="fa fa-sign-out"></i> Sistemden Güvenli Çıkış Yap
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global Status Logic
        var globalStatusSeconds = 0;

        <?php if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->role && Auth::guard('admin')->user()->role->role_name != 'SUPER_ADMIN' && !Auth::guard('admin')->user()->is_manager): ?>
            // Init global Status Seconds from backend
            globalStatusSeconds = <?php echo e(\Carbon\Carbon::now()->diffInSeconds(\Carbon\Carbon::parse(Auth::guard('admin')->user()->status_updated_at ?? \Carbon\Carbon::now()))); ?>;

            // Check mandatory status
            var initialStatus = "<?php echo e(Auth::guard('admin')->user()->current_status); ?>";
            var restoreStatus = sessionStorage.getItem('restore_crm_status');
            var restoreTime = sessionStorage.getItem('restore_crm_time');
            var isRestoring = false;
            var navEntry = (performance.getEntriesByType && performance.getEntriesByType('navigation')[0]) || null;
            var isHardReload = navEntry && navEntry.type === 'reload';

            // Sadece gerçek hard-reload durumunda kısa süreli restore yap.
            if (restoreStatus && restoreTime && isHardReload && (Date.now() - parseInt(restoreTime, 10) < 15000)) {
                isRestoring = true;
                initialStatus = restoreStatus;

                $.ajax({
                    url: "<?php echo e(route('admin.crm.setStatus')); ?>",
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: { status: restoreStatus }
                });
            }

            // Stale restore anahtarlarını her açılışta temizle.
            sessionStorage.removeItem('restore_crm_status');
            sessionStorage.removeItem('restore_crm_time');

            if ((initialStatus === 'OFFLINE' || initialStatus === '') && !isRestoring) {
                $('#mandatoryStatusModal').modal('show');
            }

            window.currentActiveStatus = initialStatus;

            // Start global personnel timers
            setInterval(function () {
                // DON'T increment if status is OFFLINE
                if (window.currentActiveStatus === 'OFFLINE' || window.currentActiveStatus === 'Çevrimdışı') return;

                globalStatusSeconds++;
                var date = new Date(0);
                date.setSeconds(globalStatusSeconds);
                $('#global-status-timer-display').text(date.toISOString().substr(11, 8));

                // Real-time Header Stats
                if (window.currentActiveStatus === 'BREAK') {
                    let sec = parseInt($('#header-stats-break').attr('data-seconds')) + 1 || 0;
                    $('#header-stats-break').attr('data-seconds', sec).text(formatTime(sec));

                    let limit = parseInt($('#header-stats-remaining').attr('data-limit')) || 0;
                    let remaining = Math.max(0, limit - sec);
                    $('#header-stats-remaining').attr('data-seconds', remaining).text(formatRemaining(remaining));
                    if (remaining <= 0) $('#header-stats-remaining').css('color', '#ef4444');
                } else if (window.currentActiveStatus === 'IN_CALL') {
                    let sec = parseInt($('#header-stats-incall').attr('data-seconds')) + 1 || 0;
                    $('#header-stats-incall').attr('data-seconds', sec).text(formatTime(sec));
                }
            }, 1000);

            // Auto-Offline Logic
            var isNavigating = false;
            var offlineBeaconSent = false;

            function sendOfflineBeacon(rememberForReload) {
                if (offlineBeaconSent) {
                    return;
                }
                if (window.currentActiveStatus === 'OFFLINE' || window.currentActiveStatus === 'Çevrimdışı') {
                    return;
                }

                if (rememberForReload) {
                    sessionStorage.setItem('restore_crm_status', window.currentActiveStatus);
                    sessionStorage.setItem('restore_crm_time', Date.now().toString());
                }

                var formData = new FormData();
                formData.append('status', 'OFFLINE');
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                offlineBeaconSent = navigator.sendBeacon("<?php echo e(route('admin.crm.setStatus')); ?>", formData);
            }

            // Mark as navigating if clicking a normal link
            $(document).on('click', 'a', function () {
                var href = $(this).attr('href');
                var target = $(this).attr('target');
                if (href && href !== '#' && !href.startsWith('javascript:') && target !== '_blank') {
                    isNavigating = true;
                }
            });

            // Mark as navigating if submitting a form
            $(document).on('submit', 'form', function () {
                isNavigating = true;
            });

            // Mark as navigating on keyboard refresh shortcuts
            $(document).on('keydown', function (e) {
                if (e.key === 'F5' || (e.ctrlKey && (e.key === 'r' || e.key === 'R')) || (e.metaKey && (e.key === 'r' || e.key === 'R'))) {
                    isNavigating = true;
                }
            });

            window.addEventListener('beforeunload', function () {
                if (!isNavigating) {
                    sendOfflineBeacon(true);
                }
            });

            window.addEventListener('pagehide', function (event) {
                if (!event.persisted && !isNavigating) {
                    sendOfflineBeacon(false);
                }
            });

            document.addEventListener('visibilitychange', function () {
                if (document.visibilityState === 'hidden' && !isNavigating) {
                    sendOfflineBeacon(false);
                }
            });

        <?php endif; ?>

            // Helper functions
            function formatTime(seconds) {
                var date = new Date(0);
                date.setSeconds(seconds);
                return date.toISOString().substr(11, 8);
            }

        function formatRemaining(seconds) {
            let m = Math.floor(seconds / 60);
            let s = seconds % 60;
            return m + ":" + (s < 10 ? "0" + s : s);
        }

        // Explicitly attach to window
        window.updateGlobalStatus = function (status) {
            console.log('UpdateGlobalStatus initiated:', status);

            var statusText = {
                'ONLINE': 'Çevrimiçi',
                'BREAK': 'Molada',
                'IN_CALL': 'Çağrıda',
                'SYSTEM_ERROR': 'Sistem Hatası',
                'OFFLINE': 'Çevrimdışı'
            };

            var statusColors = {
                'ONLINE': 'success',
                'BREAK': 'warning',
                'IN_CALL': 'primary',
                'SYSTEM_ERROR': 'danger',
                'OFFLINE': 'default'
            };

            var statusIcons = {
                'ONLINE': 'check-circle',
                'BREAK': 'coffee',
                'IN_CALL': 'phone',
                'SYSTEM_ERROR': 'exclamation-triangle',
                'OFFLINE': 'power-off'
            };

            $.ajax({
                url: "<?php echo e(route('admin.crm.setStatus')); ?>",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    status: status
                },
                success: function (response) {
                    console.log('SetStatus Success:', response);

                    if (response.success) {
                        try {
                            $('#mandatoryStatusModal').modal('hide');
                        } catch (e) {
                            console.error('Modal hide error:', e);
                        }

                        if (typeof toastr !== 'undefined') {
                            toastr.success('Durum güncellendi: ' + statusText[status]);
                        } else {
                            // Fallback if toastr is missing
                            console.log('Durum güncellendi: ' + statusText[status]);
                        }

                        globalStatusSeconds = 0;
                        window.currentActiveStatus = status;

                        // Update Visuals (try-catch to prevent crash if elements missing)
                        try {
                            $('#global-status-badge').attr('class', 'badge badge-' + statusColors[status]);
                            $('#global-status-badge i').attr('class', 'fa fa-' + statusIcons[status]);
                            $('#global-status-text').text(statusText[status]);
                        } catch (e) { console.error('Visual update error:', e); }

                        // Update Header Stats from response
                        if (response.today_in_call_seconds !== undefined) {
                            try {
                                $('#header-stats-incall').attr('data-seconds', response.today_in_call_seconds).text(formatTime(response.today_in_call_seconds));
                                $('#header-stats-break').attr('data-seconds', response.today_break_seconds).text(formatTime(response.today_break_seconds));

                                let limit = parseInt(response.daily_break_limit || 60) * 60;
                                let remaining = Math.max(0, limit - response.today_break_seconds);
                                $('#header-stats-remaining').attr('data-seconds', remaining).text(formatRemaining(remaining));

                                if (remaining <= 0) $('#header-stats-remaining').css('color', '#ef4444');
                                else $('#header-stats-remaining').css('color', '#10b981');
                            } catch (e) { console.error('Stats update error:', e); }
                        }

                        // Trigger sync if on CRM dashboard
                        if (typeof fetchActivities === 'function') {
                            fetchActivities();
                        }
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error('İşlem başarısız oldu.');
                        } else {
                            alert('İşlem başarısız oldu.');
                        }
                    }
                },
                error: function (xhr, status, error) {
                    console.error('SetStatus Error:', xhr.responseText);
                    let msg = 'Hata: ' + xhr.status + ' ' + error;
                    if (xhr.status == 419) msg = 'Oturum süresi doldu (419). Lütfen sayfayı yenileyin.';
                    if (xhr.status == 500) msg = 'Sunucu hatası (500). Lütfen yöneticiye bildirin.';

                    if (typeof toastr !== 'undefined') {
                        toastr.error(msg);
                    } else {
                        alert(msg);
                    }
                }
            });
        }
    </script>
</body>

</html><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/layouts/admin_layout.blade.php ENDPATH**/ ?>