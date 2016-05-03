<?php
/* extensions */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
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
      <div class="col-xs-2 col-sm-2 col-md-2">
        <?= $foto_profile ?>
      </div>
      <div class="col-xs-10 col-sm-10 col-md-10">
        <?= $form->field($model, 'CHAT')->textArea(['options' => ['rows' => 6]])?>
      </div>

      </div>
      </div>


    <div class="form-group" style="margin-top:10px">
        <?= Html::submitButton($model->isNewRecord ? 'SEND' : 'Update', ['class' => $roDetail->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php


 ?>
