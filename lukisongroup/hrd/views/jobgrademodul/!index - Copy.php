<?php
use yii\helpers\Html;
use kartik\grid\GridView;

use lukisongroup\models\hrd\Jobgrade;
use lukisongroup\models\hrd\Groupseqmen;
use lukisongroup\models\hrd\Groupfunction;
use yii\helpers\ArrayHelper;

$this->sideCorp = 'Modul HRM';                            		/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_modul';                            		/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Modul JobGrade');     			/* title pada header page */

$Combo_GrpFnc = ArrayHelper::map(Groupfunction::find()->orderBy('SORT')->asArray()->all(), 'GF_NM','GF_NM');
$Combo_Seq = ArrayHelper::map(Groupseqmen::find()->orderBy('SEQ_NM')->asArray()->all(), 'SEQ_NM','SEQ_NM');
$Combo_Jab = ArrayHelper::map(Jobgrade::find()->orderBy('SORT')->asArray()->all(), 'JOBGRADE_NM','JOBGRADE_NM');
?>
<div class="jobgrademodul-index">

    <?php
		echo GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'columns' => [				
				[
					'class' => 'yii\grid\ActionColumn',
					'template' => '{view}',
					//'template' => '{view} {update}',
					//Yii::t('app', 'Emplo'),
				],	
				['class' => 'yii\grid\SerialColumn'],
				/*Author -ptr.nov- GROUP FINCTION */
				[				
					'label'=>'Group Function',
					'attribute' =>'groupfunction.GF_NM',
					'filter' => ArrayHelper::map(Groupfunction::find()->orderBy('SORT')->asArray()->all(), 'GF_NM','GF_NM'),
				],	
				/*Author -ptr.nov- GROUP SEQWEN */
				[				
					'label'=>'Group Sequen',
					'attribute' =>'groupseqmen.SEQ_NM',
					'filter' => ArrayHelper::map(Groupseqmen::find()->orderBy('SEQ_NM')->asArray()->all(), 'SEQ_NM','SEQ_NM'),
				],	
				/*Author -ptr.nov- GRADIND ID */
				[				
					'label'=>'Grading ID',
					'attribute' =>'JOBGRADE_ID',					
				],
				/*Author -ptr.nov- GRADING NAME*/
				[				
					'label'=>'Grading NM',
					'attribute' =>'JOBGRADE_NM',
				],
				/*Author -ptr.nov- GRADING NAME*/
				[				
					'label'=>'Description',
					'attribute' =>'JOBGRADE_DCRP',
				],				            
			],
			'panel'=>[
				//'heading' =>true,// $hdr,//<div class="col-lg-4"><h8>'. $hdr .'</h8></div>',
				'type' =>GridView::TYPE_SUCCESS,
				'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create {modelClass}',
						['modelClass' => 'Employe',]),
						['create'], ['class' => 'btn btn-success']),
			],
			'pjax'=>true,
			'pjaxSettings'=>[
				'options'=>[
					'enablePushState'=>false,
					'id'=>'active',
				],
			],
			'hover'=>true, //cursor select
			//'responsive'=>true,
			'responsiveWrap'=>true,
			'bordered'=>true,
			'striped'=>'4px',
			'autoXlFormat'=>true,
			'export'=>[//export like view grid --ptr.nov-
				'fontAwesome'=>true,
				'showConfirmAlert'=>false,
				'target'=>GridView::TARGET_BLANK
			],
		]); 
	?>

</div>
