<!DOCTYPE html>
<html>
<head>
  <title>.: Reclaim Specimen :.</title>
</head>
<body>

  <center><img src=""></center>

  <p><b>Dear</b> {{ $user_name }} ({{ $request_id }})</p>

  <p>We would like to inform you that the loaning period of “{{ $request_id }}” during {{ $start_date }} – {{ $end_date }} from the collection {{ $reclaim_name }}. Please kindly return the specimen(s) by registration postal to the Reference Collection and fax the registered document copy to me
via 66-76-391127 (attn: Reference Collection) or inform me via this email address. </p>

  <p>Moreover, if you have published any results with regarding the specimen(s), please kindly send a file of your article in PDF format. Thank you for your courtesy.</p>

  <p>Thank you very much in advance for your reply.</p>

  <p>Sincerely yours, <br> {{ $marinecenter }}</p>

  <div width="30%">
    {{ $marinecenter_address }}
  </div>

</body>
</html>
