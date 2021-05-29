<!DOCTYPE html>
<html>


<head>
  <title>Pusher Test</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
   // Pusher.logToConsole = true;

    var pusher = new Pusher('da79d4acdac149c793f5', {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('sendMessage', function(data) {
     // alert(JSON.stringify(data));
        var tag = document.createElement("p");
        var obj = JSON.parse(JSON.stringify(data))
        console.log(obj);
        // var text = document.createTextNode(obj.text);
         tag.innerHTML = obj.text;
        var element = document.getElementById("new");
        element.appendChild(tag);
    });
  </script>
</head>
<body>
  <h1>Pusher Test</h1>
    <div id="new">

    </div>
</body>

</html>
