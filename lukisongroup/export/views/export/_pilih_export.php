<?php

/*extensions*/
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use yii\helpers\Url;


/*namespace models*/
use lukisongroup\master\models\Kategoricus;


/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Kategoricus */
/* @var $form yii\widgets\ActiveForm */

 $dropparentkategori = ArrayHelper::map(Kategoricus::find()->where('CUST_KTG_PARENT = CUST_KTG')
                                                                   ->asArray()
                                                                   ->all(),'CUST_KTG', 'CUST_KTG_NM');

?>



<div class="kategoricus-form">

    <?php $form = ActiveForm::begin([
	  'id'=>$model->formName(),
      'enableClientValidation' => true,

	]); ?>
    
    <?= $form->field($model, 'cus_Type')->widget(Select2::classname(),[
      'options'=>[  'placeholder' => 'Select Category ...'
      ],
      'data' => $dropparentkategori
    ])->label('Kategori');
        ?>

  <?= $form->field($model, 'cust_ktg')->widget(DepDrop::classname(), [
    'type'=>DepDrop::TYPE_SELECT2,
    'options'=>['placeholder'=>'Select ...'],
    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
    'pluginOptions'=>[
        'depends'=>['customers-cus_type'],
         'initialize' => true,
          'loadingText' => 'Loading  ...',
        'url' => Url::to(['/master/customers/lisdata']),
    ]
])->label('Type') ?>

<?= $form->field($model, 'CUST_GRP')->widget(DepDrop::classname(), [
    'type'=>DepDrop::TYPE_SELECT2,
    'options'=>['placeholder'=>'Select ...'],
    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
    'pluginOptions'=>[
        'depends'=>['customers-cust_ktg'],
         // 'initialize' => true,
         'loadingText' => 'Loading  ...',
        'url'=>Url::to(['/master/customers/lis-cus']),
    ]
]) ?>

  
   
    <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Print' : 'Print', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
