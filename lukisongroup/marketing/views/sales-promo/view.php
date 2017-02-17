<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;


	$dvAttributLeft=[
		[
			'attribute' =>'CUST_ID',
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
			'displayOnly'=>true,	
			'format'=>'raw', 
            'value'=>'<kbd>'.$model->CUST_ID.'</kbd>',
		],
		[
			'attribute' =>'CUST_NM',
			'type'=>DetailView::INPUT_TEXTAREA,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
			'displayOnly'=>true,	
			'format'=>'raw', 
            //'value'=>'<kbd>'.$model->CUST_NM.'</kbd>',
		],
		[
			'attribute' =>'TGL_START',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],
		[
			'attribute' =>'TGL_END',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],
		[
			'attribute' =>'STATUS',
			'type'=>DetailView::INPUT_TEXT,
			'value'=>$model->STATUS==0?'RUNNING':($model->STATUS==1?'FINISH':($model->STATUS==2?'PANDING':'PLANING')),
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
			
		],
		[
			'attribute' =>'TGL_FINISH',
			'format'=>'raw',
			'type'=>DetailView::INPUT_TEXT,
			'value'=>$model->TGL_FINISH!=''?"<kbd>".\Yii::$app->formatter->asDate($model->TGL_FINISH, 'Y-m-d')."</kbd>":"",			
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],
	];
	
	$dvAttributInfo=[
		[
			'attribute' =>'CREATED_BY',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],
		[
			'attribute' =>'CREATED_AT',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],
		[
			'attribute' =>'UPDATED_BY',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],[
			'attribute' =>'UPDATED_AT',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],
		
	];
	
	$dvAttributRight=[
		[
			'attribute' =>'PROMO',
			'type'=>DetailView::INPUT_TEXTAREA,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],
		[
			'attribute' =>'MEKANISME',
			'type'=>DetailView::INPUT_TEXTAREA,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],
		[
			'attribute' =>'KOMPENSASI',
			'type'=>DetailView::INPUT_TEXTAREA,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],
		[
			'attribute' =>'KETERANGAN',
			'type'=>DetailView::INPUT_TEXTAREA,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		]			
	];
	
	$dvLeftCalendarPromo=DetailView::widget([
		'id'=>'dv-view-left',
		'model' => $model,
		'attributes'=>$dvAttributLeft,
		'condensed'=>true,
		'hover'=>true,
		'panel'=>[
			'heading'=>'			
					<span class="fa-stack fa-sm">
					 <i class="fa fa-circle fa-stack-2x" style="color:#635e5e"></i>
					  <i class="fa fa-thumb-tack fa-stack-1x" style="color:#ffffff"></i>
					</span> <b>Promotion Detail</b>				
			',
			'type'=>DetailView::TYPE_DEFAULT,
		],
		'mode'=>DetailView::MODE_VIEW,
		'buttons1'=>'',	
	]);
	
	$dvInfoCalendarPromo=DetailView::widget([
		'id'=>'dv-view-info',
		'model' => $model,
		'attributes'=>$dvAttributInfo,
		'condensed'=>true,
		'hover'=>true,
		'buttons1'=>'',	
	]);
	
	$dvRightCalendarPromo=DetailView::widget([
		'id'=>'dv-view-right',
		'model' => $model,
		'attributes'=>$dvAttributRight,
		'condensed'=>true,
		'hover'=>true,
		'panel'=>[
			'heading'=>'
				<span class="fa-stack fa-1">
					  <i class="fa fa-circle fa-stack-2x" style="color:#635e5e"></i>
					  <i class="fa fa-list-ul fa-stack-1x" style="color:#ffffff"></i>
				</span> <b>Discription Detail</b>
			',
			'type'=>DetailView::TYPE_DEFAULT,
		],
		'buttons1'=>'',	
	]);
?>

<div style="height:100%;font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div class="row" >
		<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
			<?=$dvLeftCalendarPromo ?>
			<?=$dvInfoCalendarPromo ?>
		</div>
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
			<?=$dvRightCalendarPromo ?>
		</div>
	</div>
</div>