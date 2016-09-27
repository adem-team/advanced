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

     $('.fc-button-prev span').click(function(){
    var date =  $('#calendar_test').fullCalendar('getDate').endOf('days');
     return false;
  });

  $('.fc-next-button ').click(function(){
     var date =  $('#calendar_test').fullCalendar('getDate').endOf('month');  ;
     alert(date);
     return false;
  });

   //  function displaydata(){
   //    $.getJSON('/widget/pilotproject/jsonevent', function(info){
   //        for (var numero = 0;numero < info.length;numero++) {
   //          var eventObjectFromDB = info[numero];
   //          var eventToExternalEvents =                      
   //                                         {"title":eventObjectFromDB.title,
   //                              "id":eventObjectFromDB.id,
   //                              "start":eventObjectFromDB.start,
   //                                      "end":eventObjectFromDB.end,
   //                                      // "allDay":eventObjectFromDB.allDay,
   //                  "editable":true};

   // $('#external-events').append("<div class='external-event' id='mec"+numero+"'>"+ eventToExternalEvents.title +"</div>");
   //          var eventObject2 = {
   //              title: $.trim(eventToExternalEvents.title) // use the element's text as the event title
   //          };
   //          var events = $('#mec'+numero).data('eventObject', eventObject2);
   //          // alert('#mec'+numero+'');
   //          // $('.external-event').draggable({
   //          //   editable: true,
   //          //     zIndex: 999,
   //          //     revert: true,      // will cause the event to go back to its
   //          //     revertDuration: 0  });
   //          // $('#calendar_test').fullCalendar( 'refetchEvents' );

   //          ini_events(events);
   //       }
   //    });
   //  }

   //  $(window).load(function(){
   //    displaydata();
   //  })

    function save(ev){
            $.ajax({
              type:'POST',
              data:{'event':ev},
              url:'/widget/pilotproject/save-event',
              success:function(data) {
              //Create events
              var event = $('<div/>');
              event.css({'background-color': currColor, 'eventColor': currColor, 'color': '#fff'}).addClass('external-event');
              event.html(ev);
              $('#external-events').prepend(event);

              //Add draggable funtionality
              ini_events(event);
              }
        });
  }

	$('#add-new-event').click(function (e) {
      e.preventDefault();
      //Get value and make sure it is not null
      var val = $('#new-event').val();
      if (val.length == 0) {
        return;
      }

      // //Create events
      save(val);
      // var event = $('<div/>');
      // event.css({'background-color': currColor, 'eventColor': currColor, 'color': '#fff'}).addClass('external-event');
      // event.html(val);
      // $('#external-events').prepend(event);

      //Add draggable funtionality
      // ini_events(event);

      //Remove event from text input
      $('#new-event').val('');
    });	