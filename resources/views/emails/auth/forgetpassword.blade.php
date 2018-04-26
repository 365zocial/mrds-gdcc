<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        สวัสดี {{ $firstname }} {{ $lastname }}<br><br>
        หากคุณต้องการตั้งรหัสผ่านใหม่ สำหรับ Marine Resources Database System กรุณากดที่ลิงค์ด้านล่างเพื่อทำการยืนยัน และตั้งค่ารหัสผ่านใหม่<br>
        <br>
        {{ $url }}<br>
        <br>
        หากคุณมิได้เป็นผู้ทำการร้องขอการตั้งรหัสผ่านใหม่ กรุณาเพิกเฉยอีเมล์ฉบับนี้ (อาจเกิดขึ้นจากบุคคลอื่นพิมพ์ชื่อผุ้ใช้งานที่เป็นอีเมล์หรือเบอร์มือถือหรือเบอร์ทรูการ์ดไม่ถูกต้องโดยมิได้ตั้งใจ)<br><br>
        ขอแสดงความนับถือ<br>
        <br>
        --------------------------------------------------------------------------------------------------------------<br>
        <br>
        Dear {{ $firstname }} {{ $lastname }}<br><br>
        If you’d like to reset your password of MBDS’s account, Please click on the following link to reset you password :<br>
        <br>
        {{ $url }}<br>
        <br>
        If you didn't request a password reset, you can ignore this message – someone probably typed in your Username or E-Mail Address by accident.<br><br>
        Many Thanks,<br>
    </body>
</html>
