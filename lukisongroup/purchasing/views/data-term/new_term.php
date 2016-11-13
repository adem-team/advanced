<?php
/*extensions*/
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\money\MaskMoney;
use kartik\label\LabelInPlace;
use kartik\widgets\DatePicker;

/*namespace models*/
use lukisongroup\master\models\Terminvest;

/* @var $this yii\web\View */
/* @var $model lukisongroup\purchasing\data_term\models\Termheader */
/* @var $form yii\widgets\ActiveForm */

  
$config = ['template'=>"{input}\n{error}\n{hint}"]; #config kartik label place


?>
<div class="termcustomers-form">

    <?php $form = ActiveForm::begin([
      'id'=>$model->formName(),
    ]); ?>


    <?= $form->field($model, 'CUST_KD_PARENT')->widget(Select2::classname(),[
  		'options'=>[  'placeholder' => 'Select Customers parent ...'
  		],
  		'data' =>$parent_customers
  	]);?>


    <?= $form->field($model, 'PRINCIPAL_KD')->widget(Select2::classname(),[
  		'options'=>[  'placeholder' => 'Select Nama Principal ...'
  		],
  		'data' =>$data_corp
  	]);?>

    <?= $form->field($model, 'DIST_KD')->widget(Select2::classname(),[
      'options'=>[  'placeholder' => 'Select Nama Distributor ...'
      ],
      'data' =>$data_distributor
    ]);?>


   <?php echo $form->field($model, 'PERIOD_START')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Tgl Term Dibuat'],
                        'pluginOptions' => [
                            'todayHighlight' => true,
                            'autoclose'=>true,
                              'format' => 'yyyy-m-dd'
                        ],
                        'pluginEvents'=>[
                            'show' => "function(e) {show}",
                        ],
                    ]);
        ?>

        <?php echo $form->field($model, 'PERIOD_END')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Tgl Term Berakhir'],
                        'pluginOptions' => [
                            'todayHighlight' => true,
                            'autoclose'=>true,
                              'format' => 'yyyy-m-dd'
                        ],
                        'pluginEvents'=>[
                            'show' => "function(e) {show}",
                        ],
                    ]);
        ?>

    <?= $form->field($model, 'BUDGET_AWAL')->widget(MaskMoney::classname(), [
        'pluginOptions' => [
            'allowNegative' => false
        ]
    ]) ?>

    <?php
      if(!$model->IsNewRecord)
      {
        	echo $form->field($model, 'STATUS')->dropDownList(['' => ' -- Silahkan Pilih --', '0' => 'Tidak Aktif', '1' => 'Aktif']);
      }

     ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
