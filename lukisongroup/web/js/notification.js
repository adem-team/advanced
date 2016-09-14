$( document ).ready(function() {

    var socket = io.connect('http://lukisongroup.com:8890');

    socket.on('notification', function (data) {

        var message = JSON.parse(data);
         console.log(message);
        var $row;


		var $container = $('#message-container');
		if(message.yandm == 'me'){
			$row = $(message.me);
		}else{
			$row = $(message.you);
		}
        $row.find('[data-attr="text"]').text(message.message);
		$container.prepend($row);
        $container.prepend( "<p><strong>" + message.name + "</strong>: " + message.tgl + "</p>" + message.message + "</p>" );
        if (message.length) {
        $container.scrollTop($container.prop("scrollHeight"));
		}
    });

});
