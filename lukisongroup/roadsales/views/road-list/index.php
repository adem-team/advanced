<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Json;
use yii\web\Request;
use kartik\daterange\DateRangePicker;
use kartik\tabs\TabsX;
use yii\widgets\ListView;
use yii\data\ArrayDataProvider;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\roadsales\models\SalesRoadListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->sideCorp = 'PT.Effembi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'sales_road';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - CASE LIST ROAD');          				/* title pada header page */
$this->params['breadcrumbs'][] = $this->title; 

/*
 * Tombol Create
 *  create 
*/
function tombolCreate(){
      $title1 = Yii::t('app', 'New Case');
      $url = Url::toRoute(['/roadsales/road-list/create']);
      $options1 = ['value'=>$url,
                    'id'=>'new-list-road',
                    'class'=>"btn btn-success btn-xs"  
      ];
      $icon1 = '<span class="fa fa-plus fa-lg"></span>';
      
      $label1 = $icon1 . ' ' . $title1;
      $content = Html::button($label1,$options1);
      return $content;
     }


  function tombolRefresh(){
      $title = Yii::t('app', 'Refresh');
      $url =  Url::toRoute(['/roadsales/road-list/']);
      $options = ['id'=>'road-list-id-refresh',
                  'data-pjax' => 0,
                  'class'=>"btn btn-info btn-xs",
                ];
      $icon = '<span class="fa fa-history fa-lg"></span>';
      $label = $icon . ' ' . $title;

      return $content = Html::a($label,$url,$options);
    }


	function tombolExport(){

		$title = Yii::t('app', 'Export');

		$url = Url::toRoute(['/roadsales/road-list/export-excel']);

		$options = ['id'=>'export-list-road',
	                 'class'=>"btn btn-info btn-xs",
	                 'data-pjax' => 0,
	                ];

	    $icon = '<span class="fa fa-download"></span>';

	    $label = $title. ' '.$icon;


	    $content = Html::a($label,$url,$options);

	    return $content;

	}

	 /*
   * Tombol View
  */
  function tombolView($url, $model){
        $title = Yii::t('app', 'View');
        $icon = '<span class="fa fa-eye"></span>';
        $label = $icon . ' ' . $title;
        $url = Url::toRoute(['/roadsales/road-list/view','id'=>$model->ID]);
        $options1 = ['value'=>$url,
                    'id'=>'view-road-list-id',
                    'class'=>"btn btn-default btn-xs",      
                    'style'=>['width'=>'170px', 'height'=>'25px','border'=> 'none','background-color'=>'white'],  
                ];
        $content = Html::button($label,$options1);
        return $content;
    }



 /*
   * Tombol Update
  */
  function tombolUpdate($url, $model){
        $title = Yii::t('app', 'Edit');
        $icon = '<span class="fa fa-edit"></span>';
        $label = $icon . ' ' . $title;
        $url = Url::toRoute(['/roadsales/road-list/edit','id'=>$model->ID]);
        $options1 = ['value'=>$url,
                    'id'=>'edit-road-id',
                    'class'=>"btn btn-default btn-xs",      
                    'style'=>['width'=>'170px', 'height'=>'25px','border'=>'none','background-color'=>'white'],  
                ];
        $content = Html::button($label,$options1);
        return $content;
    }

     



	/**
	* STATUS DISABLE/ENABLE
	*/
	function statusList($model){
		if($model['STATUS']==0){
			return Html::a('<i class="fa fa-remove"></i> Disable', '',['class'=>'btn btn-dangger btn-xs', 'style'=>['width'=>'70px','text-align'=>'left'],'title'=>'New']);
		}elseif($model['STATUS']==1){
			return Html::a('<i class="fa fa-check"></i> Enable ', '',['class'=>'btn btn-info btn-xs','style'=>['width'=>'70px','text-align'=>'left'], 'title'=>'Validate']);
		}
	};
	
	/**
	* COLUMN DATA.
	*/
	$columnList=[
		/*No Urut*/
		[
			'class'=>'kartik\grid\SerialColumn',
			'contentOptions'=>['class'=>'kartik-sheet-style'],
			'width'=>'10px',
			'header'=>'No.',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(221, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*CASE_NAME*/
		[
			'attribute'=>'CASE_NAME',
			'label'=>'CASE NAME',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'filter'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'300px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(221, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'300px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		/*CASE_DSCRIP*/
		[
			'attribute'=>'CASE_DSCRIP',
			'label'=>'DESCRIPTION',
			'hAlign'=>'left',
			'vAlign'=>'middle',
			//'group'=>true,
			'filter'=>true,
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'500px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(221, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'left',
					'width'=>'500px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
		[
			'attribute'=>'STATUS',
			'label'=>'Status',
			'mergeHeader'=>true,
			'format' => 'raw',
			'hAlign'=>'center',
			'value' => function ($model) {
				return statusList($model);
			},
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'70px',
					'font-family'=>'verdana, arial, sans-serif',
					'font-size'=>'7pt',
					'background-color'=>'rgba(221, 235, 29, 0.8)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'70px',
					'height'=>'10px',
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'7pt',
				]
			],
		],
	];


	
	
	
	/*
	 * GRIDVIEW ROAD LIST
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	$_gvRoadList= GridView::widget([
		'id'=>'gv-road-list',
		'dataProvider'=> $dataProvider,
		'filterModel' => $searchModel,
		'filterRowOptions'=>['style'=>'background-color:rgba(214, 255, 138, 1); align:center'],
		'columns' =>$columnList,		
		'pjax'=>true,
		'pjaxSettings'=>[
			'options'=>[
				'enablePushState'=>false,
				'id'=>'gv-road-list',
			   ],
		],
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
		'bordered'=>true,
		'striped'=>'4px',
		'autoXlFormat'=>true,
		'export' => false,
		'toolbar'=> [
				['content'=>tombolExport()],
				//'{export}',
				//'{toggleData}',
				
			],
		'panel'=>[
			'type'=>GridView::TYPE_INFO, //rgba(214, 255, 138, 1)
			'heading'=>"<span class='fa fa-list-ol fa-xs'><b> List Sales Road</b></span>",
			'type'=>'info',
			'before'=>tombolCreate().' '.tombolRefresh()
															
			//'footer'=>false,
		],
		'floatOverflowContainer'=>true,
		'floatHeader'=>true,
	]);
?>
<div class="content">
  <div  class="row" style="padding:10px;padding-left:3px ">
		<div class="col-xs-12 col-sm-12 col-lg-12" style="font-family: tahoma ;font-size: 9pt;">
			<?=$_gvRoadList?>
		</div>
	</div>
</div>

<?php


Modal::begin([    
         'id' => 'modal-road-list',   
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-plus"></div><div><h4 class="modal-title">'.Html::encode('Road').'</h4></div>', 
     // 'size' => Modal::SIZE_, 
         'headerOptions'=>[   
                 'style'=> 'border-radius:5px; background-color: rgba(90, 171, 255, 0.7)',    
         ],   
     ]);    
    echo "<div id='modalContentroadlist'></div>";
  Modal::end();

$this->registerJs("$.fn.modal.Constructor.prototype.enforceFocus = function(){};  
    $(document).on('click','#new-list-road', function(ehead){        
      $('#modal-road-list').modal('show')
      .find('#modalContentroadlist').html('<i class=\"fa fa-2x fa-spinner fa-spin\"></i>')
      .load(ehead.target.value);
    });",View::POS_READY);
