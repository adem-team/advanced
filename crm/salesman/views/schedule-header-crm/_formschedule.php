<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Scheduleheader */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="scheduleheader-form">
<?php
  $form = ActiveForm::begin([
            'id'=>$model->formName(),
              'enableClientValidation'=>true
      ]);
      // echo $form->field($model, 'TGL1')->Hiddeninput(['id'=>'tglawal'])->label(false);
      //
      // echo $form->field($model, 'TGL2')->Hiddeninput(['id'=>'tglakhir'])->label(false);

      echo $form->field($model, 'SCDL_GROUP')->widget(Select2::classname(), [
          'data' => $datagroup,
          'options' => ['placeholder' => 'Select Group ...'],
          'pluginOptions' => [
              'allowClear' => true
              ],
          ]);

      echo $form->field($model, 'USER_ID')->widget(Select2::classname(), [
              'data' => $datauser,
              'options' => ['placeholder' => 'Select User ...'],
              'pluginOptions' => [
                  'allowClear' => true
                  ],
              ]);
      echo $form->field($model, 'NOTE')->Textarea(['rows'=>2,'id'=>'note'])->label('KETERANGAN');

?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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

                                            $(document).find('#modal').modal('hide');
                  													// $.pjax.reload({container:'#gv-schedule-id'});
                  												 $('form#Scheduleheader').trigger('reset');
                  												//  $.pjax.reload({container:'#calendar'});
                                          }
                                        else{
                                           console.log(result)
                                        }

            });

return false;


});


 ",$this::POS_READY);
