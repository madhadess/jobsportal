<!DOCTYPE html>
<html>

<head>
    <title>Erişim Engellendi</title>
    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #e74c3c;
            display: table;
            font-weight: 300;
            font-family: 'Lato', sans-serif;
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .message {
            font-size: 24px;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="title">Erişim Kısıtlaması</div>
            <div class="message">{{ $message ?? 'Bu sayfaya erişim yetkiniz bulunmamaktadır.' }}</div>
            <div style="margin-top: 20px;">
                <a href="{{ url('/admin/home') }}" style="color: #3498db; text-decoration: none;">Anasayfaya Dön</a>
            </div>
        </div>
    </div>
</body>

</html>