@extends('layouts.main')
@section('content')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>

  // Enable pusher logging - don't include this in production
 // Pusher.logToConsole = true;

  var pusher = new Pusher('da79d4acdac149c793f5', {
    cluster: 'ap2'
  });
//   var presenceChannel = pusher.subscribe('presence-my-channel');

  var channel = pusher.subscribe('my-channel');
channel.bind('sendMessage', function(data) {
   // alert(JSON.stringify(data));
      var tag = document.createElement("p");
      var obj = JSON.parse(JSON.stringify(data))
     // console.log(obj);
      // var text = document.createTextNode(obj.text);
      if(obj.user ==  {!! json_encode(Auth::user()->name) !!} ){
        tag.innerHTML = '<li class="chat-right">'+
                                        '<div class="chat-avatar">'+
                                            '<img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">'+
                                            '<div class="chat-name">'+obj.user+'</div>'+
                                        '</div>'+
                                        '<div class="chat-text">'+obj.text+
                                           '</div>'+
                                        '<div class="chat-hour">08:55 <span class="fa fa-check-circle"></span></div>'+
                                    '</li>';

      }else{
        tag.innerHTML = '<li class="chat-left">'+
                                        '<div class="chat-avatar">'+
                                            '<img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">'+
                                            '<div class="chat-name">'+obj.user+'</div>'+
                                        '</div>'+
                                        '<div class="chat-text">'+obj.text+
                                           '</div>'+
                                        '<div class="chat-hour">08:55 <span class="fa fa-check-circle"></span></div>'+
                                    '</li>';

      }

      var element = document.getElementById("new");
      element.appendChild(tag);
  });
  channel.bind('useractive',function(data){
      var tag = document.createElement("div");
      var obj = JSON.parse(JSON.stringify(data))
      var user = {!! json_encode($user)  !!}
      for
    //  console.log(user);
      tag.innerHTML =       '<li class="person" data-chat="person1">'+
                                        '<div class="user">'+
                                            '<img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">'+
                                            '<span class="status online"></span>'+
                                        '</div>'+
                                        '<p class="name-time">'+
                                            '<span id="user" class="name">'+'Demo User'+'</span>'+
                                        '</p>'+
                                    '</li>'
      var element = document.getElementById("activeUser");
      element.appendChild(tag);

  });

</script>

<div  class="container">

    <!-- Page header start -->

    <!-- Page header end -->

    <!-- Content wrapper start -->
    <div class="content-wrapper">

        <!-- Row start -->
        <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="card m-0">

                    <!-- Row start -->
                    <div class="row no-gutters">
                        <div  id="app" class="col-xl-4 col-lg-4 col-md-4 col-sm-3 col-3">
                            <div class="users-container">

                                <ul id="activeUser" class="users">
                                    <li class="person" data-chat="person1">
                                        <p class="name-time">
                                            <span class="name">Active User</span>
                                        </p>
                                        <hr>
                                    </li>
                                    @foreach ($user as $item)
                                    @if ($item->status == "Online")
                                        <li class="person" data-chat="{{ $item->id }}">
                                            <div class="user">
                                                <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
                                                <span class="status online"></span>
                                            </div>
                                            <p class="name-time">
                                                <span id="user" class="name">{{ $item->name }}</span>
                                            </p>
                                        </li>


                                    @endif

                                    @endforeach


                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-9 col-9">

                            <div class="form-group mt-3 mb-0">
                                <div class="row">
                                    <div class="col-10">
                                        <textarea id="message" class="form-control" rows="3" name="msg" placeholder="Type your message here..."></textarea>
                                    </div>
                                    <div class="col-2">
                                        <button id="mybutton"class="btn btn-primary" type="submit" onclick="sendmessage()">Send</button>
                                    </div>
                                </div>

                            </div>
                            <div class="chat-container">
                                <ul id="new" class="chat-box chatContainerScroll">
                                    {{-- <li class="chat-left">
                                        <div class="chat-avatar">
                                            <img src="https://www.bootdey.com/img/Content/avatar/avatar3.png" alt="Retail Admin">
                                            <div class="chat-name">Russell</div>
                                        </div>
                                        <div class="chat-text">Hello, I'm Russell.
                                            <br>How can I help you today?</div>
                                        <div class="chat-hour">08:55 <span class="fa fa-check-circle"></span></div>
                                    </li> --}}
                                </ul>

                            </div>
                        </div>
                    </div>
                    <!-- Row end -->
                </div>

            </div>

        </div>
        <!-- Row end -->

    </div>
    <!-- Content wrapper end -->

</div>
<script>
    var input = document.getElementById("message");
    console.log(input.value);
        input.addEventListener("keyup", function(event) {

                if (event.keyCode === 13) {
                    if(input.value !=='\n'){
                        event.preventDefault();
                        document.getElementById("mybutton").click();
                    }else{
                        alert("blank message");
                        document.getElementById("message").value = '';
                    }

                }


});

           function sendmessage(){
            if(input.value == ''){
                    alert("blank message");
                    document.getElementById("message").value = '';
            }else{


                $.ajax({
                            headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    type: 'POST',
                    url: '/home',
                    data: {
                      'text':document.getElementById("message").value,
                      'user': {!! json_encode(Auth::user()->name) !!},
                    },
                    success: function () {
                       console.log("succeed");
                       document.getElementById("message").value = '';
                    },
                    error: function (data, textStatus, errorThrown) {
                        console.log("Error:".errorThrown);
                        console.log(data);


                    },
                })
            }
                          }
</script>
@endsection
