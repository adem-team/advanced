<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use lukisongroup\models\hrd\Corp;
use lukisongroup\models\hrd\Dept;
use lukisongroup\models\hrd\Status;
use lukisongroup\models\hrd\Deptsub;
use lukisongroup\models\hrd\Groupfunction;
use lukisongroup\models\hrd\Groupseqmen;
use lukisongroup\models\hrd\Jobgrade;

use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveField;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\icons\Icon;
use kartik\widgets\Growl;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use kartik\widgets\DepDrop;

$this->sideCorp = 'HRM - Data Employee';                   		/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_personalia';                           	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Personalia - Detail & Edit Employee');   /* title pada header page */

?>


<?php	
	$Corp_MDL = Corp::find()->where(['CORP_ID'=>$model->EMP_CORP_ID])->orderBy('SORT')->one();
	$Dept_MDL = Dept::find()->where(['DEP_ID'=>$model->DEP_ID])->orderBy('SORT')->one();
	$DeptSub_MDL = Deptsub::find()->where(['DEP_SUB_ID'=>$model->DEP_SUB_ID])->orderBy('SORT')->one();
	$Gf_MDL = Groupfunction::find()->where(['GF_ID'=>$model->GF_ID])->orderBy('SORT')->one();
	$GSeqmen_MDL = Groupseqmen::find()->where(['SEQ_ID'=>$model->SEQ_ID])->one();
	$Jabatan_MDL = Jobgrade::find()->where(['JOBGRADE_ID'=>$model->JOBGRADE_ID])->orderBy('SORT')->one();
	$Status_MDL = Status::find()->where(['STS_ID'=>$model->EMP_STS])->orderBy('SORT')->one();
	
	/*COORPORATE*/
	if (count($Corp_MDL)==0){
		$Val_Corp='none';
	}else{
		$Val_Corp=$Corp_MDL->CORP_NM;
	}
	
	/*DEPARTMENT*/
	if (count($Dept_MDL)==0){
		$Val_Dept='none';
	}else{
		$Val_Dept=$Dept_MDL->DEP_NM;
	}
	
	/*DEPARTMENT-SUB*/
	if (count($DeptSub_MDL)==0){
		$Val_DeptSub='none';
	}else{
		$Val_DeptSub=$DeptSub_MDL->DEP_SUB_NM;
	}
	
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
	if (count($Jabatan_MDL)==0){
		$Val_Jabatan='none';
	}else{
		$Val_Jabatan=$Jabatan_MDL->JOBGRADE_NM;
	}
	
	/*STATUS*/
	if (count($Status_MDL)==0){
		$Val_Status='none';
	}else{
		$Val_Status=$Status_MDL->STS_NM;
	}
    /*ADDITIONAL SELECTED DEPDOWN VALUE HTML FOR JS -Auth ptr.nov*/
	echo Html::hiddenInput('selected-subdept',$model->DEP_SUB_ID, ['id'=>'selected-subdept']);
	echo Html::hiddenInput('selected-grading',$model->JOBGRADE_ID, ['id'=>'selected-grading']);
	$attribute = [
		[
			'group'=>true,
			'label'=>'Employee Identification',
			'rowOptions'=>['class'=>'info'],
			//'groupOptions'=>['class'=>'text-center']
		],
		[
			'attribute' =>	'upload_file' ,
			'label'=>'',
			//'value'=>('<img src =' . Yii::getAlias('@HRD_EMP_UploadUrl') .'/'. $model->EMP_IMG. ' height="100" width="100"' . '>' )
			'value'=>Yii::getAlias('@HRD_EMP_UploadUrl') .'/'.$model->EMP_IMG,
			'format'=>['image',['width'=>'100','height'=>'120']],
			//'format'=>'raw', 
			'type' => DetailView::INPUT_FILEINPUT,
			'widgetOptions'=>[
						'pluginOptions' => [
							'showPreview' => true,
							'showCaption' => false,
							'showRemove' => false,
							'showUpload' => false
						],
					
			],
			//'inputContainer' => ['class'=>'col-md-2'],
			//'format' => 'html', //'format' => 'image',
			//'value'=>function($data){
			//			return Html::img(Yii::getAlias('HRD_EMP_UploadUrl') . '/'. $data->EMP_IMG, ['width'=>'40']);
			//		},
		],
		[
			'attribute' =>'EMP_ID',
			'options'=>['readonly'=>true,],
			//'inputWidth'=>'20%'
			//'inputContainer' => ['class'=>'col-md-1'],
		],	
		[
			'attribute' =>	'EMP_NM',
			//'inputWidth'=>'40%'					
		],
		[
			'attribute' =>	'EMP_NM_BLK',
			//'inputWidth'=>'40%'
		],
		
		/* SUB INPUT*/
		[
			'group'=>true,
			'label'=>'Coorporate Information',
			'rowOptions'=>['class'=>'info'],
			//'groupOptions'=>['class'=>'text-center']
		],
		// COORPORATE - Author: -ptr.nov-
		[ 			
			'label'=>'Coorporate',
			'attribute' =>'EMP_CORP_ID',
			'format'=>'raw',
			'value'=>Html::a($Val_Corp, '#', ['class'=>'kv-author-link']),
			'type'=>DetailView::INPUT_SELECT2, 
			'widgetOptions'=>[
				'data'=> ArrayHelper::map(Corp::find()->orderBy('SORT')->asArray()->all(), 'CORP_ID','CORP_NM'),
				'options'=>['placeholder'=>'Select ...'],
				'pluginOptions'=>['allowClear'=>true],
			],
		],
		// DEPARTMENT - Author: -ptr.nov-
		[
			'label'=>'Department',
			'attribute' =>'DEP_ID',
			'format'=>'raw',
			'value'=>Html::a($Val_Dept, '#', ['class'=>'kv-author-link']),			
			'type'=>DetailView::INPUT_SELECT2,
			 'widgetOptions'=>[
					'data'=>ArrayHelper::map(Dept::find()->orderBy('SORT')->asArray()->all(), 'DEP_ID','DEP_NM'),
					'options' => [ 'id'=>'dept-id',],
							
			],
		],
		// SUB DEPARTMENT - Author: -ptr.nov-
		[
			'label'=>'Department Sub',
			'attribute' =>'DEP_SUB_ID',
			'format'=>'raw',
			'value'=>Html::a($Val_DeptSub, '#', ['class'=>'kv-author-link']),
			'type'=>DetailView::INPUT_DEPDROP,	
			'widgetOptions' => [
				'options'=>['id'=>'subdept-id'],//,'readonly'=>true,'selected'=>false], //PR VISIBLE DROP DOWN
				'pluginOptions'=>[
					'depends'=>['dept-id'],
					//'placeholder'=>'Select...',
					'url'=>Url::to(['/hrd/employe/subdept']),
					'initialize'=>true, //loding First //
					//'initDepends'=>$model->DEP_SUB_ID,
					//'placeholder' => false, //disable select //
					'params'=>['selected-subdept'],
					'loadingText' => 'Sub Department ...',
				],

			],
		],
		// GROUP FUNCTION - Author: -ptr.nov-		
		[ 
			'label'=>'Group Function',
			'attribute' =>'GF_ID',
			'format'=>'raw',
			'value'=>Html::a($Val_GF, '#', ['class'=>'kv-author-link']),
			'type'=>DetailView::INPUT_SELECT2, 
			'widgetOptions'=>[
				'data'=> ArrayHelper::map(Groupfunction::find()->orderBy('SORT')->asArray()->all(), 'GF_ID','GF_NM'),
				'options' => [ 'id'=>'Groupfnc-id'],
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
				'options' => [ 'id'=>'Groupseq-id'],
			],			
		],			
		// JOBGRADE - Author: -ptr.nov-
		[
			'label'=>'Grading',
			'attribute' =>'JOBGRADE_ID',
			'format'=>'raw',
			'value'=>Html::a($Val_Jabatan, '#', ['class'=>'kv-author-link']),
			'type'=>DetailView::INPUT_DEPDROP, 
			'widgetOptions'=>[
				'options'=>['id'=>'grading-id'],
				//'data'=>ArrayHelper::map(Jobgrade::find()->orderBy('SORT')->asArray()->all(), 'JOBGRADE_ID','JOBGRADE_NM'),
				//'options'=>['placeholder'=>'Select ...'],
				//'pluginOptions'=>['allowClear'=>true],
				'pluginOptions'=>[
					'depends'=>['Groupfnc-id','Groupseq-id'],					
					'url'=>Url::to(['/hrd/employe/grading']),
					'initialize'=>true, //loding First //
					//'initDepends'=>$model->DEP_SUB_ID,
					//'placeholder' => false, //disable select //
					'params'=>['selected-grading'],
					'loadingText' => 'Sub Department ...',
				],
			],
			//'inputContainer' => ['class'=>'col-sm-3'],
			//'inputWidth'=>'40%'
		],	
		// STATUS - Author: -ptr.nov-
		[
			'attribute' =>'EMP_STS',
			'format'=>'raw',
			'value'=>Html::a($Val_Status, '#', ['class'=>'kv-author-link']),
			'type'=>DetailView::INPUT_SELECT2, 
			'widgetOptions'=>[
				'data'=>ArrayHelper::map(Status::find()->orderBy('SORT')->asArray()->all(), 'STS_ID','STS_NM'),
				'options'=>['placeholder'=>'Select ...'],
				'pluginOptions'=>['allowClear'=>true],
			],
			//'inputContainer' => ['class'=>'col-sm-3'],
			//'inputWidth'=>'40%'
			
		],
		[
			'attribute' =>'EMP_JOIN_DATE',
			'format'=>'date',
			'type'=>DetailView::INPUT_DATE,
			'widgetOptions'=>[
				'pluginOptions'=>['format'=>'yyyy-mm-dd']
			],
			//'inputContainer' => ['class'=>'col-sm-3'],
			//'inputWidth'=>'40%'
		],
		[
			'attribute' =>'EMP_RESIGN_DATE',
			'format'=>'date',
			'type'=>DetailView::INPUT_DATE,
			'widgetOptions'=>[
				'pluginOptions'=>['format'=>'yyyy-mm-dd']
			],
			//'inputWidth'=>'40%'
		//	'inputContainer' => ['class'=>'col-sm-3'],
		],
		
		/* SUB INPUT*/
		[
			'group'=>true,
			'label'=>'Employee Data Information',
			'rowOptions'=>['class'=>'info'],
			//'groupOptions'=>['class'=>'text-center']
		],
		
		//Employe Profile - Author: -ptr.nov-
		[
			'attribute' =>	'EMP_KTP' ,
		],
		[	
			'attribute' =>	'EMP_ALAMAT',
		],
		[
			'attribute' =>	'EMP_ZIP',
		],
		[
			'attribute' =>	'EMP_TLP',
		],
		[
			'attribute' =>	'EMP_HP' ,
		],
		[
			'attribute' =>	'EMP_GENDER',
		],
		[
			'attribute' =>	'EMP_TGL_LAHIR',
			'format'=>'date',
			'type'=>DetailView::INPUT_DATE,
			'widgetOptions'=>[
				'pluginOptions'=>['format'=>'yyyy-mm-dd']
			],
			'inputWidth'=>'40%'
		],
		[
			'attribute' =>	'EMP_EMAIL' ,
		],
		/*
		[
			'attribute' =>	'GRP_NM',
		],
		*/
		
	];
?>
<div class="container">
	<div class="col-sm-2"></div>
	<div class="col-sm-7">
	<?php
		$form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL,'options'=>['enctype'=>'multipart/form-data']]);
			echo DetailView::widget([
				'model' => $model,
				'condensed'=>true,
				'hover'=>true,
				'mode'=>DetailView::MODE_VIEW,
				'panel'=>[
					'heading'=>'#' . $model->EMP_NM . ' '.$model->EMP_NM_BLK,
					'type'=>DetailView::TYPE_INFO,
				],	
				
					'attributes'=>$attribute,
				
				
				'deleteOptions'=>[
					'url'=>['delete', 'id' => $model->EMP_ID],
					'data'=>[
						'confirm'=>Yii::t('app', 'Are you sure you want to delete this record?'),
						'method'=>'post',
					],
				],		
			]);		
		ActiveForm::end();	
	?>
	</div>
</div>
	

