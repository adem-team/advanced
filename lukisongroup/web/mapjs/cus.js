function submit()
{

    
        var $form = $(this);

        $.post(
            $form.attr('action'),
            $form.serialize()

        )
        
            .done(function(result){
				alert(result)
			        if(result == 1 )
                                          {
											    
                                             $(document).find('#createcus').modal('hide');
                                             $('form#customers').trigger('reset');
                                             $.pjax.reload({container:'#axctive224'});
                                          }
                                        else{
                                           console.log(result)
                                        }
            
            });
            
return false;



}