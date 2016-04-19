<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\label\LabelInPlace;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Province */
/* @var $form yii\widgets\ActiveForm */

   $config = ['template'=>"{input}\n{error}\n{hint}"];

?>

<div class="province-form">

    <?php $form = ActiveForm::begin([
	'id'=>$model->formName(),
	'enableClientValidation'=>true

	]); ?>

	<?= $form->field($model, 'PROVINCE', $config)->widget(LabelInPlace::classname());?>

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

                                             $(document).find('#form3').modal('hide');
                                             $('form#{$model->formName()}').trigger('reset');
                                             $.pjax.reload({container:'#gv-prov'});
                                          }
                                        else{
                                           console.log(result)
                                        }

            });

return false;


});


 ",$this::POS_END);
