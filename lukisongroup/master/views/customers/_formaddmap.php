<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Customerskat */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="customerskat-form">

    <?php $form = ActiveForm::begin([
	'id'=>'createmap',
	]); ?>

    <?= $form->field($model, 'CUST_KD')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    <?= $form->field($model, 'ALAMAT')->textInput(['maxlength' => true,'readonly'=>true]) ?>

   <?= $form->field($model, 'MAP_LNG')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'MAP_LAT')->hiddenInput()->label(false) ?>


   <?php echo \pigolab\locationpicker\LocationPickerWidget::widget([
       // 'key' => 'http://maps.google.com/maps/api/js?sensor=false&libraries=places', // optional , Your can also put your google map api key
       'options' => [

            'style' => 'width: 100%; height: 400px',
            'enableSearchBox' => true, // Optional , default is true
        'searchBoxOptions' => [ // searchBox html attributes
            'style' => 'width: 300px;', // Optional , default width and height defined in css coordinates-picker.css
                    ], // map canvas width and height
        ] ,
        'clientOptions' => [
            'location' => [
                'latitude'  => -6.214620,
                'longitude' => 106.845130 ,

            ],
            'radius'    => 300,
            'inputBinding' => [
                'latitudeInput'     => new JsExpression("$('#customers-map_lat')"),
                 'longitudeInput'    => new JsExpression("$('#customers-map_lng')"),
                'locationNameInput' => new JsExpression("$('#customers-alamat')")
            ],
            'enableAutocomplete' => true,
        ]
    ]);
?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
		  <?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
