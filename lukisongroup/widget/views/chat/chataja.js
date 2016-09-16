$('#message-field').focus();

$('#chat-form').submit(function() {
     var form = $(this);
     $.ajax({
          url: form.attr('action'),
          type: 'post',
          data: form.serialize(),
          success: function (response) {
               $("#message-field").val("");
          }
     });

     return false;
});
