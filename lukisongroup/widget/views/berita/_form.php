<?php
/* extensions */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\Berita */
/* @var $form yii\widgets\ActiveForm */


/* foto profile */
if($emp_img == '')
{
 $foto_profile = Html::img(Yii::getAlias('@web').'/upload/hrd/Employee/default.jpg', ['width'=>'130','height'=>'130', 'align'=>'center' ,'class'=>'img-thumbnail']);
}else{
 $foto_profile = Html::img(Yii::getAlias('@web').'/upload/hrd/Employee/'.$emp_img, ['width'=>'130','height'=>'130', 'align'=>'center' ,'class'=>'img-thumbnail']);
}
?>


    <?php $form = ActiveForm::begin([
      'id'=>$model->formName(),
      'enableClientValidation' => true,
      // 'enableAjaxValidation'=>true,
    ]); ?>


    <div class="row">
      <div class="col-xs-4 col-sm-4 col-md-4">
        <?= $foto_profile ?>
      </div>
      <div class="col-xs-8 col-sm-8 col-md-8">
        <?= $form->field($model, 'JUDUL')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'ISI')->textArea(['options' => ['rows' => 6]])?>

        <?= $form->field($model, 'alluser')->checkbox()->label('All'); ?>

        <div id="berita-hide">
        <?=  $form->field($model, 'KD_DEP')->widget(Select2::classname(),['data' => $datadep,'options' => ['placeholder' => 'Select ...'],]) ?>

        <?= $form->field($model, 'USER_CC')->widget(DepDrop::classname(), [
           'options' => ['placeholder' => 'Select ...'],
           'type' => DepDrop::TYPE_SELECT2,
           'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
           'pluginOptions'=>[
                'depends'=>['berita-kd_dep'],
                'url' => Url::to(['/widget/berita/cari-user-berita']),
                'loadingText' => 'Loading ...',
        ]
        ]) ?>
      </div>

      </div>
      </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $roDetail->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
/* js news author :wawan
*/
  $this->registerJs('
  $("#berita-alluser").click(function()
  {
    if(this.checked == 1)
    {
      $("#berita-hide").hide();
    }else{
        $("#berita-hide").show();
    }
  });

  ',$this::POS_READY);

 ?>
