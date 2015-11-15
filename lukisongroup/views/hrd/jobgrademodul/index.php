<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\detail\DetailView;
use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use lukisongroup\models\hrd\Jobgrade;
use lukisongroup\models\hrd\Groupseqmen;
use lukisongroup\models\hrd\Groupfunction;
use yii\helpers\ArrayHelper;
use kartik\editable\Editable;
use yii\widgets\Pjax;

$this->sideCorp = 'Modul HRM';                            		/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_modul';                            		/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Modul JobGrade');     			/* title pada header page */

$Combo_GrpFnc = ArrayHelper::map(Groupfunction::find()->orderBy('SORT')->asArray()->all(), 'GF_NM','GF_NM');
$Combo_Seq = ArrayHelper::map(Groupseqmen::find()->orderBy('SEQ_NM')->asArray()->all(), 'SEQ_NM','SEQ_NM');
$Combo_Jab = ArrayHelper::map(Jobgrade::find()->orderBy('SORT')->asArray()->all(), 'JOBGRADE_NM','JOBGRADE_NM');

?>
<div class="jobgrademodul-index">
	<?php //Pjax::begin(['id'=>'pjax-users']); ?>
    <?php
		echo GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'columns' => [
				/*
				[					
					'class' => 'yii\grid\ActionColumn', 
					'template' => '{view} {delete}',
					'headerOptions' => ['width' => '20%', 'class' => 'activity-view-link',],        
					//'headerOptions' => ['width' => '20%', 'class' =>"$('.activity-view-link').click(function() {var elementId = $(this).closest('tr').data('key')}",],        
						'contentOptions' => ['class' => 'padding-left-5px'],

					'buttons' => [
						'view' => function ($url, $model, $key) {
							//return Html::a('<button type="button" class="btn btn-primary btn-xs">View</button>','jobgrademodul/view?id=1', [
							return Html::a('<button type="button" class="btn btn-primary btn-xs">View</button>',$url, [
							//return Html::a('<button type="button" class="btn btn-primary btn-xs">View</button>','jobgrademodul/create', [
								'id' => 'activity-view-link',
								//'class' => 'activity-view-link',
								//'class' =>'$(.activity-view-link).click(function() {var elementId = $(this).closest(tr).data(key)}',
								'title' => Yii::t('yii', 'View'),
								'data-toggle' => 'modal',
								'data-target' => '#activity-model-gradingmdl',
								//'data-id' => $key,
								//'data-pjax' => '1',
							]);
						},
					],					
				],
				*/
				['class' => 'yii\grid\SerialColumn'],
				/*Author -ptr.nov- GROUP SEQWEN */
				[				
					'label'=>'Group Seqmen',
					'attribute' =>'groupseqmen.SEQ_NM',
					'filter' => ArrayHelper::map(Groupseqmen::find()->orderBy('SEQ_NM')->asArray()->all(), 'SEQ_NM','SEQ_NM'),
				],			
				/*Author -ptr.nov- GROUP FINCTION */
				[				
					'label'=>'Group Function',
					'attribute' =>'groupfunction.GF_NM',
					'filter' => ArrayHelper::map(Groupfunction::find()->orderBy('SORT')->asArray()->all(), 'GF_NM','GF_NM'),
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
				[   
					'class' => 'yii\grid\ActionColumn', 
					'template' => '{view} {edit}',
					'header'=>'Action',
					'buttons' => [
						'view' =>function($url, $model, $key){
								return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:35px">View </button>',['view','id'=>$model->ID],[
															'data-toggle'=>"modal",
															'data-target'=>"#activity-model-gradingmdl",
															'data-title'=> $model->ID,
															]);
						},
						/*
						'edit' =>function($url, $model, $key){
								return  Html::a('<button type="button" class="btn btn-success btn-xs" style="width:35px">EDIT</button>',['viewedit','id'=>$model->ID],[
															'data-toggle'=>"modal",
															'data-target'=>"#activity-model-gradingmdl",
															'data-title'=> $model->ID,
															]);
						}
						*/
					],	
				],
			],
			'panel'=>[
				//'heading' =>true,// $hdr,//<div class="col-lg-4"><h8>'. $hdr .'</h8></div>',
				'type' =>GridView::TYPE_SUCCESS,
				/*
				'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create {modelClass}',
						['modelClass' => 'Employe',]),
						['create'], ['class' => 'btn btn-success']),
						[
				*/
				/*Create Controller renderAjax*/
				/* harus path /hrd/jobgrademodul/create' -> index case error*/
				'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
						['modelClass' => 'Employe',]),'/hrd/jobgrademodul/create',[  
															'data-toggle'=>"modal",
															'data-target'=>"#activity-model-gradingmdl",
															'class' => 'btn btn-success'
															])
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
		 //Pjax::end(); 
		 
		 $this->registerJs("
		    $('#activity-model-gradingmdl').on('show.bs.modal', function (event) {
		        var button = $(event.relatedTarget)
		        var modal = $(this)
		        var title = button.data('title') 
		        var href = button.attr('href') 
		        //modal.find('.modal-title').html(title)
		        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
		        $.post(href)
		            .done(function( data ) {
		                modal.find('.modal-body').html(data)
		            });
		        })
		",$this::POS_READY);
		//,$this::POS_END);
		/*
		//$this->registerJs("
		 //   $(#activity-model-gradingmdl);
		//");//,$this::POS_END);
		*/
			
		/*
			$(".activity-view-link").click(function() {
					$.get(
						.../view // Add missing part of link here        
						{
							id: $(this).closest('tr').data('key')
						},
						function (data) {
							$('.modal-body').html(data);
							$('#activity-model-gradingmdl').modal();
						}  
					);
				})
			");
		*/		
		
		Modal::begin([
		    'id' => 'activity-model-gradingmdl',
		    'header' => '<h4 class="modal-title">LukisonGroup</h4>',
		]);
		Modal::end();
		
	?>

</div>
