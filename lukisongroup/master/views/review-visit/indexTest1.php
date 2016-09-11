<?php
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use kartik\daterange\DateRangePicker;
use yii\db\ActiveRecord;
use yii\data\ArrayDataProvider;

		$dataModel=$dataProvider->getModels();
		//print_r($dataModel);
		$dataColumn = ArrayHelper::getColumn($dataModel, 'SO_QTY','NM_BARANG');
		$dataColumn =array_column($dataModel, 'SO_QTY','NM_BARANG');
		//print_r($dataColumn);
		$dataMap =  ArrayHelper::map($dataModel, 'NM_BARANG','SO_QTY','CUST_NM');
		$dataMap1 =  ArrayHelper::map($dataModel, 'SO_QTY', 'CUST_NM', 'CUST_ID');
		
		
		echo '</br></br>';
		$dataIndex =  ArrayHelper::index($dataModel, 'CUST_NM');
		//print_r($dataIndex);
		
		$dataToArray =  ArrayHelper::toArray($dataColumn);
		//print_r($dataToArray);

		$dataMapMerge= ArrayHelper::merge($dataIndex,$dataMap);
		print_r($dataMapMerge);
		$dataProvider1= new ArrayDataProvider([
			'allModels'=>$dataMapMerge,//$dataIndex,//$dataProvider->getModels(),//
			'pagination' => [
				'pageSize' => 200,
			]
		]);		
		
		
		
		
		
		
		
		
		
$gvTest1= GridView::widget([
		'id'=>'gv-test1',
        'dataProvider' => $dataProvider1,
		// 'columns' =>[
			// 'attribute'=>'CUST_NM',
		// ],
        'pjax'=>true,
		'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-test1',
		   ],
		],
		'summary'=>false,
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
    ]);
?>
<?=$gvTest1?>