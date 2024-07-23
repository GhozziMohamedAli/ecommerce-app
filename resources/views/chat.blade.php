<!-- resources/views/chat.blade.php -->

@extends('layouts.app',['subpage' => true,'activePage' => "home"])

@section('content')
    
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-6 m-auto">
                <div class="card">
                    <h5 class="card-header">Chat</h5> 
                    <div id="chat-container" class="card-body " style="height: 80vh;overflow-y: scroll" >
                        <div id="messages">
                        @foreach ($message as $item)
                        
                        
                            <h5 class="card-title bg-success">{{$item->user->name}}</h5>
                            <p class="card-text">
                                {{$item->message}}
                            </p> 
                       
                       
                     @endforeach
                    </div>
                     <form id="form" action="">
                        <div class="input-group mt-2">
                            <input id="btn-input" type="text" name="message" class="form-control input-sm" placeholder="Type your message here..." >
                    
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary btn-sm" id="btn-chat" >
                                    Send
                                </button>
                            </span>
                        </div>
                    </form>
                    </div>
                  </div>
           
                
                
                
        </div>
    </div>
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
      const chatContainer = document.getElementById('chat-container');

      // Scroll to bottom on page load
      chatContainer.scrollTop = chatContainer.scrollHeight;
      });
      $(document).ready(function() {
        Echo.private('chat')
        .listen('MessageSent', (e) => {
            let messages = document.getElementById('messages');
            let messageText = document.createElement('p');
            let messageUser = document.createElement('H5');
            messageUser.classList.add("card-title", "bg-success");
            messageText.classList.add("card-text");
            messageUser.innerText = e.user.name;
            messageText.innerText = e.message.message;
            messages.appendChild(messageUser);
            messages.appendChild(messageText);
        });

      
        $("#form").submit(function(event){
            event.preventDefault();
            
            $.ajax({
                headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url:"/chat/send",
                type:"post",
                data:{"message":document.getElementById("btn-input").value}
            });
        })
    });
    </script>
@endsection
