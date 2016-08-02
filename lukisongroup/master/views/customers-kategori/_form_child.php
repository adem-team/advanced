<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use lukisongroup\master\models\Kategoricus;

/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Kategoricus */
/* @var $form yii\widgets\ActiveForm */
// $drop = Kategoricus::find()->select('CUST_KTG_NM')
												// ->where('CUST_KTG_PARENT = 0')
												// ->all();

// $dropparent = ArrayHelper::map(\lukisongroup\esm\models\Kategoricus::find() ->where('CUST_KTG_PARENT <> 0')
//                                                                             ->all(), 'CUST_KTG', 'CUST_KTG_NM');
?>



<div class="kategoricus-form">

    <?php $form = ActiveForm::begin([
	  'id'=>$model->formName(),
      'enableClientValidation' => true,

	]); ?>


     <?= $form->field($model, 'CUST_KTG_NM')->textInput(['maxlength' => true])->label('Nama Customers Kategori') ?>

       <?= $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']) ?>

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

                                             $(document).find('#formparent').modal('hide');
                                             $('form#kategoricus').trigger('reset');
                                             $.pjax.reload({container:'#gv-kat'});
                                          }
                                        else{
                                           console.log(result)
                                        }

            });

return false;


});


 ",$this::POS_END);
