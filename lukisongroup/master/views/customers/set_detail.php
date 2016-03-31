<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DatePicker;
use kartik\label\LabelInPlace;
use lukisongroup\master\models\Kategoricus;
use lukisongroup\master\models\Province;
use lukisongroup\master\models\Kota;
use yii\web\JsExpression;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\widgets\DepDrop;




		$config = ['template'=>"{input}\n{error}\n{hint}"];
	// $dropparent = ArrayHelper::map(\lukisongroup\master\models\Kategori::find()->all(),'CUST_KTG_PARENT', 'CUST_KTG_NM');




	$form = ActiveForm::begin([
			'id'=>$model->formName(),
			'enableClientValidation' => true,
	]);

	// echo $form->field($model, 'CUST_NM', $config)->widget(LabelInPlace::classname());

	echo  $form->field($model, 'PROVINCE_ID')->widget(Select2::classname(),[
			'options'=>[
				'id'=>'customers-province_id',
				'placeholder' => 'Select provinsi ...'
			],
			'data' => $droppro
	]);

	echo $form->field($model, 'CITY_ID')->widget(DepDrop::classname(), [
			'options' => ['id'=>'customers-city_id',
			'placeholder' => 'Select Kota'],
			'type' => DepDrop::TYPE_SELECT2,
			'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
			'pluginOptions'=>[
				'depends'=>['customers-province_id'],
				'url' => Url::to(['/master/customers/lisarea']),
			  'loadingText' => 'Loading data ...',
			]
	]);

		echo $form->field($model, 'ALAMAT', $config)->widget(LabelInPlace::classname());
	// echo $form->field($model, 'CUST_TYPE')->widget(Select2::classname(),[
	// 	'options'=>[  'placeholder' => 'Select Customers parent ...'
	// 	],
	// 	'data' => $dropparentkategori
	// ]);
	//
	// echo $form->field($model, 'CUST_KTG')->widget(DepDrop::classname(), [
	// 	'options' => [//'id'=>'customers-cust_ktg',
	// 	'placeholder' => 'Select Customers kategory'],
	// 	'type' => DepDrop::TYPE_SELECT2,
	// 	'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
	// 	'pluginOptions'=>[
	// 		'depends'=>['customers-cust_type'],
	// 		'url' => Url::to(['/master/customers/lisdata']),
	// 	  'loadingText' => 'Loading data ...',
	// 	]
	// ]);
  // echo $form->field($model, 'TLP2', $config)->widget(LabelInPlace::classname());
	//
  // echo $form->field($model, 'EMAIL', $config)->widget(LabelInPlace::classname());
	//
  // echo $form->field($model, 'FAX', $config)->widget(LabelInPlace::classname());
	//
  // echo $form->field($model, 'NPWP', $config)->widget(LabelInPlace::classname());
	//
  //   echo $form->field($model, 'WEBSITE', $config)->widget(LabelInPlace::classname());

?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>

    </div>

    <?php ActiveForm::end(); ?>
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
                  $(document).find('#createcus').modal('hide');
                  $('form#customers').trigger('reset');
                  $.pjax.reload({container:'#gv-cus'});

                  }
                else{
                      console.log(result)
                      }

            });

return false;


});


 ",$this::POS_END);
