<?php // 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\label\LabelInPlace;


/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\Chat */
/* @var $form yii\widgets\ActiveForm */
$config = ['template'=>"{input}\n{error}\n{hint}"];  
?>

<div class="chat-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'id'=> $model->formName()
        
    ]); ?>
    
     <?= $form->field($model, 'MESSAGE', $config)->widget(LabelInPlace::classname());?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'SEND' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

 $this->registerJs("
        
   $('form#{$model->formName()}').on('beforeSubmit',function(e)
    {
        var \$form = $(this);
        $.post(
            \$form.attr('action'),
            \$form.serialize()

        )
        
            .done(function(result){
           
			        if(result == 1 )
                                          {
                                             $(document).find('#modal-bumum').modal('hide')
                                             $('form#chat').trigger('reset');
                                             $.pjax.reload({container:'#gv-chat'});
                                          }
                                        else{
                                           console.log(result)
                                        }
            
            });
            
return false;


});

 
 ",$this::POS_READY);
        
        