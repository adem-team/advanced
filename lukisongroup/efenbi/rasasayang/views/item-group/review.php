<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use kartik\widgets\ActiveField;
use kartik\widgets\ActiveForm;
use lukisongroup\efenbi\rasasayang\models\ItemFormula;
	$aryStt= [
	  ['STATUS' => 0, 'STT_NM' => 'Disable'],		  
	  ['STATUS' => 1, 'STT_NM' => 'Enable']
	];	
	$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');
	$aryFormula	 = ArrayHelper::map(ItemFormula::find()->where(['OUTLET_BARCODE' =>  $model['OUTLET_ID']])->all(), 'FORMULA_ID', 'FORMULA_NM');
	// print_r($aryFormula);
	// die();
	$attributeItemGrpupReview=[
		//STORE - INFO.
		[
			'group'=>true,
			'label'=>'OUTLET INFO',
			'rowOptions'=>['class'=>'info'],
			//'groupOptions'=>['class'=>'text-center']
		],		
		//STORE - STORE NAME.
		[
			'attribute' =>'StoreNm',
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
			'displayOnly'=>true,	
			'format'=>'raw', 
		],
		//STORE - STORE LOCATE.
		[
			'attribute' =>'LocateNm',
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
			'displayOnly'=>true,	
			'format'=>'raw', 
		],
		//STORE - STORE LOCATE SUB.
		[
			'attribute' =>'LocatesubNm',
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
			'displayOnly'=>true,	
			'format'=>'raw', 
		],	
		//ITEM - INFO.
		[
			'group'=>true,
			'label'=>'ITEMS INFO',
			'rowOptions'=>['class'=>'info'],
			//'groupOptions'=>['class'=>'text-center']
		],	
		//ITEM - NAME.
		[
			'attribute' =>'ItemNm',
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
			'displayOnly'=>true,	
			'format'=>'raw', 
		],	
		[
			'attribute' =>'Gambar',
			'label'=>false,
			'displayOnly'=>true,
			'value'=> Html::img($model->Gambar),
			'format'=>['raw',['width'=>'100','height'=>'120']],
			
		],	
		//HARGA - INFO.
		[
			'group'=>true,
			'label'=>'ITEMS PRICE',
			'rowOptions'=>['class'=>'info'],
			//'groupOptions'=>['class'=>'text-center']
		],
		//HARGA - HPP.
		[
			'attribute' =>'HPP',
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
			'displayOnly'=>false,	
			'format'=>'raw', 
		],	
		//HARGA - PERCENT MARGIN.
		[
			'attribute' =>'PERSEN_MARGIN',
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
			'displayOnly'=>false,	
			'format'=>'raw', 
		],	
		//STORE - INFO.
		[
			'group'=>true,
			'label'=>'SETTING FORMULA',
			'rowOptions'=>['class'=>'info'],
			//'groupOptions'=>['class'=>'text-center']
		],	
		//FORMULA - PERCENT MARGIN.
		[
			'attribute' =>'FORMULA_ID',
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
			'displayOnly'=>false,	
			'format'=>'raw', 
			'type'=>DetailView::INPUT_SELECT2,
			'widgetOptions'=>[
				'data'=>$aryFormula,
				'options'=>['id'=>'rebiew-formula-id','placeholder'=>'Select ...'],
				'pluginOptions'=>['allowClear'=>true],
			],	
		],	
		//FORMULA - NAME.
		[
			'attribute' =>'FomulaHeaderNm',
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
			'displayOnly'=>true,	
			'format'=>'raw', 
		],	
		//FORMULA - DISCRIPTION.
		[
			'attribute' =>'FomulaHeaderDcrip',
			'labelColOptions' => ['style' => 'text-align:right;width: 30%'],
			'displayOnly'=>true,	
			'format'=>'raw', 
		],			
	];
	
	$dvItemsGroupReview=DetailView::widget([
		'id'=>'dv-items-group-review',
		'model' => $model,
		'attributes'=>$attributeItemGrpupReview,
		'condensed'=>true,
		'hover'=>true,
		'panel'=>[
			'heading'=>'<b>EDITING</b>',
			// 'heading'=>'
				// <span class="fa-stack fa-1">
					  // <i class="fa fa-circle fa-stack-2x" style="color:#635e5e"></i>
					  // <i class="fa fa-list-ul fa-stack-1x" style="color:#ffffff"></i>
				// </span> <b>Discription Detail</b>
			// ',
			'type'=>DetailView::TYPE_INFO,
		],
		'mode'=>DetailView::MODE_VIEW,
		'buttons1'=>'{update}',
		'buttons2'=>'{view}{save}',		
		'saveOptions'=>[ 
			'id' =>'itemgroup-review',
			'value'=>'/efenbi-rasasayang/item-group/review?id='.$model->ID,
			'params' => ['custom_param' => true],
		],	
	]);
	
	
?>
<div style="height:100%;font-family: verdana, arial, sans-serif ;font-size: 8pt">
	<div class="row" >
		
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="row" style="height:100%;font-family: verdana, arial, sans-serif ;font-size: 8pt">
			<?=$dvItemsGroupReview?>
		</div>
		</div>
		<div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
			<?=$dvItems ?>
		</div>
	</div>
</div>




   
    <?php
	
	// DetailView::widget([
        // 'model' => $model,
        // 'attributes' => [
		////Store
		// 'OUTLET_ID',
		// 'StoreNm',
		// 'LocateNm',
		// 'LocatesubNm',          
		///Items.
		  // 'ITEM_ID',
		  // 'ITEM_BARCODE',
            // 'CREATE_BY',
            // 'CREATE_AT',
            // 'UPDATE_BY',
            // 'UPDATE_AT',
            // 'STATUS',
            // 'LOCATE',
            // 'LOCATE_SUB',
            // 'OUTLET_ID',
            // 'ITEM_ID',
            // 'ITEM_BARCODE',
            // 'PERSEN_MARGIN',
        // ],
    // ]) 
	
	?>
