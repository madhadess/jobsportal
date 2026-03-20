@php use Illuminate\Support\Str; @endphp
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Şirketler Raporu - {{ date('d.m.Y H:i') }}</title>
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
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
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

        .content {
            padding: 0 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background: #7c3aed;
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
            background: #7c3aed;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .print-btn:hover {
            background: #6d28d9;
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
        <h1>Şirketler Raporu</h1>
        <p>Oluşturulma Tarihi: {{ date('d.m.Y H:i') }} | Toplam Kayıt: {{ count($companies) }}</p>
    </div>

    <div class="content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Şirket Adı</th>
                    <th>E-posta</th>
                    <th>Telefon</th>
                    <th>Şehir</th>
                    <th>İlan Sayısı</th>
                    <th>Durum</th>
                    <th>Doğrulanmış</th>
                    <th>Kayıt Tarihi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $company)
                    <tr>
                        <td>{{ $company->id }}</td>
                        <td>{{ Str::limit($company->name, 25) }}</td>
                        <td>{{ Str::limit($company->email, 25) }}</td>
                        <td>{{ $company->phone ?? '-' }}</td>
                        <td>{{ $company->city->city ?? '-' }}</td>
                        <td>{{ $company->jobs_count ?? 0 }}</td>
                        <td class="{{ $company->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $company->is_active ? 'Aktif' : 'Pasif' }}
                        </td>
                        <td>{{ $company->verified ? 'Evet' : 'Hayır' }}</td>
                        <td>{{ $company->created_at->format('d.m.Y') }}</td>
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