@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Hizmet Talepleri Raporu - {{ date('d.m.Y H:i') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 11px; color: #333; }
        .header { background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%); color: #fff; padding: 20px; margin-bottom: 20px; }
        .header h1 { font-size: 24px; margin-bottom: 5px; }
        .header p { font-size: 12px; opacity: 0.8; }
        .content { padding: 0 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #7c3aed; color: #fff; padding: 10px 8px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { padding: 8px; border-bottom: 1px solid #eee; font-size: 10px; }
        tr:nth-child(even) { background: #f8f9fa; }
        .status-pending { color: #f59e0b; font-weight: bold; }
        .status-approved { color: #06b6d4; font-weight: bold; }
        .status-in_progress { color: #8b5cf6; font-weight: bold; }
        .status-completed { color: #22c55e; font-weight: bold; }
        .status-cancelled { color: #ef4444; font-weight: bold; }
        .footer { margin-top: 30px; padding: 15px 20px; background: #f8f9fa; text-align: center; font-size: 10px; color: #666; }
        .print-btn { position: fixed; top: 10px; right: 10px; background: #7c3aed; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 14px; }
        .print-btn:hover { background: #6d28d9; }
        @media print { .print-btn { display: none; } }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">🖨️ Yazdır</button>
    
    <div class="header">
        <h1>Hizmet Talepleri Raporu</h1>
        <p>Oluşturulma Tarihi: {{ date('d.m.Y H:i') }} | Toplam Kayıt: {{ count($requests) }}</p>
    </div>

    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>Talep No</th>
                    <th>Müşteri</th>
                    <th>Telefon</th>
                    <th>Hizmet</th>
                    <th>Tercih Tarihi</th>
                    <th>Durum</th>
                    <th>Fiyat</th>
                    <th>Talep Tarihi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $req)
                <tr>
                    <td><strong>{{ $req->request_number }}</strong></td>
                    <td>{{ $req->user->name ?? '-' }}</td>
                    <td>{{ $req->customer_phone ?? '-' }}</td>
                    <td>{{ Str::limit($req->service->service_name ?? '-', 25) }}</td>
                    <td>{{ $req->getFormattedDate() }}</td>
                    <td class="status-{{ $req->status }}">{{ $req->getStatusLabel() }}</td>
                    <td>{{ $req->final_price ? number_format($req->final_price, 2, ',', '.') . ' TL' : '-' }}</td>
                    <td>{{ $req->created_at->format('d.m.Y H:i') }}</td>
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
