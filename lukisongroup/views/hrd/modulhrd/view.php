<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use lukisongroup\models\hrd\Dept;
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
	$Dept_MDL = Dept::find()->where(['DEP_ID'=>$model->DEP_ID])->orderBy('SORT')->one();
	$Val_Jabatan=$Dept_MDL->DEP_NM;
	$attribute = [
		[
			'attribute' =>'DEP_ID',
			//'inputWidth'=>'20%'
		],	
		[
			'attribute' =>	'DEP_NM',
			//'inputWidth'=>'40%'					
		],
		[
			'attribute' =>	'DEP_DCRP',
			'format'=>'raw',
			//'value'=>'DEP_DCRP',
			'type'=>DetailView::INPUT_TEXTAREA, 
			'widgetOptions'=>[
				'data'=>'DEP_DCRP',
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
			'heading'=>$model->DEP_ID . '| '.$model->DEP_NM,
			'type'=>DetailView::TYPE_INFO,
		],	
		'attributes'=>$attribute,
	]);			
?>

