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


	$dropdis = ArrayHelper::map(\lukisongroup\master\models\Distributor::find()->all(), 'KD_DISTRIBUTOR', 'NM_DISTRIBUTOR');
	$config = ['template'=>"{input}\n{error}\n{hint}"];
	// $dropparent = ArrayHelper::map(\lukisongroup\master\models\Kategori::find()->all(),'CUST_KTG_PARENT', 'CUST_KTG_NM');
	$no = 0;
	$dropparentkategori = ArrayHelper::map(Kategoricus::find()->where(['CUST_KTG_PARENT'=>$no])
                                                             ->asArray()
                                                             ->all(),'CUST_KTG', 'CUST_KTG_NM');
	$droppro = ArrayHelper::map(Province::find()->asArray()
                                              ->all(),'PROVINCE_ID','PROVINCE');
	

	$form = ActiveForm::begin([
			'id'=>$model->formName(),
	]);
			
	echo $form->field($model, 'CUST_NM', $config)->widget(LabelInPlace::classname());

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
	echo $form->field($model, 'PARENT')->widget(Select2::classname(),[
		'options'=>[  'placeholder' => 'Select Customers parent ...'
		],
		'data' => $dropparentkategori
	]);
	
	echo $form->field($model, 'CUST_KTG')->widget(DepDrop::classname(), [
		'options' => [//'id'=>'customers-cust_ktg',
		'placeholder' => 'Select Customers kategory'],
		'type' => DepDrop::TYPE_SELECT2,
		'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
		'pluginOptions'=>[
			'depends'=>['customers-parent'],
			'url' => Url::to(['/master/customers/lisdata']),
		  'loadingText' => 'Loading data ...',
		]
	]);
	
	echo $form->field($model, 'PIC', $config)->widget(LabelInPlace::classname());
	
	echo $form->field($model, 'KD_DISTRIBUTOR')->widget(Select2::classname(), [
		     'data' => $dropdis,
        'options' => [
        'placeholder' => 'Pilih Distributor ...'],
        'pluginOptions' => [
            'allowClear' => true
             ],

    ]);
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
