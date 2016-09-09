$('#message-field').focus();

$('#chat-form').submit(function() {
     var form = $(this);
     var me = chatOpts.templateMe;
     var you = chatOpts.templateYou;
     $.ajax({
          url: form.attr('action'),
          type: 'post',
          data: form.serialize()+ "&temp_me=" + me+"&temp_you="+you,
          success: function (response) {
               $("#message-field").val("");
          }
     });

     return false;
});
