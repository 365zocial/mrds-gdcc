<!DOCTYPE html>
<html>
<head>
  <title>.: Submit Request :.</title>
</head>
<body>
  <p><b>Dear</b> {{ $user_name }}</p>

  <p>{{ $comment }}</p>

  <p>
  	Specimen invoice No. : {{ $record_loan_id }} <br>
  	Specimen invoice Status. : {{ $loan_status }}
  </p>

  <p>===================================</p>

  <p>
    คุณสามารถดูทุกการทำงานได้ตลอดเวลาตาม link ต่อไปนี้<br>
  	<a href="{{ $url }}">{{ $url }}</a>
  </p>

</body>
</html>
