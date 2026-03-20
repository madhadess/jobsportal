@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Başvurular Raporu - {{ date('d.m.Y H:i') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 11px; color: #333; }
        .header { background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%); color: #fff; padding: 20px; margin-bottom: 20px; }
        .header h1 { font-size: 24px; margin-bottom: 5px; }
        .header p { font-size: 12px; opacity: 0.8; }
        .content { padding: 0 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #dc2626; color: #fff; padding: 10px 8px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { padding: 8px; border-bottom: 1px solid #eee; font-size: 10px; }
        tr:nth-child(even) { background: #f8f9fa; }
        .status-pending { color: #f59e0b; font-weight: bold; }
        .status-shortlisted { color: #8b5cf6; font-weight: bold; }
        .status-rejected { color: #ef4444; font-weight: bold; }
        .status-hired { color: #22c55e; font-weight: bold; }
        .footer { margin-top: 30px; padding: 15px 20px; background: #f8f9fa; text-align: center; font-size: 10px; color: #666; }
        .print-btn { position: fixed; top: 10px; right: 10px; background: #dc2626; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 14px; }
        .print-btn:hover { background: #b91c1c; }
        @media print { .print-btn { display: none; } }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">🖨️ Yazdır</button>
    
    <div class="header">
        <h1>Başvurular Raporu</h1>
        <p>Oluşturulma Tarihi: {{ date('d.m.Y H:i') }} | Toplam Kayıt: {{ count($applications) }}</p>
    </div>

    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Aday Adı</th>
                    <th>E-posta</th>
                    <th>İlan Başlığı</th>
                    <th>Şirket</th>
                    <th>Durum</th>
                    <th>Başvuru Tarihi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $app)
                <tr>
                    <td>{{ $app->id }}</td>
                    <td>{{ $app->user->name ?? '-' }}</td>
                    <td>{{ $app->user->email ?? '-' }}</td>
                    <td>{{ Str::limit($app->job->title ?? '-', 30) }}</td>
                    <td>{{ Str::limit($app->job->company->name ?? '-', 20) }}</td>
                    <td class="status-{{ $app->status }}">
                        @switch($app->status)
                            @case('pending') Beklemede @break
                            @case('shortlisted') Ön Eleme @break
                            @case('rejected') Reddedildi @break
                            @case('hired') İşe Alındı @break
                            @default {{ $app->status }}
                        @endswitch
                    </td>
                    <td>{{ $app->created_at->format('d.m.Y H:i') }}</td>
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
