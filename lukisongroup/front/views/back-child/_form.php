<?php
use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use yii\helpers\Url;
use lukisongroup\front\models\Parents;
use lukisongroup\front\models\Child;
$data = [
    "red" => "red",
    "green" => "green",
    "blue" => "blue",
    "orange" => "orange",
    "white" => "white",
    "black" => "black",
    "purple" => "purple",
    "cyan" => "cyan",
    "teal" => "teal"
]; 

/* @var $this yii\web\View */
/* @var $model lukisongroup\child\models\Child */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="child-form">

    <?php $form = ActiveForm::begin(); ?>

   <?= $form->field($model, 'PARENT_ID')->widget(Select2::classname(),[
			'data'=>ArrayHelper::map(Parents::find()->all(),'parent_id','parent'),
			'language'=>'en',
			/* 'options'=>[
				'placeholder'=>'select a Parent Code',
				'id'=>'zipCode'
			], */
			//'pluginOptions'=>[
				//'allowClear'=>true
			//],
        ]);
    ?>

    <?= $form->field($model, 'CHILD_NAME')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
