@extends('user.layouts.app')

@section('content')
<div class="pro-dashboard-head">
    <div class="container">
        <a href="#" class="pro-head-link active">Chat Now</a>
    </div>
</div>
<div class="pro-dashboard-content">
    <div class="container">
        <div class="dash-content" id="trip-container">
            <div class="row no-margin" >

            </div>
        </div>
    </div>
</div>
<div class="panel panel-default" id="chat-place">
    <div class="panel-body">
        <h2 class="text-center">Chat with 
        
            Dispute Manager
            <?php

                $k = array_rand($dispute_manager);
                $user_id = $dispute_manager[$k];
             //$user_id = $Order->user->id;
                 ?>
        

        </h2>
        <div class="row">
            <div class="panel-chat well m-n chatwindowscroll" id="chat-box">
                
            </div>
        </div>
        <div class="p-md panel-footer">
            <div class="input-group">
                <input type="text" placeholder="Enter your message here" class="form-control" id="chat-input">
                <span class="input-group-btn">
                    <button type="button" id="chat-send" class="btn btn-default">
                    <i class="icon-arrow-right"></i></button>
                </span>
            </div>
        </div>
    </div>
</div>
<audio id="beep-one" controls preload="auto" style="display:none">
  <source src="{{asset('assets/audio/beep.mp3')}}" controls></source>
    <source src="{{asset('assets/audio/beep.ogg')}}" controls></source>
    Your browser isn't invited for super fun audio time.
</audio>
@endsection
@section('styles')
<style type="text/css">
    .chatwindowscroll{
    overflow-y:scroll;
    height:400px;
    }

    .chat-box {
        padding: 15px; 
        background-color: #fff;
    }

    .chat-box p {
        margin-bottom: 0;
    }

    .chat-left {
        max-width: 500px;
        margin-bottom: 10px;
    }

    .chat-left p {
        color: #fff;
        background: #37b38b;
        padding: 10px;
        font-size: 12px;
        border-radius: 0px 20px 20px 20px;
        display: inline-block;
    }

    .chat-right p {
        background: #ccc;
        padding: 10px;
        font-size: 12px;
        border-radius: 20px 0px 20px 20px;
        display: inline-block;
    }

    .chat-right {
        max-width: 500px;       
        float: right;
        margin-bottom: 10px;
    }

    .m-0 {
        margin: 0;
    }
</style>
@endsection

@section('scripts')
<script src=https://cdn.pubnub.com/sdk/javascript/pubnub.4.0.11.min.js></script>
<script type="text/javascript">
    var beepOne = $("#beep-one")[0];
    var total_chat = 0;
    var defaultImage = "{{ asset('user_default.png') }}";
    var chatBox, chatInput, chatSend;
    var chatRequestId = 0;
    var chatUserId = 0;
    var chatload = 0;
    var initialized = false;
    var socketClient;
    initChat();
    updateChatParam({{$Order->id}}, {{$user_id}});

    function updateChatParam(pmrequestid, pmuserid) {
        console.log('Chat Params', pmrequestid, pmuserid);
        chatRequestId = pmrequestid;
        chatUserId = pmuserid;

        if(initialized == false) {
            socketClient.channel = pmrequestid;
            socketClient.initialize();
            socketClient.channel = pmrequestid;
            socketClient.pubnub.subscribe({channels:[socketClient.channel]});
            initialized = true;            
        }

        
    }

    var messageTemplate = function(data) { 
        var message = document.createElement('div');
        var messageContact = document.createElement('div');
        var messageText = document.createElement('p');

        //messageText.className = "chat-text";
        messageText.innerHTML = data.message;

        if(data.type == 'user') {
            message.className = "row m-0";
            messageContact.className = "chat-right";
            messageContact.appendChild(messageText);
            message.appendChild(messageContact);
            //messageContact.innerHTML = '<img src="' + socketClient.user_picture + '">';
        } else {
            message.className = "chat-left";
            message.appendChild(messageText);
            //messageContact.innerHTML = '<img src="' + socketClient.provider_picture + '">';
        }

        return message;
    }
    
    function initChat(){

        chatBox = document.getElementById('chat-box');
        chatInput = document.getElementById('chat-input');
        chatSend = document.getElementById('chat-send');

        chatSockets = function () {
            
        }

        chatSockets.prototype.initialize = function() {
            
            
            this.pubnub = new PubNub({ 
                publishKey : '{{ Setting::get('PUBNUB_PUB_KEY') }}',
                subscribeKey : '{{ Setting::get('PUBNUB_SUB_KEY') }}'
            });

            console.log('Connect Channel', this.channel);

            this.pubnub.addListener({
                message: function(data) {  beepOne.play();
                    console.log("New Message :: "+JSON.stringify(data));
                    if(data.message){
                        total_chat++;
                        console.log(total_chat);
                        chatBox.appendChild(messageTemplate(data.message));
                        $(chatBox).animate({
                            scrollTop: chatBox.scrollHeight,
                        }, 500);
                    }
                }
            });

            this.pubnub.history(
                { 
                    channel: this.channel
                },
                function(status, response) {
                    console.log('Pubnub History', response);
                    $(response.messages).each(function(index, message) {
                        
                        chatBox.appendChild(messageTemplate(message.entry));
                    })

                    $(chatBox).animate({
                            scrollTop: chatBox.scrollHeight,
                    }, 500);
                }
            );


          
        }

        chatSockets.prototype.sendMessage = function(data) {
            console.log('SendMessage'+data);

            data = {};
            data.type = 'user';
            data.message = text;
            data.user_id = chatUserId;
            data.request_id = chatRequestId;
            data.provider_id = "{{ $user_id }}";

            // this.socket.emit('send message', data);

            this.pubnub.publish({
                channel : this.channel,
                message : data
            });
        }

        socketClient = new chatSockets();

        chatInput.enable = function() {
            // console.log('Chat Input Enable');
            this.disabled = false;
        };

        chatInput.clear = function() {
            // console.log('Chat Input Cleared');
            this.value = "";
        };

        chatInput.disable = function() {
            // console.log('Chat Input Disable');
            this.disabled = true;
        };

        chatInput.addEventListener("keyup", function (e) {
            if (e.which == 13) {
                sendMessage(chatInput);
                return false;
            }
        });

        chatSend.addEventListener('click', function() {
            sendMessage(chatInput);
        });

        function sendMessage(input) {
            text = input.value.trim();
            if(text != '') {

                message = {};
                message.type = 'pu';
                message.message = text;

                socketClient.sendMessage(text);
                // chatBox.appendChild(messageTemplate(message));
                // $(chatBox).animate({
                //     scrollTop: chatBox.scrollHeight,
                // }, 500);
                chatInput.clear();
            }
        }
        
        chatInput.enable();
    }
</script>
@endsection