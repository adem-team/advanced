<?php
/*
 * By ptr.nov
 * Load Config CSS/JS
 */
/* YII CLASS */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use kartik\builder\Form;
use kartik\sidenav\SideNav;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;

//use lukisongroup\models\system\side_menu\M1000;

/*	KARTIK WIDGET -> Penambahan componen dari yii2 dan nampak lebih cantik*/

//use kartik\date\DatePicker;


//use backend\assets\AppAsset; 	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
//AppAsset::register($this);		/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/

/*Title page Modul*/
$this->sideCorp = 'HRM - Data Employee';                   	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_personalia';                           /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Personalia - List Data Employee');  /* title pada header page */


//--EMPLOYE ACTIVED--
$tab_employe= GridView::widget([
        'id'=>'active',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],	
        'columns' => $dinamkkColumn1,		
        'panel'=>[
            //'heading' =>true,// $hdr,//<div class="col-lg-4"><h8>'. $hdr .'</h8></div>',
            'type' =>GridView::TYPE_SUCCESS,
          	'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
						['modelClass' => 'Employe',]),'/hrd/employe/create',[
															'data-toggle'=>"modal",
															'data-target'=>"#activity-emp",
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
        'responsive'=>true,
        'responsiveWrap'=>true,
        'bordered'=>true,
        'striped'=>'4px',
        'autoXlFormat'=>true,
        'export'=>[//export like view grid --ptr.nov-
            'fontAwesome'=>true,
            'showConfirmAlert'=>false,
            'target'=>GridView::TARGET_BLANK
        ]
    ]);

//---EMPLOYE RESIGN --
$tab_employe_resign= GridView::widget([
    'id'=>'resign',
    'dataProvider' => $dataProvider1,
    'filterModel' => $searchModel1,
    'columns' =>$dinamkkColumn2,
    'panel'=>[
        //'heading' =>true,// $hdr,//<div class="col-lg-4"><h8>'. $hdr .'</h8></div>',
        'type' =>GridView::TYPE_SUCCESS,//TYPE_WARNING, //TYPE_DANGER, //GridView::TYPE_SUCCESS,//GridView::TYPE_INFO, //TYPE_PRIMARY, TYPE_INFO
        //'after'=> Html::a('<i class="glyphicon glyphicon-plus"></i> Add', '#', ['class'=>'btn btn-success']) . ' ' .
        //Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class'=>'btn btn-primary']) . ' ' .
        //    Html::a('<i class="glyphicon glyphicon-remove"></i> Delete  ', '#', ['class'=>'btn btn-danger'])
		/*
        'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create {modelClass}',
                    ['modelClass' => 'Employe',]),
                ['create'], ['class' => 'btn btn-success']),
		*/
    ],
    'pjax'=>true,
    'pjaxSettings'=>[
        'options'=>[
            'enablePushState'=>false,
            'id'=>'resign',
            //'formSelector'=>'ddd',
            //'options'=>[
            //    'id'=>'resign'
            //],
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
    // 'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
    // 'containerOptions' => ['style' => 'overflow: auto'],
    //'persistResize'=>true,
    //'responsiveWrap'=>true,
    //'floatHeaderOptions'=>['scrollContainer'=>'25'],

]);

?>

<?php
	/* echo Breadcrumbs::widget([
				'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			]);
	*/
	$items=[
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Employe Active','content'=>$tab_employe,
			//'active'=>true,
		],
		
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Employe Resign','content'=>$tab_employe_resign,//$tab_profile,
		],
	];
	
	echo TabsX::widget([
		'id'=>'tab-emp',
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		//'height'=>'tab-height-xs',
		'bordered'=>true,
		'encodeLabels'=>false,
		//'align'=>TabsX::ALIGN_LEFT,

	]);
	 
	$this->registerJs("	
		$.fn.modal.Constructor.prototype.enforceFocus = function(){};	 
		$('#activity-emp').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var modal = $(this)
			var title = button.data('title') 
			var href = button.attr('href') 
			modal.find('.modal-title').html(title)
			modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
			$.post(href)
				.done(function( data ) {						
					modal.find('.modal-body').html(data)					
				});		
			 
		})				
		//$(#activity-emp).datepicker('disable');
	",$this::POS_READY);
	Modal::begin([
		'id' => 'activity-emp',
		'header' => '<h4 class="modal-title">LukisonGroup</h4>',
	]);
	Modal::end();
	
	/*
	 * EDIT EMPLOYEE IEDNTITY
	 * @author ptrnov [ptr.nov@gmail.com]
	 * @since 1.2
	 */
	$this->registerJs("
		 $.fn.modal.Constructor.prototype.enforceFocus = function(){};
		 $('#edit-identity').on('show.bs.modal', function (event) {
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
    Modal::begin([
        'id' => 'edit-identity',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">EMPLOYEE IDENTIFICATION</h4></div>',
		'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
		],
    ]);
    Modal::end();
	
		/*ViewDelate
		$this->registerJs("
		$.fn.modal.Constructor.prototype.enforceFocus = function(){};
		    $('#view-emp').on('show.bs.modal', function (event) {
		        var button = $(event.relatedTarget)
		        var modal = $(this)
		        var title = button.data('title') 				
		        var href = button.attr('href') 
		        modal.find('.modal-title').html(title)
		        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
				$.post(href)
		            .done(function( data ) {
		                modal.find('.modal-body').html(data)
												
					});						
		    });
			//$(this).datepicker();
			//$('#my_datepicker').datepicker('destroy')
			
		",$this::POS_READY);
		
		$js='$("#view-emp").modal("show")';
		$this->registerJs($js);
		
		Modal::begin([
		    'id' => 'view-emp',
		    'header' => '<h4 class="modal-title">LukisonGroup</h4>',
		]);
		
		Modal::end();
*/
			
?>

