/* ADDING EVENTS */
    var currColor = '#3c8dbc'; //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn');
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault();
      //Save color
      currColor = $(this).css('color');
      //Add color effect to button
      $('#add-new-event').css({'background-color': currColor, 'eventColor': currColor});
    });


    // function count(){
    //    $.getJSON('/widget/pilotproject/count-event', function(data){

    //      // var datx = parseInt(data);
    //      return data;

    //    });

    // }

    
    // $.ajax({
    //     'async': false,
    //     'type': "POST",
    //     'global': false,
    //     'dataType': 'html',
    //     'url': "/widget/pilotproject/count-event",
    //     'data': { 'request': "", 'target': 'arrange_url', 'method': 'method_target' },
    //     'success': function (data) {
    //         tmp = data;
    //     }
    // });
    // return tmp;
// }();


  /* display data json event */
    function displaydata(){
      $.getJSON('/widget/pilotproject/jsonevent', function(info){
          for (var numero = 0;numero < info.length;numero++) {
            var eventObjectFromDB = info[numero];
            var eventToExternalEvents =                      
                                           {"title":eventObjectFromDB.title,
											"id":eventObjectFromDB.id,
											"start":eventObjectFromDB.start,
											"end":eventObjectFromDB.end,
											"color":eventObjectFromDB.color,
                                        // "allDay":eventObjectFromDB.allDay,
                    "editable":true};

                    //Create events
              var event = $('<div/>');
              event.css({'background-color': eventToExternalEvents.color, 'eventColor': eventToExternalEvents.color, 'color': '#fff'}).addClass('external-event');
              event.html(eventToExternalEvents.title);
              $('#external-events').append(event);

   // $('#external-events').append("<div id='mec"+numero+"'>"+ eventToExternalEvents.title +"</div>").css({'background-color': eventToExternalEvents.color, 'eventColor': eventToExternalEvents.color, 'color': '#fff'}).addClass('external-event');
            var eventObject2 = {
                title: $.trim(eventToExternalEvents.title), // use the element's text as the event title
                
            };
            var events = $('#mec'+numero).data('eventObject', eventObject2);
            // alert('#mec'+numero+'');
            // $('.external-event').draggable({
            //   editable: true,
            //     zIndex: 999,
            //     revert: true,      // will cause the event to go back to its
            //     revertDuration: 0  });
            // $('#calendar_test').fullCalendar( 'refetchEvents' );

            ini_events(event);
            $('#calendar_test').fullCalendar( 'refetchEvents' );
         }
      });
    }


    /*after load display data*/
    $(window).load(function(){
      displaydata(); 
       
    })

    function save(ev){
            $.ajax({
              type:'POST',
              data:{'event':ev,'color':currColor},
              url:'/widget/pilotproject/save-event',
              success:function(data) {
              //Create events
              // var event = $('<div/>');
              // event.css({'background-color': currColor, 'eventColor': currColor, 'color': '#fff'}).addClass('external-event');
              // event.html(ev);
              // $('#external-events').prepend(event);

              // Add draggable funtionality
              // ini_events(event);
              }
        });
  }

// keyup enter
  $('#new-event').keyup(function(e) {
    e.preventDefault();
     var val = $('#new-event').val();
       // $.getJSON('/widget/pilotproject/count-event', function(data){

         // var datx = parseInt(data);
          // tmp = data;

          // if(tmp != 0)
          // {
             if (e.which == 13) {
                // do it
                save(val);
                var event = $('<div/>');
                event.css({'background-color': currColor, 'eventColor': currColor, 'color': '#fff'}).addClass('external-event');
                event.html(val);
                $('#external-events').prepend(event);

                // Add draggable funtionality
                ini_events(event);

                //Remove event from text input
                $('#new-event').val('');
              }
         // }else{
         //    console.log('tambahkan row dahulu')
         // }
         
       // });
   
});
 

	$('#add-new-event').click(function (e) {
      e.preventDefault();

      //Get value and make sure it is not null
      var val = $('#new-event').val();
      if (val.length == 0) {
        return;
      }

      $.getJSON('/widget/pilotproject/count-event', function(data){

              // tmp = data;
              // if(tmp != 0)
              // {
                 // //Create events
                save(val);
                var event = $('<div/>');
                event.css({'background-color': currColor, 'eventColor': currColor, 'color': '#fff'}).addClass('external-event');
                event.html(val);
                $('#external-events').prepend(event);

                // Add draggable funtionality
                ini_events(event);

                //Remove event from text input
                $('#new-event').val('');
              // }else{
              //   alert('tolong tambahkan row');
              // }
          });
     
});	