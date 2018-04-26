<!DOCTYPE html>$mrct
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        สวัสดี {{ $user }}<br>
        <br>
        ขอบคุณสำหรับการติดต่อกับทาง MBDS ทางเราได้บันทึกรายละเอียดการติดต่อไว้เรียบร้อยแล้ว<br>
        และคุณจะได้รับแจ้งเมื่อเราได้ดำเนินการตามที่คุณร้องขอทาง Email<br>
        <br>
        การสอบถามของคุณคือ : {{ $contact }}<br>
        เรื่อง: {{ $topic }}<br>
        <br>
        ================================<br>
        <p>{{ $message_email }}</p>
    </body>
</html>
