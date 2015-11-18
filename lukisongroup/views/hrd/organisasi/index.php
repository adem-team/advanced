<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Json;
use kartik\tabs\TabsX;
use lukisongroup\assets\AppAssetOrg1; 		/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
AppAssetOrg1::register($this);	

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\models\hrd\OrganisasiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->sideCorp = 'Modul HRM';                                   		/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_modul';                                      	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'HRM - Organization');  
?>


  
<?php

$tabcrud = \kartik\grid\GridView::widget([
  'dataProvider' => $dataProvider,
  'filterModel' => $searchModel,
   'columns'=>[
       ['class'=>'yii\grid\SerialColumn'],
       
            'parent',
            'title',
            'description',
            'phone',
         [
				
               'attribute' => 'image',
               'format' => 'html',
               'value'=>function($data){
                            return Html::img(Yii::$app->urlManager->baseUrl.'/upload/hrd/orgimage/' . $data->image, ['width'=>'100']);
                        },
            ],  
   
     [ 'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}',
                        'header'=>'Action',
                        'buttons' => [
                            'view' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px">View </button>',
                                                                ['view','id'=>$model->id],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#org",
                                                                'data-title'=> $model->title,
                                                                ]);
                            },
                               
                             'update' =>function($url, $model, $key){
                                    return  Html::a('<button type="button" class="btn btn-primary btn-xs" style="width:50px ">Update </button>',
                                                                ['update','id'=>$model->id],[
                                                                'data-toggle'=>"modal",
                                                                'data-target'=>"#org1",
                                                                'data-title'=> $model->title,
                                                                ]);
                            },
                              
                ],
            ],
                                    ],
	 
			
        

    
    'panel'=>[
          
            'type' =>GridView::TYPE_SUCCESS,//TYPE_WARNING, //TYPE_DANGER, 
                                         //GridView::TYPE_SUCCESS,//GridView::TYPE_INFO, //TYPE_PRIMARY, TYPE_INFO
            //'after'=> Html::a('<i class="glyphicon glyphicon-plus"></i> Add', '#', ['class'=>'btn btn-success']) . ' ' .
                //Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Save', ['class'=>'btn btn-primary']) . ' ' .
            //    Html::a('<i class="glyphicon glyphicon-remove"></i> Delete  ', '#', ['class'=>'btn btn-danger'])
			/*
			'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create {modelClass}',
					['modelClass' => 'Employe',]),
					['create'], ['class' => 'btn btn-success']),
			*/
			'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
						['modelClass' => 'organisasi',]),'/hrd/organisasi/create',
                                                                [   'data-toggle'=>"modal",
                                                                    'data-target'=>"#org1",
                                                                    'class' => 'btn btn-success'
															
									])
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'active',
                //'formSelector'=>'ddd1',
                //'options'=>[
                //    'id'=>'active'
               // ],
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
        ],

    ],
       // 'floatHeaderOptions' => ['scrollingTop' => $scrollingTop],
       // 'containerOptions' => ['style' => 'overflow: auto'],
    //'persistResize'=>true,
        //'responsiveWrap'=>true,
        //'floatHeaderOptions'=>['scrollContainer'=>'25'],

    ]);


    
    
    

function encodeURIComponent($str) {
        $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
        return strtr(rawurlencode($str), $revert);
}
	
//print_r($dataProvider->getModels());
//echo  \yii\helpers\Json::encode($dataProvider->getModels());
$itemJsonStr = encodeURIComponent(Json::encode($dataProvider->getModels()));
$itemJsonStr2 = Json::encode($dataProvider->getModels());


$diagram = '<div class="content-wrapper">
<div style="padding: 0; margin: 0; font-size:12px">	
	<div class="content-wrapper" id="orgdiagram" style="position: absolute; overflow: hidden; left: 0px; padding: 0px; margin: 0px; border-style: solid; border-color: navy; border-width: 1px;"></div>
</div>
</div>	';

//$this->registerJs('Print("var data=\"" . $itemJsonStr . "\";");');
//echo $itemJsonStr2;
//echo $itemJsonStr;
$items=[
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Tambah struktur organisasi','content'=>$tabcrud,
			//'active'=>true,

		],
		
		[
			'label'=>'<i class="glyphicon glyphicon-home"></i> Chart','content'=>$diagram,//$tab_profile,
		],
    ];

echo TabsX::widget([
		'id'=>'tab-org',
		'items'=>$items,
		'position'=>TabsX::POS_ABOVE,
		//'height'=>'tab-height-xs',
		'bordered'=>true,
		'encodeLabels'=>false,
		//'align'=>TabsX::ALIGN_LEFT,

	]);

 $this->registerJs("			
		    $('#org').on('show.bs.modal', function (event) {
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
		    'id' => 'org',
		    'header' => '<h4 class="modal-title">LukisonGroup</h4>',
		]);
		Modal::end();
                
$this->registerJs("
                    $.fn.modal.Constructor.prototype.enforceFocus = function(){};
		    $('#org1').on('show.bs.modal', function (event) {
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
		    'id' => 'org1',
		    'header' => '<h4 class="modal-title">LukisonGroup</h4>',
		]);
		Modal::end();
                
$this->registerJs("
                 
		    $('#organ1').on('show.bs.modal', function (event) {
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
		    'id' => 'organ1',
		    'header' => '<h4 class="modal-title">LukisonGroup</h4>',
		]);
		Modal::end();


$this->registerJs('
		
		(function($) {
			var m_timer = null;
			var datax=\'' . $itemJsonStr . '\';	
			$(document).ready(function () {
				$.ajaxSetup({
					cache: false
				});
				ResizePlaceholder();
				orgDiagram = $("#orgdiagram").orgDiagram({
					//graphicsType: primitives.common.GraphicsType.SVG,
					pageFitMode: primitives.common.PageFitMode.FitToPage,
					verticalAlignment: primitives.common.VerticalAlignmentType.Middle,
					connectorType: primitives.common.ConnectorType.Angular,
					minimalVisibility: primitives.common.Visibility.Dot,
					selectionPathMode: primitives.common.SelectionPathMode.FullStack,
					leavesPlacementType: primitives.common.ChildrenPlacementType.Horizontal,
					hasButtons: primitives.common.Enabled.False,
					hasSelectorCheckbox: primitives.common.Enabled.False,				
					itemTitleFirstFontColor: primitives.common.Colors.White,
					itemTitleSecondFontColor: primitives.common.Colors.White
				});

				
				//Mengunakan Data Yii dataProvider Author -ptr.nov-
				var items = JSON.parse(decodeURIComponent(datax));
				items[0].templateName = "contactTemplate";
				orgDiagram.orgDiagram({
							items: items,
							cursorItem: 2
						});
				orgDiagram.orgDiagram("update");
				
				
				/* 
				//Mengunakan data Ajax Author -ptr.nov-
				$.ajax({
					url: \'http://localhost/orgchart1/phpservice.php\',
					dataType: \'text\',
					success: function(text) {
						var items = JSON.parse(decodeURIComponent(text));
						//var items = JSON.parse(\'data1\');
						items[0].templateName = "contactTemplate";
						orgDiagram.orgDiagram({
							items: items,
							cursorItem: 2
						});
						orgDiagram.orgDiagram("update");
					}
				});
				*/
			});


			function ResizePlaceholder() {
				var bodyWidth = $(window).width() - 40
				var bodyHeight = $(window).height() - (-65) //height 
				var titleHeight = 93;
				
				$("#orgdiagram").css(
				{
					"left": "230px",
					"width": (bodyWidth - 193) + "px",
					"height": (bodyHeight - titleHeight) + "px",
					"top": titleHeight + "px"
				});
			}
		})(jQuery);
',$this::POS_HEAD);

?>

</div>
