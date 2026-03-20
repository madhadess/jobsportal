@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>İş İlanları Raporu - {{ date('d.m.Y H:i') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }

        .header {
            background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);
            color: #fff;
            padding: 20px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 12px;
            opacity: 0.8;
        }

        .stats {
            display: flex;
            margin-bottom: 20px;
            padding: 0 20px;
        }

        .stat-box {
            flex: 1;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-right: 10px;
            text-align: center;
        }

        .stat-box:last-child {
            margin-right: 0;
        }

        .stat-box .number {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
        }

        .stat-box .label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
        }

        .content {
            padding: 0 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #2563eb;
            color: #fff;
            padding: 10px 8px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #eee;
            font-size: 10px;
        }

        tr:nth-child(even) {
            background: #f8f9fa;
        }

        .status-active {
            color: #22c55e;
            font-weight: bold;
        }

        .status-inactive {
            color: #ef4444;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            padding: 15px 20px;
            background: #f8f9fa;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .print-btn {
            position: fixed;
            top: 10px;
            right: 10px;
            background: #2563eb;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .print-btn:hover {
            background: #1d4ed8;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>
</head>

<body>
    <button class="print-btn" onclick="window.print()">🖨️ Yazdır</button>

    <div class="header">
        <h1>İş İlanları Raporu</h1>
        <p>Oluşturulma Tarihi: {{ date('d.m.Y H:i') }} | Toplam Kayıt: {{ count($jobs) }}</p>
    </div>

    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>İlan Başlığı</th>
                    <th>Şirket</th>
                    <th>Şehir</th>
                    <th>İş Alanı</th>
                    <th>İş Türü</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $job)
                    <tr>
                        <td>{{ $job->id }}</td>
                        <td>{{ Str::limit($job->title, 35) }}</td>
                        <td>{{ Str::limit($job->company->name ?? '-', 20) }}</td>
                        <td>{{ $job->city->city ?? '-' }}</td>
                        <td>{{ Str::limit($job->functionalArea->functional_area ?? '-', 20) }}</td>
                        <td>{{ $job->jobType->job_type ?? '-' }}</td>
                        <td class="{{ $job->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $job->is_active ? 'Aktif' : 'Pasif' }}
                        </td>
                        <td>{{ $job->created_at->format('d.m.Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Bu rapor otomatik olarak oluşturulmuştur. | {{ config('app.name') }} Admin Panel</p>
    </div>
</body>

</html>