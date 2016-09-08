$( document ).ready(function() {

    var socket = io.connect('http://lukisongroup.com:8890');

    socket.on('notification', function (data) {

        var message = JSON.parse(data);
		
		console.log(message);

        $( "#notification" ).prepend( "<p><strong>" + message.name + "</strong>: " + message.message + "</p>" );

    });

});
