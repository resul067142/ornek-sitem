<!DOCTYPE html>
<html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
   		cluster: '{{ config('broadcasting.connections.pusher.cluster') }}'
    });

    var channel = pusher.subscribe('kripto');

    channel.bind('BTCTRY', function(data) {
      let value = $('.price .value');
      
      if (data.data.value > value.text())
        value.css('background-color', 'green')
      else if (data.data.value < value.text())
        value.css('background-color', 'red')
      else
        value.css('background-color', 'black')

      value.text(data.data.value)
    })
  </script>
  <style>
    .price {
      width: 100%;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }
    .price .value {
      width: 200px;
      line-height: 60px;
      font-size: 24px;
      text-align: center;
      color: #fff;
    }
  </style>
</head>
<body>

<div class="price">
  <div class="symbol"><h1>BTCTRY</h1></div>
  <div class="value">0</div>
</div>

</body>
</html>
