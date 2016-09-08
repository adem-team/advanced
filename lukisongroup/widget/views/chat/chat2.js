
$('#inp-chat').focus();
var sse;
var $container = $('#message-container');

sse = new EventSource(chatOpts.messageUrl);
 console.log(sse);
sse.addEventListener('chat', function (e) {
    var data = JSON.parse(e.data);
    var msgs = data.msgs;

      
     for (var accId in msgs) {
              
                // for (var i in msgs[accId]) {
                   
                //     var row = msgs[accId][i];
                //     local.msgs[accId].push(row);
                //     if (local.self == 1) {
                //         $('<div>').text(row[1]).appendTo('#message-container')
                //     }
                // }
                
            }

             console.log(accId);  
    

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