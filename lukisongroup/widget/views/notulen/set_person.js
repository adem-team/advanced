// var duallist2 = $('#bootstrap-duallistbox-selected-list_PostPerson[Person]');


// var dual = $('#bootstrap-duallistbox-nonselected-list_PostPerson[Person]');
// var xz = $('select[name="PostPerson[Person][]_helper2"]');

  // var dual =  $('select[name='PostPerson']').bootstrapDualListbox();
  // $(document).ready(function(){

    $('#per-id').on("click",function(){
       $("#person-notulen").modal();
       var val =  $('#postperson-notulenid').val();
     

    $.get('/widget/notulen/set-person-select?id='+val,function(data){ 
         

          var x = JSON.parse(data);
          var y = x.option;
          // alert(y);
          $('#tes').append(x.selected); // add data
           $('#tes').append(y); // add data
          // $('#tes option:selected').remove() //remove data

          // $('#tes').trigger('bootstrapduallistbox.refresh');
          $('#tes').bootstrapDualListbox('refresh');


        });




         }); 

   
// });
  // $('#per-id').bind("click",function(){

  //   var val =  $('#hide').val();
  //   alert('tes');
  //   // var val = 25;
  //   // alert(val);

  //   $.get('/widget/notulen/set-person-select?id='+val,function(data){ 
  //           // data
  //           // alert(data);
  //         $('#tes').append(data); // add data
  //         // $('#tes option:selected').remove() //remove data

  //         // $('#tes').trigger('bootstrapduallistbox.refresh');
  //         $('#tes').bootstrapDualListbox('refresh');


  //       }); 

 
      
    // alert(val);

    // alert('tes');
  // duallist2.append('Oranges');
// duallist2.append('<option value="apples">Apples</option><option value="oranges" selected>Oranges</option>');
  // $('<option>').val('apples').text('Apples').append(xz);
   //$('#postperson-person').append('<option value="apples">Apples</option>');
  // dual.bootstrapDualListbox('refresh');

  // $('#tes').append('<option value="oranges" selected>Oranges</option>');
 // duallist2.trigger('bootstrapduallistbox.refresh');
  // duallist2.bootstrapDualListbox('refresh',true);
 // duallist2.bootstrapDualListbox('refresh');
 // $('#tes').bootstrapDualListbox('refresh');
// });


//   $('#person-notulen').on("show.bs.modal",function(){

//     var val =  $('#hide').val();
//     // var val = 25;
//     // alert(val);

//     $.get('/widget/notulen/set-person-select?id='+val,function(data){ 
//             // data
//             // alert(data);
//           $('#tes').append(data); // add data
//           $('#tes option:selected').remove() //remove data

//           // $('#tes').trigger('bootstrapduallistbox.refresh');
//           $('#tes').bootstrapDualListbox('refresh');


//         }); 

 
      
//     // alert(val);

//   	// alert('tes');
//   // duallist2.append('Oranges');
// // duallist2.append('<option value="apples">Apples</option><option value="oranges" selected>Oranges</option>');
//   // $('<option>').val('apples').text('Apples').append(xz);
//    //$('#postperson-person').append('<option value="apples">Apples</option>');
//   // dual.bootstrapDualListbox('refresh');

//   // $('#tes').append('<option value="oranges" selected>Oranges</option>');
//  // duallist2.trigger('bootstrapduallistbox.refresh');
//   // duallist2.bootstrapDualListbox('refresh',true);
//  // duallist2.bootstrapDualListbox('refresh');
//  // $('#tes').bootstrapDualListbox('refresh');
// });

//   function timeload(){

//   }

  $('#person-notulen').on("hidden.bs.modal",function(){
  $('#tes option:selected').remove()
   $('#tes option').remove()
   $('#tes').bootstrapDualListbox('refresh');

    // $('#tes').bootstrapDualListbox('destroy');

  });



   // $('#person-notulen').on('show.bs.modal', function () {
   //      alert('tes');
   //       dual.append('Apples');
   //      dual.bootstrapDualListbox('refresh');   
   //          });


//  $('#mySelect').append($('<option>', {
//     value: 1,
//     text: 'My option'
// }));

//  $('person-form').on('beforeSubmit',function(e)
//     {
        
//         var val =  $('#hide').val();
//     // var val = 25;
//     // alert(val);

//     $.get('/widget/notulen/set-person-select?id='+val,function(data){ 
//             // data
//             // alert(data);
//           $('#tes').append(data); // add data
//           $('#tes option:selected').remove() //remove data

//           // $('#tes').trigger('bootstrapduallistbox.refresh');
//           $('#tes').bootstrapDualListbox('refresh');


//         }); 

// return false;


// });