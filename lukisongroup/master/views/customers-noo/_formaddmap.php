<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use yii\helpers\BaseHtml;

?>
<?php $form = ActiveForm::begin([
'id'=>$model->formName(),
// 'method'=>'post'

]); ?>
 <?= $form->field($model, 'CUST_KD')->textInput(['value' => $id,'disabled'=>true]) ?>

   <?= $form->field($model, 'ALAMAT')->textInput(['readonly' => true]) ?>

   <?= BaseHtml::activeHiddenInput($model, 'MAP_LAT'); ?>

   <?= BaseHtml::activeHiddenInput($model, 'MAP_LNG'); ?>

     <?= \pigolab\locationpicker\LocationPickerWidget::widget([
       'options' => [
            'style' => 'width: 100%; height: 400px', // map canvas width and height
        ] ,
        'clientOptions' => [
            'location' => [
                'latitude'  => -6.1783 ,
                'longitude' =>106.6319,

            ],
            'radius'    => 300,
            'inputBinding' => [
                'latitudeInput'     => new JsExpression("$('#customers-map_lat')"),
                'longitudeInput'    => new JsExpression("$('#customers-map_lng')"),
                'locationNameInput' => new JsExpression("$('#customers-alamat')")
            ]
        ]
    ]);
?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'SAVE' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

    <?php ActiveForm::end(); ?>
