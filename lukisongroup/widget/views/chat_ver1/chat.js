$('#inp-chat').focus();
var sse;
var $container = $('#message-container');

sse = new EventSource(chatOpts.messageUrl);
 console.log(sse);
sse.addEventListener('chat', function (e) {
    var data = JSON.parse(e.data);
    var msgs = data.msgs;

     console.log(msgs);    

    $.each(msgs, function () {
        var msg = this;
        var $row;
        if (msg.self == 1) {
            $row = $(chatOpts.templateMe);
            
        } else {
            $row = $(chatOpts.templateYou);
            $row.find('[data-attr="name"]').text(msg.name);

        }
        $row.find('[data-attr="time"]').text(msg.time);
        $row.find('[data-attr="text"]').text(msg.text);
      
        $container.prepend($row);
        
        
    });

    if (msgs.length) {
        $container.scrollTop($container.prop("scrollHeight"));
    }
});

// sse.addEventListener('msgerror', function (e) {
//     var data = JSON.parse(e.data);
//     console.log(data.msgs);
// });


function chat()
{
    var txt = $('#inp-chat').val().trim();
    if (txt != '') {
        $('#inp-chat').val('');
        $.post(chatOpts.chatUrl, {chat: txt}, function () {

        });
    }
}

$('#btn-chat').click(function () {
    chat();
});

$('#inp-chat').keydown(function (e) {
    if (e.which == 13) {
        chat();
    }
});