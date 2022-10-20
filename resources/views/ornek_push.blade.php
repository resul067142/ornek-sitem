<!DOCTYPE html>
<html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
   		cluster: '{{ config('broadcasting.connections.pusher.cluster') }}'
    });

    var channel = pusher.subscribe('mesaj-yayini');

    channel.bind('etkinlik', function(data) {
    	document.querySelector('body').innerHTML = data.mesaj;
    })
  </script>
</head>
<body>

</body>
</html>
