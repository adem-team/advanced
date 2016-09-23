$( document ).ready(function() {

    var socket = io.connect('http://lukisongroup.com:8890');

    var content = $( "#message-container" );

   
  function scrollToBottom (mess) {
    if (mess.length) {
        content.scrollTop(content.prop("scrollHeight"));
        }
  }

  $('#chat-tab').click(function(){

    var val = $('#emp').val();
    
    socket.emit('new user',val);
  })

  

   /**
   * renders messages to the DOM ME
   * nothing fancy
   */
  function renderMessageMe(msg) {
    // msg = JSON.parse(msg);
    var html = "<div class='direct-chat-msg right'>";
    html += "<div class='direct-chat-info clearfix'>";
    html += "<span  class='direct-chat-name pull-right'>" + msg.name  + " </span>";
    html += "<span class='direct-chat-timestamp pull-left'>" + msg.tgl + ": </span>";
    html += "</div>";
    html += "<div class='direct-chat-img'><img  class='img-circle' style='width:50px;height:50px;' src=data:image/jpg;base64,"+ msg.base64 + "></div>";
    html += "<div class='direct-chat-text'>"  + msg.message + "</div>";
    html += "</div>";
    content.append(html);  // append to list
    return;
  }


      /**
   * renders messages to the DOM
   * nothing fancy
   */
  function renderMessage(msg) {
    // msg = JSON.parse(msg);
    var html = "<div class='direct-chat-msg'>";
    html +="<div class='direct-chat-info clearfix'>"
    html += "<span class='direct-chat-timestamp pull-right'>" + msg.tgl  + " </span>";
    html += "<span class='direct-chat-name pull-left'>" + msg.name + " </span>";
    html += "</div>";
    html += "<div class='direct-chat-img'><img  class='img-circle' style='width:50px;height:50px;' src=data:image/jpg;base64,"+ msg.base64 + "></div>";
    html += "<div class='direct-chat-text'>"  + msg.message + "</div>";
    html += "</div>";
    content.append(html);  // append to list
    return;
  }

    socket.on('notification', function (data) {
        var mgs =  JSON.parse(data);
        if(mgs.id  == 1){
            renderMessage(mgs);
        }else{
             renderMessageMe(mgs);
        }
        scrollToBottom(data);
    });

     socket.on('load', function (data) {
        data.map(function(msg){
       var mgs =  JSON.parse(msg);
        if(mgs.id == 1)
        {
            renderMessage(mgs);
        }else{
            renderMessageMe(mgs);
        }

        })
        scrollToBottom(data); 
    });

      socket.on('disconnect', function() {
            console.log('disconnected');
        });

});
