<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;
use kartik\widgets\ActiveForm;
use lukisongroup\models\hrd\Groupfunction;
use lukisongroup\models\hrd\Groupseqmen;
use lukisongroup\models\hrd\Jobgrade;

$this->sideCorp = 'Modul HRM';                            		/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_modul';                            		/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Detail View Modul JobGrade');     /* title pada header page */

	$Gf_MDL = Groupfunction::find()->where(['GF_ID'=>$model->GF_ID])->orderBy('SORT')->one();
	$GSeqmen_MDL = Groupseqmen::find()->where(['SEQ_ID'=>$model->SEQ_ID])->one();
	$Grading_MDL = Jobgrade::find()->where(['JOBGRADE_ID'=>$model->JOBGRADE_ID])->orderBy('SORT')->one();
	/*GROUP-FUNCTION*/
	if (count($Gf_MDL)==0){
		$Val_GF='none';
	}else{
		$Val_GF=$Gf_MDL->GF_NM;
	}
	
	/*GROUP-SEQUEN*/
	if (count($GSeqmen_MDL)==0){
		$Val_SQMEN='none';
	}else{
		$Val_SQMEN=$GSeqmen_MDL->SEQ_NM;
	}
	
	/*JOBGRADE*/
	if (count($Grading_MDL)==0){
		$Val_GRADING='none';
	}else{
		$Val_GRADING=$Grading_MDL->JOBGRADE_NM;
	}
?>

<?php
$attribute = [
		// GROUP FUNCTION - Author: -ptr.nov-		
		[ 
			'label'=>'Group Function',
			'attribute' =>'GF_ID',
			'format'=>'raw',
			'value'=>Html::a($Val_GF, '#', ['class'=>'kv-author-link']),
			'type'=>DetailView::INPUT_SELECT2, 
			'widgetOptions'=>[
				'data'=> ArrayHelper::map(Groupfunction::find()->orderBy('SORT')->asArray()->all(), 'GF_ID','GF_NM'),
				'options' => [ 'id'=>'groupfnc-id'],
			],			
		],	
		// GROUP SEQMEN - Author: -ptr.nov-
		[
			'label'=>'Group Seqmen',
			'attribute' =>'SEQ_ID',
			'format'=>'raw',
			'value'=>Html::a($Val_SQMEN, '#', ['class'=>'kv-author-link']),
			'type'=>DetailView::INPUT_SELECT2, 
			'widgetOptions'=>[
				'data'=> ArrayHelper::map(Groupseqmen::find()->orderBy('SEQ_NM')->asArray()->all(), 'SEQ_ID','SEQ_NM'),
				'options' => [ 'id'=>'groupseq-id'],
			],			
		],			
		// JOBGRADE - Author: -ptr.nov-
		[
			'label'=>'JobGrading',
			'attribute' =>'JOBGRADE_ID',
			'format'=>'raw',
			'value'=>Html::a($Val_GRADING, '#', ['class'=>'kv-author-link']),
			'type'=>DetailView::INPUT_SELECT2, 
			'widgetOptions'=>[
				'data'=>ArrayHelper::map(Jobgrade::find()->orderBy('SORT')->asArray()->all(), 'JOBGRADE_ID','JOBGRADE_NM'),
				'options' => [ 'id'=>'Grading-id'],
			],			
		],			
		//SORT - Author: -ptr.nov-
		[
			'attribute' =>	'SORT',
			//'options'=>['readonly'=>true,],
			/*Important -> Recursive modul*/
		],
		//DESCRIPTION - Author: -ptr.nov-		
		[
			'attribute' =>	'JOBGRADE_DCRP',
			'type'=>DetailView::INPUT_TEXTAREA,
		],
		[
			'attribute' =>	'CREATED_BY',
			'options'=>['readonly'=>true,],
		],
		[
			'attribute' =>	'UPDATED_BY',
			'options'=>['readonly'=>true,],
		],	
		[
			'attribute' =>	'UPDATED_TIME',
			'options'=>['readonly'=>true,],
		],		
	];
?>


		<?php
			$form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]);
				echo DetailView::widget([
					'model' => $model,
					//'pjax'=>true,
					'condensed'=>true,
					'hover'=>true,
					'mode'=>DetailView::MODE_EDIT,
					'panel'=>[
						'heading'=>'FORMULA MODUL GRADING',
						'type'=>DetailView::TYPE_INFO,
					],	
					
						'attributes'=>$attribute,
					
					
					'deleteOptions'=>[
						'url'=>['deletestt', 'id' => $model->ID],
						'data'=>[
							'confirm'=>Yii::t('app', 'Are you sure you want to delete this record?'),
							'method'=>'post',
						],
					],										
				]);		
			ActiveForm::end();	
		?>

