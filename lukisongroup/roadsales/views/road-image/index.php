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
/* @var $searchModel lukisongroup\roadsales\models\SalesRoadImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->sideCorp = 'PT.Effembi Sukses Makmur';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'sales_road';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - SALES IMAGE ROAD');          				/* title pada header page */
$this->params['breadcrumbs'][] = $this->title; 
?>


<?php

/*
 * Tombol Create
 *  create 
*/
function tombolCreate(){
      $title1 = Yii::t('app', 'New Road Image');
      $url = Url::toRoute(['/roadsales/road-image/create']);
      $options1 = ['value'=>$url,
                    'id'=>'road-image-id-create',
                    'class'=>"btn btn-info btn-xs"  
      ];
      $icon1 = '<span class="fa fa-plus fa-lg"></span>';
      
      $label1 = $icon1 . ' ' . $title1;
      $content = Html::button($label1,$options1);
      return $content;
     }

function tombolRefresh(){
      $title = Yii::t('app', 'Refresh');
      $url =  Url::toRoute(['roadsales/road-image/']);
      $options = ['id'=>'road-image-id-refresh',
                  'data-pjax' => 0,
                  'class'=>"btn btn-info btn-xs",
                ];
      $icon = '<span class="fa fa-history fa-lg"></span>';
      $label = $icon . ' ' . $title;

      return $content = Html::a($label,$url,$options);
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
            'attribute'=>'judulRoad',
            'label'=>'Road Sales',
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
         [
            'attribute'=>'IMG_NAME',
            'label'=>'Image Name',
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
            'attribute'=>'IMGBASE64',
            'format'=>'raw',
            'value'=>function($model){
                return Html::img($model->IMGBASE64,['width'=>'120','height'=>'120']);
            },
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
    $_gvRoadimage= GridView::widget([
        'id'=>'gv-road-image-list',
        'dataProvider'=> $dataProvider,
        'filterModel' => $searchModel,
        'filterRowOptions'=>['style'=>'background-color:rgba(214, 255, 138, 1); align:center'],
        'columns' =>$columnList,        
        'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'gv-road-image-list',
               ],
        ],
        'hover'=>true, //cursor select
        'responsive'=>true,
        'responsiveWrap'=>true,
        'bordered'=>true,
        'striped'=>'4px',
        'autoXlFormat'=>true,
        'export' => false,
        'toolbar'=>['',
                //'{export}',
                //'{toggleData}',
                
            ],
        'panel'=>[
            'type'=>GridView::TYPE_INFO, //rgba(214, 255, 138, 1)
            'heading'=>"<span class='fa fa-list-ol fa-xs'><b> List Sales Road Image</b></span>",
            'type'=>'info',
            'before'=>tombolCreate().' '.tombolRefresh()
                                                            
            //'footer'=>false,
        ],
        'floatOverflowContainer'=>true,
        'floatHeader'=>true,
    ]);

    Modal::begin([    
         'id' => 'modal-road-image',   
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-plus"></div><div><h4 class="modal-title">'.Html::encode('Road Image').'</h4></div>', 
     // 'size' => Modal::SIZE_, 
         'headerOptions'=>[   
                 'style'=> 'border-radius:5px; background-color: rgba(90, 171, 255, 0.7)',    
         ],   
     ]);    
    echo "<div id='modalContentroadimage'></div>";
     Modal::end();
?>

<div class="sales-road-image-index">

    
   <?= $_gvRoadimage ?>
  
</div

<?php


$this->registerJs("$.fn.modal.Constructor.prototype.enforceFocus = function(){};  
    $(document).on('click','#road-image-id-create', function(ehead){        
      $('#modal-road-image').modal('show')
      .find('#modalContentroadimage')
      .load(ehead.target.value);
    });
  ",View::POS_READY);

?>
