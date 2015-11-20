<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use lukisongroup\models\hrd\Jabatan;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveField;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\icons\Icon;
use kartik\widgets\Growl;

$this->sideMenu = 'hrd_employee';
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Maxiprodaks'), 'url' => ['prodak']];
//$this->params['breadcrumbs'][] = $this->title;
?>

<?php	
	$Jabatan_MDL = Jabatan::find()->where(['JAB_ID'=>$model->JAB_ID])->orderBy('SORT')->one();
	$Val_Jabatan=$Jabatan_MDL->JAB_NM;
	$attribute = [
		[
			'attribute' =>'JAB_ID',
			//'inputWidth'=>'20%'
		],	
		[
			'attribute' =>	'JAB_NM',
			//'inputWidth'=>'40%'					
		],
		[
			'attribute' =>	'JAB_DCRP',
			'format'=>'raw',
			//'value'=>'JAB_DCRP',
			'type'=>DetailView::INPUT_TEXTAREA, 
			'widgetOptions'=>[
				'data'=>'JAB_DCRP',
				'options'=>['placeholder'=>'Position Description ...'],
				'pluginOptions'=>['allowClear'=>true],
			],
		],
		[
			'attribute' =>	'SORT',
			//'inputWidth'=>'40%'
		],			
	];
	echo DetailView::widget([
		'model' => $model,
		
		'condensed'=>true,
		'hover'=>true,
		'mode'=>DetailView::MODE_VIEW,
		'panel'=>[
			'heading'=>$model->JAB_ID . '| '.$model->JAB_NM,
			'type'=>DetailView::TYPE_INFO,
		],	
		'attributes'=>$attribute,
	]);			
?>
	

