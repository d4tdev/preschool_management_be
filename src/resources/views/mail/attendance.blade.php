<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo điểm danh</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 1px solid #dddddd;
        }
        .header h1 {
            color: #333333;
            font-size: 24px;
            margin: 0;
        }
        .content {
            padding: 20px 0;
        }
        .content p {
            color: #555555;
            font-size: 16px;
            line-height: 1.5;
        }
        .contact-info {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 4px;
        }
        .contact-info p {
            margin: 5px 0;
        }
        .footer {
            text-align: center;
            padding: 10px 0;
            border-top: 1px solid #dddddd;
            margin-top: 20px;
        }
        .footer p {
            color: #777777;
            font-size: 14px;
        }
    </style>
</head>
<body>
@php
    $studentName = $student['first_name'] . ' ' . $student['last_name'];
    $parentName = $student['parent']['first_name'] . ' ' . $student['parent']['last_name'];
    $teacherName = $student['class']['teacher']['first_name'] . ' ' . $student['class']['teacher']['last_name'];
    $teacherEmail = $student['class']['teacher']['email'];
    $teacherPhone = $student['class']['teacher']['phone'];
    $arrivalTime = \Carbon\Carbon::parse($data['arrived_at'])->format('H:i:s d/m/Y');
    $status = $data['status'] === 'arrived' ? 'đã đến' : 'chưa đến';
@endphp

<div class="container">
    <div class="header">
        <h1>Thông báo điểm danh</h1>
    </div>
    <div class="content">
        <p>Kính gửi phụ huynh {{ $parentName }},</p>
        <p>Chúng tôi xin thông báo rằng con của quý vị, {{ $studentName }}, đã {{ $status }} trường vào lúc {{ $arrivalTime }}.</p>
        <div class="contact-info">
            <p>Nếu quý vị có bất kỳ câu hỏi hoặc thắc mắc nào, vui lòng liên hệ với thầy/cô {{ $teacherName }} qua:</p>
            <p>Email: {{ $teacherEmail }}</p>
            <p>Số điện thoại: {{ $teacherPhone }}</p>
        </div>
    </div>
    <div class="footer">
        <p>Trân trọng,</p>
        <p>Trường Mầm Non Sơn Cẩm 1 - Thái Nguyên</p>
    </div>
</div>
</body>
</html>
