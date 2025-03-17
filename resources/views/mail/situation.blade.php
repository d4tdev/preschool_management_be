<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo thông tin trẻ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        h2 {
            color: #2c3e50;
            text-align: center;
        }
        .section {
            margin-bottom: 20px;
        }
        .flex {
            display: flex;
        }
        .jcc {
            justify-content: center;
        }
        .section-title {
            font-weight: bold;
            color: #2980b9;
        }
        a {
            color: #3498db;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Báo cáo thông tin trẻ</h2>
    <p class="">Buổi {{$day == 'morning' ? 'sáng' : 'chiều'}} ngày {{\Carbon\Carbon::now()->format('d/m/Y')}}</p>

    <div class="section flex">
        <p class="section-title">Thông báo tình của bé: </p><p>{{ $student['first_name'] }} {{ $student['last_name'] }}</p>
    </div>

    <div class="section">
        <p class="section-title">Tình trạng ăn uống:</p>
        <ul>
            <li>Trạng thái: {{ $eat_status == 'full' ? 'Đầy đủ' : ($eat_status == 'half-full' ? 'Ăn không hết' : 'Lười ăn') }}</li>
            <li>Thực đơn: {{ $recipe }}</li>
        </ul>
    </div>

    <div class="section flex">
        <p class="section-title">Hoạt động trong buổi:</p>
        <p>{{ $subject['name'] }}</p>
    </div>

    <div class="section">
        <p class="section-title">Nhận xét:</p>
        <p>{{ $note }}</p>
    </div>

    <div class="section flex">
        <p class="section-title">Đánh giá cuối buổi:</p>
        <p>{{ $review == 'good' ? 'Ngoan' : 'Chưa ngoan' }}</p>
    </div>

    <div class="section">
        <p>Xem chi tiết tại: <a href="http://localhost:3000/home/list-situations/update/{{ $situation['id'] }}">Đây</a></p>
    </div>
</div>
</body>
</html>
