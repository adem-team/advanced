

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;


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

  echo $form->field($model, 'STT_UBAH')->widget(Select2::classname(), [
          'data' => $val,
          'options' => ['placeholder' => 'Select ...'],
          'pluginOptions' => [
              'allowClear' => true
              ],
          ]);

  
      echo $form->field($model, 'SCDL_GROUP')->widget(DepDrop::classname(), [
          // 'data' => $datagroup,
          'options' => ['placeholder' => 'Select Group ...'],
          'type'=>DepDrop::TYPE_SELECT2,
          'pluginOptions' => [
              'allowClear' => true,

               'depends'=>['scheduleheadertemp-stt_ubah'],
                'placeholder'=>'Select...',
                'url'=>Url::to(['/master/schedule-header/sub-group','tgl'=>$tgl1]),
              ],
          ]);
      

      echo $form->field($model, 'USER_ID')->widget(DepDrop::classname(), [
              // 'data' => $datauser,
              'options' => ['placeholder' => 'Select User ...'],
              'type'=>DepDrop::TYPE_SELECT2,
              'pluginOptions' => [
                'allowClear' => true,
                'depends'=>['scheduleheadertemp-stt_ubah', 'scheduleheadertemp-scdl_group'],
                 // 'depends'=>['scheduleheader-scdl_group'],
                  'placeholder'=>'Select...',
                  'url'=>Url::to(['/master/schedule-header/sub-user','tgl'=>$tgl1]),
                   ],
              ]);
      echo $form->field($model, 'NOTE')->Textarea(['rows'=>2,'id'=>'note'])->label('KETERANGAN');

?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
