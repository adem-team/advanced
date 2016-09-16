$( document ).ready(function() {

    var socket = io.connect('http://lukisongroup.com:8890');

    var content = $( "#message-container" );

   
  function scrollToBottom (mess) {
    if (mess.length) {
        content.scrollTop(content.prop("scrollHeight"));
        }
  }

      /**
   * renders messages to the DOM
   * nothing fancy
   */
  function renderMessage(msg) {
    msg = JSON.parse(msg);
    var html = "<div class='direct-chat-msg'>";
    html +="<div class='direct-chat-info clearfix'>"
    html += "<span class='direct-chat-timestamp pull-right'>" + msg.tgl  + " </span>";
    html += "<span class='direct-chat-name pull-left'>" + msg.name + ": </span>";
    html += "</div>";
    html += "<div class='direct-chat-img'><img  class='img-circle' style='width:50px;height:50px;' src=data:image/jpg;base64,"+ msg.base64 + "></div>";
    html += "<div class='direct-chat-text'>"  + msg.message + "</div>";
    html += "</div>";
    content.append(html);  // append to list
    return;
  }

    socket.on('notification', function (data) {
        renderMessage(data);
        
        scrollToBottom(data);
    });

     socket.on('load', function (data) {
        data.map(function(msg){
        renderMessage(msg);

        })
        scrollToBottom(data); 
    });

      socket.on('disconnect', function() {
            console.log('disconnected');
        });

});
