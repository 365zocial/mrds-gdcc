<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        Dear {{ $user }}<br>
        <br>
        Thank you for contact with MBDS, we open you ticket already and you will get notification via Email.<br>
        <br>
        Your ticket is : {{ $contact }}<br>
        Subject: {{ $topic }}<br>
        <br>
        ================================<br>
        <p>{{ $message_email }}</p>
    </body>
</html>
