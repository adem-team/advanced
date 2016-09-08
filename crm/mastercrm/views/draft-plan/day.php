<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftPlan */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Draft Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draft-plan-view">


<?php
   /*info*/
    $cusviewinfo=DetailView::widget([
        'model' => $view_info,
        'attributes' => [
            [
                'attribute' =>'CUST_NM',
                'label'=>'Customer.NM',
                'labelColOptions' => ['style' => 'text-align:right;width: 30%']
            ],
            [
                'attribute' =>'SCDL_GROUP',
                'value'=>$view_info->custgrp->SCDL_GROUP_NM, 
                'label'=>'Schedule Group',
                'labelColOptions' => ['style' => 'text-align:right;width: 30%']
            ],
            
        ],
    ]);

    $layer_viewinfo=DetailView::widget([
        'model' => $view_info,
        'attributes' => [
            [
                'attribute' =>'CUST_NM',
                'label'=>'Customer.NM',
                'labelColOptions' => ['style' => 'text-align:right;width: 30%']
            ],
            [
                'attribute' =>'LAYER',
                'value'=>$view_info->custlayer->LAYER, 
                'label'=>'Layer',
                'labelColOptions' => ['style' => 'text-align:right;width: 30%']
            ],
            
        ],
    ]);

    ?>
    <div class="row">
        <div class="col-sm-6">
        <?= $cusviewinfo ?>
        </div>
          <div class="col-sm-6">
          <?= $layer_viewinfo ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            
			<?php $form = ActiveForm::begin([
				'id'=>$model->formName()
			
			]); ?>
			<?php //=$form->field($model, 'displyGeoId')->hiddenInput(['value'=>$model->GEO_ID,'id'=>'draftplan-displygeoid'])->label(false); ?>
		</div>
		<div class="col-sm-12">	
			<div class="row">
				<div class="col-sm-6">	
					<?php //=$form->field($model, 'displyGeoNm')->textInput(['value' => $model->geoNm .' - '. $model->GeoDcrip,'readonly' => true])->label('CUSTOMER GROUP'); ?>
				</div>
				<div class="col-sm-6">
					<?php //= $form->field($model, 'GEO_SUB')->widget(DepDrop::classname(), [
						// 'type'=>DepDrop::TYPE_SELECT2,
						// 'options'=>['placeholder'=>'Select ...'],
						// 'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
						// 'pluginOptions'=>[
							// 'depends'=>['draftplan-displygeoid'],
							 // 'initialize' => true,
							  // 'loadingText' => 'Loading  ...',
							// 'url' => Url::to(['/master/draft-plan/lis-geo-sub']),
						// ]
					// ])->label('AREA GROUP') 
					?>
				</div>
			</div>
		</div>	
		<div class="col-sm-12">		
			
			
			<?= $form->field($model_day, 'OPT')->widget(Select2::classname(), [
					'data' => $opt,
					'options' => ['placeholder' => 'Pilih ...'],
					'pluginOptions' => [
						'allowClear' => true
						 ],
				])->label('Options Jeda Pekan');
			?>

			<?= $form->field($model, 'DAY_ID')->widget(DepDrop::classname(), [
					'type'=>DepDrop::TYPE_SELECT2,
					'options'=>['placeholder'=>'Select ...'],
					'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
					'pluginOptions'=>[
						'depends'=>['dayname-opt'],
						 'initialize' => true,
						  'loadingText' => 'Loading  ...',
						'url' => Url::to(['/mastercrm/draft-plan/lisday']),
					]
				])->label('Setel Hari') 
			?>

		   <!--   $form->field($model, 'DAY_ID')->widget(Select2::classname(), [
					// 'data' => $opt,
					'options' => ['placeholder' => 'Pilih ...'],
					'pluginOptions' => [
						'allowClear' => true,

						 ],
				]);?> -->
		

			
				<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	

			<?php ActiveForm::end(); ?>
		</div>

    </div>

</div>
<?php
/** *js getting table values using ajax
    *@author adityia@lukison.com

**/
// $this->registerJs("
// $('#dayname-opt').on('change',function(e){
// e.preventDefault();
// var idx = $(this).val();
//    $.ajax({   
//         url: '/master/draft-plan/lisday',
//         dataType: 'json',
//         type: 'GET',
//         data:{opt:idx},
//         success: function (data, textStatus, jqXHR) {            $('#draftplan-day_id').html(data);
//         },
//     });
  
// })
// // bootstrap-duallistbox-nonselected-list_Customers[CUST_GRP][]
// ",$this::POS_READY);
