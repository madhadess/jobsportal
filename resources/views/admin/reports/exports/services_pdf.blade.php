@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Hizmetler Raporu - {{ date('d.m.Y H:i') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 11px; color: #333; }
        .header { background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: #fff; padding: 20px; margin-bottom: 20px; }
        .header h1 { font-size: 24px; margin-bottom: 5px; }
        .header p { font-size: 12px; opacity: 0.8; }
        .content { padding: 0 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #059669; color: #fff; padding: 10px 8px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { padding: 8px; border-bottom: 1px solid #eee; font-size: 10px; }
        tr:nth-child(even) { background: #f8f9fa; }
        .status-active { color: #22c55e; font-weight: bold; }
        .status-inactive { color: #ef4444; font-weight: bold; }
        .footer { margin-top: 30px; padding: 15px 20px; background: #f8f9fa; text-align: center; font-size: 10px; color: #666; }
        .print-btn { position: fixed; top: 10px; right: 10px; background: #059669; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-size: 14px; }
        .print-btn:hover { background: #047857; }
        @media print { .print-btn { display: none; } }
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">🖨️ Yazdır</button>
    
    <div class="header">
        <h1>Hizmetler Raporu</h1>
        <p>Oluşturulma Tarihi: {{ date('d.m.Y H:i') }} | Toplam Kayıt: {{ count($services) }}</p>
    </div>

    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Hizmet Adı</th>
                    <th>Kategori</th>
                    <th>Fiyat</th>
                    <th>Süre</th>
                    <th>Talep</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                <tr>
                    <td>{{ $service->id }}</td>
                    <td>{{ Str::limit($service->service_name, 30) }}</td>
                    <td>{{ $service->category->category_name ?? '-' }}</td>
                    <td>{{ $service->getFormattedPrice() }}</td>
                    <td>{{ $service->getFormattedDuration() }}</td>
                    <td>{{ $service->requests_count ?? 0 }}</td>
                    <td class="{{ $service->is_active ? 'status-active' : 'status-inactive' }}">
                        {{ $service->is_active ? 'Aktif' : 'Pasif' }}
                    </td>
                    <td>{{ $service->created_at->format('d.m.Y') }}</td>
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
