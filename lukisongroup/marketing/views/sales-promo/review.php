<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;

	$aryStt= [
	  ['STATUS' => 0, 'STT_NM' => 'RUNNING'],		  
	  ['STATUS' => 1, 'STT_NM' => 'FINISH'],
	  ['STATUS' => 2, 'STT_NM' => 'PANDING'],
	  ['STATUS' => 3, 'STT_NM' => 'PLANING']
	];	
	$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');
	
	$drvAttributLeft=[
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
            'value'=>'<kbd>'.$model->CUST_NM.'</kbd>',
		],
		[
			'attribute' =>'TGL_START',
			'format'=>'raw',
			'type'=>DetailView::INPUT_DATE,
			'widgetOptions' => [
				'pluginOptions'=>Yii::$app->gv->gvPliginDate()
			],
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],
		[
			'attribute' =>'TGL_END',
			'format'=>'raw',
			'type'=>DetailView::INPUT_DATE,
			'widgetOptions' => [
				'pluginOptions'=>Yii::$app->gv->gvPliginDate()
			],
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],
		[
			'attribute' =>'STATUS',			
			'format'=>'raw',
			'value'=>$model->STATUS==0?'RUNNING':($model->STATUS==1?'FINISH':($model->STATUS==2?'PANDING':'PLANING')),
			'type'=>DetailView::INPUT_SELECT2,
			'widgetOptions'=>[
				'data'=>$valStt,//Yii::$app->gv->gvStatusArray(),
				'options'=>['id'=>'status-review-id','placeholder'=>'Select ...'],
				'pluginOptions'=>['allowClear'=>true],
			],	
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
		],
		[
			'attribute' =>'TGL_FINISH',
			'value'=>$model->TGL_FINISH!=''?"<kbd>".\Yii::$app->formatter->asDate($model->TGL_FINISH, 'Y-m-d')."</kbd>":"",
			'format'=>'raw',
			'type'=>DetailView::INPUT_DATE,
			'widgetOptions' => [
				'pluginOptions'=>Yii::$app->gv->gvPliginDate()
			],
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],
	];
	
	$drvAttributInfo=[
		[
			'attribute' =>'CREATED_BY',
			'displayOnly'=>true,	
			'format'=>'raw', 
            'value'=>'<kbd>'.$model->CREATED_BY.'</kbd>',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],
		[
			'attribute' =>'CREATED_AT',
			'displayOnly'=>true,
			'format'=>'raw', 
            'value'=>'<kbd>'.$model->CREATED_AT.'</kbd>',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],
		[
			'attribute' =>'UPDATED_BY',
			'displayOnly'=>true,
			'format'=>'raw', 
            'value'=>'<kbd>'.$model->UPDATED_BY.'</kbd>',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],[
			'attribute' =>'UPDATED_AT',
			'displayOnly'=>true,
			'format'=>'raw', 
            'value'=>'<kbd>'.$model->UPDATED_AT.'</kbd>',
			'type'=>DetailView::INPUT_TEXT,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%']
		],
		
	];
	
	$drvAttributRight=[
		[
			'attribute' =>'PROMO',
			'type'=>DetailView::INPUT_TEXTAREA,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
			'options'=>['rows'=>2]
		],
		[
			'attribute' =>'MEKANISME',
			'type'=>DetailView::INPUT_TEXTAREA,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
			'options'=>['rows'=>4]
		],
		[
			'attribute' =>'KOMPENSASI',
			'type'=>DetailView::INPUT_TEXTAREA,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
			'options'=>['rows'=>4]
		],
		[
			'attribute' =>'KETERANGAN',
			'type'=>DetailView::INPUT_TEXTAREA,
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
			'options'=>['rows'=>4]
		]			
	];
	
	$drvLeftCalendarPromo=DetailView::widget([
		'id'=>'dv-review-left',
		'model' => $model,
		'attributes'=>$drvAttributLeft,
		'condensed'=>true,
		'hover'=>true,
		'panel'=>[
			'heading'=>'			
					<span class="fa-stack fa-sm">
					 <i class="fa fa-circle fa-stack-2x" style="color:#635e5e"></i>
					  <i class="fa fa-thumb-tack fa-stack-1x" style="color:#ffffff"></i>
					</span> <b>Promotion Detail</b>				
			',
			'type'=>DetailView::TYPE_INFO,
		],
		'mode'=>DetailView::MODE_VIEW,
		'buttons1'=>'{update}',
		'buttons2'=>'{view}{save}',		
		'saveOptions'=>[ 
			'id' =>'editBtn1',
			'value'=>'/marketing/sales-promo/review?id='.$model->ID,
			'params' => ['custom_param' => true],
		],		
	]);
	
	$drvInfoCalendarPromo=DetailView::widget([
		'id'=>'dv-review-info',
		'model' => $model,
		'attributes'=>$drvAttributInfo,
		'condensed'=>true,
		'hover'=>true
	]);
	
	$drvRightCalendarPromo=DetailView::widget([
		'id'=>'dv-review-right',
		'model' => $model,
		'attributes'=>$drvAttributRight,
		'condensed'=>true,
		'hover'=>true,
		'panel'=>[
			'heading'=>'
				<span class="fa-stack fa-1">
					  <i class="fa fa-circle fa-stack-2x" style="color:#635e5e"></i>
					  <i class="fa fa-list-ul fa-stack-1x" style="color:#ffffff"></i>
				</span> <b>Discription Detail</b>
			',
			'type'=>DetailView::TYPE_INFO,
		],
		'mode'=>DetailView::MODE_VIEW,
		'buttons1'=>'{update}',
		'buttons2'=>'{view}{save}',		
		'saveOptions'=>[ 
			'id' =>'editBtn2',
			'value'=>'/marketing/sales-promo/review?id='.$model->ID,
			'params' => ['custom_param' => true],
		],		
	]);

		// DetailView::widget([
			// 'model' => $model,
			// 'attributes' => [
				// 'ID',
				// 'CUST_ID',
				// 'CUST_NM',
				// 'PROMO:ntext',
				// 'TGL_START',
				// 'TGL_END',
				// 'OVERDUE',
				// 'MEKANISME:ntext',
				// 'KOMPENSASI:ntext',
				// 'KETERANGAN:ntext',
				// 'STATUS',
				// 'CREATED_BY',
				// 'CREATED_AT',
				// 'UPDATED_BY',
				// 'UPDATED_AT',
			// ],
		// ]) 
	?>

<div style="height:100%;font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div class="row" >
		<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
			<?=$drvLeftCalendarPromo ?>
			<?=$drvInfoCalendarPromo ?>
		</div>
		<div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
			<?=$drvRightCalendarPromo ?>
		</div>
	</div>
</div>