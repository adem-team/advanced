<?php

use kartik\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\Request;
use yii\db\ActiveRecord;
use lukisongroup\master\models\SopSalesHeaderSearch;
use lukisongroup\master\models\SopSalesDetailSearch;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\SopSalesHeaderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'Sop Sales Headers';
// $this->params['breadcrumbs'][] = $this->title;


$this->sideMenu = 'esm_customers'; 
?>



<?php


    /*
 * Tombol Create
 * permission create term
*/
function detailtombol($model){
            $title1 = Yii::t('app', 'create Detail');
            $options1 = [ 'id'=>'sop-detail-create',
                            'data-toggle'=>"modal",
                            'data-target'=>"#new-sop-detail",
                            'class' => 'btn btn-success btn-sm',
            ];
            $icon1 = '<span class="fa fa-plus fa-lg"></span>';
            $url = Url::toRoute(['/master/sop-sales/create-detail-sop','id'=>$model]);
            $label1 = $icon1 . ' ' . $title1;
            $content = Html::a($label1,$url,$options1);
            return $content;
         }



/*
 * Tombol Create
 * permission create term
*/
function tombolCreate(){
            $title1 = Yii::t('app', 'create');
            $options1 = [ 'id'=>'sop-header-create',
                            'data-toggle'=>"modal",
                            'data-target'=>"#new-sop",
                            'class' => 'btn btn-success btn-sm',
            ];
            $icon1 = '<span class="fa fa-plus fa-lg"></span>';
            $url = Url::toRoute(['/master/sop-sales/create']);
            $label1 = $icon1 . ' ' . $title1;
            $content = Html::a($label1,$url,$options1);
            return $content;
         }



/*DISCRIPTION STATUS*/
    function status($model){
        if($model->STT_DEFAULT == 0){
            return Html::a('<i class="glyphicon glyphicon-retweet"></i> Non Aktif', '#',['class'=>'btn btn-warning btn-xs', 'style'=>['width'=>'100px'],'title'=>'Detail']);
        }elseif ($model->STT_DEFAULT==1){
            return Html::a('<i class="glyphicon glyphicon-ok"></i> Aktif', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
        }else{
            return Html::a('<i class="glyphicon glyphicon-question-sign"></i> Unknown', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
        };
    }





/*
     * GRID VIEW PLAN TREM
     * @author ptrnov  [piter@lukison.com]
     * @since 1.2
    */
    $attDinamik =[];
    /*GRIDVIEW ARRAY FIELD HEAD*/
    $headColomnEvent=[
        ['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '50px','label'=>'Tanggal','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>true,'filterwarna'=>'126, 189, 188, 0.9']],
        ['ID' =>1, 'ATTR' =>['FIELD'=>'sopNm','SIZE' => '10px','label'=>'Keterangan','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],
        ['ID' =>2, 'ATTR' =>['FIELD'=>'KATEGORI','SIZE' => '10px','label'=>'Customers Kategori','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],
        ['ID' =>3, 'ATTR' =>['FIELD'=>'TARGET_MONTH','SIZE' => '10px','label'=>'Target Bulanan','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],
        ['ID' =>4, 'ATTR' =>['FIELD'=>'TARGET_DAY','SIZE' => '10px','label'=>'Target Perhari','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],
        ['ID' =>5, 'ATTR' =>['FIELD'=>'TTL_DAYS','SIZE' => '10px','label'=>'Total Hari','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],
        ['ID' =>6, 'ATTR' =>['FIELD'=>'TARGET_UNIT','SIZE' => '10px','label'=>'Target Perunit','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],
         ['ID' =>7, 'ATTR' =>['FIELD'=>'BOBOT_PERCENT','SIZE' => '10px','label'=>'Nilai','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],
        //['ID' =>4, 'ATTR' =>['FIELD'=>'STATUS','SIZE' => '10px','label'=>'STATUS','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
    ];
    $gvHeadColomn = ArrayHelper::map($headColomnEvent, 'ID', 'ATTR');
    /*GRIDVIEW SERIAL ROWS*/


    /*GRIDVIEW EXPAND*/
    $attDinamik[]=[
        'class'=>'kartik\grid\ExpandRowColumn',
        'width'=>'50px',
        'header'=>'Detail',
        'expandOneOnly'=>true,
        'detailRowCssClass'=>GridView::TYPE_DEFAULT,
        'value'=>function ($model, $key, $index, $column) {
            return GridView::ROW_COLLAPSED;
        },
        'detail'=>function($model, $key, $index, $column){

        $searchModel_detail = new SopSalesDetailSearch(['SOP_ID'=>$model->ID]);
        $dataProvider_detail = $searchModel_detail->search(Yii::$app->request->queryParams);

            /*render*/
        return Yii::$app->controller->renderPartial('_sop_expanddetail',[
                'searchModel_detail'=>$searchModel_detail,
                'dataProvider_detail'=>$dataProvider_detail, //actual_detail
                'detail_id'=>$model->ID
               
            ]);

        },
        'headerOptions'=>[
            'style'=>[
                'text-align'=>'center',
                'width'=>'10px',
                'font-family'=>'tahoma, arial, sans-serif',
                'font-size'=>'9pt',
                'background-color'=>'rgba(74, 206, 231, 1)',
            ]
        ],
        'contentOptions'=>[
            'style'=>[
                'text-align'=>'center',
                'width'=>'10px',
                'height'=>'10px',
                'font-family'=>'tahoma, arial, sans-serif',
                'font-size'=>'9pt',
                'background-color'=>'rgba(231, 183, 108, 0.2)',
            ]
        ],
    ];

    $attDinamik[] =[
        'class'=>'kartik\grid\SerialColumn',
        //'contentOptions'=>['class'=>'kartik-sheet-style'],
        'width'=>'10px',
        'header'=>'No.',
        'headerOptions'=>[
            'style'=>[
                'text-align'=>'center',
                'width'=>'10px',
                'font-family'=>'verdana, arial, sans-serif',
                'font-size'=>'9pt',
                'background-color'=>'rgba(249,215,100,1)',
            ]
        ],
        'contentOptions'=>[
            'style'=>[
                'text-align'=>'center',
                'width'=>'10px',
                'font-family'=>'tahoma, arial, sans-serif',
                'font-size'=>'9pt',
            ]
        ],
    ];


    /*GRIDVIEW ARRAY ROWS*/
    foreach($gvHeadColomn as $key =>$value[]){
        if($value[$key]['FIELD'] == 'TGL')
        {
            $attDinamik[]=[
            'class'=>'kartik\grid\EditableColumn',
            'attribute'=>$value[$key]['FIELD'],
            'refreshGrid'=>true,
            'label'=>$value[$key]['label'],
            'filterType'=>GridView::FILTER_DATE,
            'filter'=>$value[$key]['filter'],
            'filterWidgetOptions'=>[
                'pluginOptions' => [
                        'autoclose'=>true,
                    'format' => 'yyyy-mm-dd'
                    ],
            ],
            'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
            'hAlign'=>'right',
            'vAlign'=>'middle',
            //'mergeHeader'=>true,
            'noWrap'=>true,
            'group'=>$value[$key]['GRP'],
            // 'format'=>$value[$key]['FORMAT'],
            'editableOptions' => [
                                'header' => 'Update TGL',
                                'inputType' => \kartik\editable\Editable::INPUT_DATE,
                                'size' => 'sm',
                                'options' => [
                                    'pluginOptions' => ['todayHighlight' => true,
                                    'autoclose'=>true,
                                    'format' => 'yyyy-m-dd']
                                ]
                            ],
            'headerOptions'=>[
                    'style'=>[
                    'text-align'=>'center',
                    'width'=>$value[$key]['FIELD'],
                    'font-family'=>'tahoma, arial, sans-serif',
                    'font-size'=>'8pt',
                    //'background-color'=>'rgba(74, 206, 231, 1)',
                    'background-color'=>'rgba('.$value[$key]['warna'].')',
                ]
            ],
            'contentOptions'=>[
                'style'=>[
                    'text-align'=>$value[$key]['align'],
                    'font-family'=>'tahoma, arial, sans-serif',
                    'font-size'=>'8pt',
                    //'background-color'=>'rgba(13, 127, 3, 0.1)',
                ]
            ],
        ];
        }elseif($value[$key]['FIELD'] == 'KATEGORI'){
        $attDinamik[]=[
            'attribute'=>$value[$key]['FIELD'],
            'label'=>$value[$key]['label'],
            'filterType'=>GridView::FILTER_SELECT2,
            'filter' =>$child,
            'filterWidgetOptions'=>[
              'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Pilih'],
            'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
            'hAlign'=>'right',
            'vAlign'=>'middle',
            //'mergeHeader'=>true,
            'noWrap'=>true,
            'group'=>$value[$key]['GRP'],
            'format'=>$value[$key]['FORMAT'],
            'headerOptions'=>[
                    'style'=>[
                    'text-align'=>'center',
                    'width'=>$value[$key]['FIELD'],
                    'font-family'=>'tahoma, arial, sans-serif',
                    'font-size'=>'8pt',
                    //'background-color'=>'rgba(74, 206, 231, 1)',
                    'background-color'=>'rgba('.$value[$key]['warna'].')',
                ]
            ],
            'contentOptions'=>[
                'style'=>[
                    'text-align'=>$value[$key]['align'],
                    'font-family'=>'tahoma, arial, sans-serif',
                    'font-size'=>'8pt',
                    //'background-color'=>'rgba(13, 127, 3, 0.1)',
                ]
            ],
        ];

        }elseif($value[$key]['FIELD'] == 'sopNm'){

        $attDinamik[]=[
            'attribute'=>$value[$key]['FIELD'],
            'label'=>$value[$key]['label'],
            'filterType'=>GridView::FILTER_SELECT2,
            'filter' =>$typesales,
            'filterWidgetOptions'=>[
              'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Pilih'],
            'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
            'hAlign'=>'right',
            'vAlign'=>'middle',
            //'mergeHeader'=>true,
            'noWrap'=>true,
            'group'=>$value[$key]['GRP'],
            'format'=>$value[$key]['FORMAT'],
            'headerOptions'=>[
                    'style'=>[
                    'text-align'=>'center',
                    'width'=>$value[$key]['FIELD'],
                    'font-family'=>'tahoma, arial, sans-serif',
                    'font-size'=>'8pt',
                    //'background-color'=>'rgba(74, 206, 231, 1)',
                    'background-color'=>'rgba('.$value[$key]['warna'].')',
                ]
            ],
            'contentOptions'=>[
                'style'=>[
                    'text-align'=>$value[$key]['align'],
                    'font-family'=>'tahoma, arial, sans-serif',
                    'font-size'=>'8pt',
                    //'background-color'=>'rgba(13, 127, 3, 0.1)',
                ]
            ],
        ];

        }elseif($value[$key]['FIELD'] == 'TARGET_UNIT'){
        $attDinamik[]=[
            'class'=>'kartik\grid\EditableColumn',
            'attribute'=>$value[$key]['FIELD'],
            'label'=>$value[$key]['label'],
            'filterType'=>GridView::FILTER_SELECT2,
            'filter' =>$unit,
            'filterWidgetOptions'=>[
              'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Pilih'],
            'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
            'hAlign'=>'right',
            'vAlign'=>'middle',
            //'mergeHeader'=>true,
            'noWrap'=>true,
            'group'=>$value[$key]['GRP'],
            'format'=>$value[$key]['FORMAT'],
            'headerOptions'=>[
                    'style'=>[
                    'text-align'=>'center',
                    'width'=>$value[$key]['FIELD'],
                    'font-family'=>'tahoma, arial, sans-serif',
                    'font-size'=>'8pt',
                    //'background-color'=>'rgba(74, 206, 231, 1)',
                    'background-color'=>'rgba('.$value[$key]['warna'].')',
                ]
            ],
            'contentOptions'=>[
                'style'=>[
                    'text-align'=>$value[$key]['align'],
                    'font-family'=>'tahoma, arial, sans-serif',
                    'font-size'=>'8pt',
                    //'background-color'=>'rgba(13, 127, 3, 0.1)',
                ]
            ],
             'editableOptions' => [
            'header' => 'Unit',
            'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
            'size' => 'xs',
            'options' => [
              'data' =>$unit,
              'pluginOptions' => [
                'allowClear' => true
              ],
        ],
        
        //Refresh Display
        // 'displayValueConfig' => ArrayHelper::map(Customers::find()->where('STATUS<>3')->all(), 'CUST_KD', 'CUST_KD'),
      ],
        ];

        }elseif($value[$key]['FIELD'] == 'TTL_DAYS'){
        $attDinamik[]=[
         'class'=>'kartik\grid\EditableColumn',
            'attribute'=>$value[$key]['FIELD'],
            'label'=>$value[$key]['label'],
            'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
            'hAlign'=>'right',
            'vAlign'=>'middle',
            //'mergeHeader'=>true,
            'noWrap'=>true,
            'group'=>$value[$key]['GRP'],
            'format'=>$value[$key]['FORMAT'],
               'editableOptions' => [
            'header' => 'sales',
            'inputType' => \kartik\editable\Editable::INPUT_RANGE,
            'size' => 'xs'
        
        //Refresh Display
        // 'displayValueConfig' => ArrayHelper::map(Customers::find()->where('STATUS<>3')->all(), 'CUST_KD', 'CUST_KD'),
      ],
            'headerOptions'=>[
                    'style'=>[
                    'text-align'=>'center',
                    'width'=>$value[$key]['FIELD'],
                    'font-family'=>'tahoma, arial, sans-serif',
                    'font-size'=>'8pt',
                    //'background-color'=>'rgba(74, 206, 231, 1)',
                    'background-color'=>'rgba('.$value[$key]['warna'].')',
                ]
            ],
            'contentOptions'=>[
                'style'=>[
                    'text-align'=>$value[$key]['align'],
                    'font-family'=>'tahoma, arial, sans-serif',
                    'font-size'=>'8pt',
                    //'background-color'=>'rgba(13, 127, 3, 0.1)',
                ]
            ],
         
        ];

        }elseif($value[$key]['FIELD'] == 'TARGET_DAY'){
        $attDinamik[]=[
         'class'=>'kartik\grid\EditableColumn',
            'attribute'=>$value[$key]['FIELD'],
            'label'=>$value[$key]['label'],
            'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
            'hAlign'=>'right',
            'vAlign'=>'middle',
            //'mergeHeader'=>true,
            'noWrap'=>true,
            'group'=>$value[$key]['GRP'],
            'format'=>$value[$key]['FORMAT'],
            'headerOptions'=>[
                    'style'=>[
                    'text-align'=>'center',
                    'width'=>$value[$key]['FIELD'],
                    'font-family'=>'tahoma, arial, sans-serif',
                    'font-size'=>'8pt',
                    //'background-color'=>'rgba(74, 206, 231, 1)',
                    'background-color'=>'rgba('.$value[$key]['warna'].')',
                ]
            ],
            'contentOptions'=>[
                'style'=>[
                    'text-align'=>$value[$key]['align'],
                    'font-family'=>'tahoma, arial, sans-serif',
                    'font-size'=>'8pt',
                    //'background-color'=>'rgba(13, 127, 3, 0.1)',
                ]
            ],
            'editableOptions' => [
            'header' => 'sales',
            'inputType' => \kartik\editable\Editable::INPUT_MONEY,
            'size' => 'xs',
            'options'=>[
            'pluginOptions' => [
               'precision' => 1,
              ],
            ],
        
        //Refresh Display
        // 'displayValueConfig' => ArrayHelper::map(Customers::find()->where('STATUS<>3')->all(), 'CUST_KD', 'CUST_KD'),
      ],
        ];

        }elseif($value[$key]['FIELD'] == 'TARGET_MONTH'){
        $attDinamik[]=[
         'class'=>'kartik\grid\EditableColumn',
            'attribute'=>$value[$key]['FIELD'],
            'label'=>$value[$key]['label'],
            'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
            'hAlign'=>'right',
            'vAlign'=>'middle',
            //'mergeHeader'=>true,
            'noWrap'=>true,
            'group'=>$value[$key]['GRP'],
            'format'=>$value[$key]['FORMAT'],
            'headerOptions'=>[
                    'style'=>[
                    'text-align'=>'center',
                    'width'=>$value[$key]['FIELD'],
                    'font-family'=>'tahoma, arial, sans-serif',
                    'font-size'=>'8pt',
                    //'background-color'=>'rgba(74, 206, 231, 1)',
                    'background-color'=>'rgba('.$value[$key]['warna'].')',
                ]
            ],
            'contentOptions'=>[
                'style'=>[
                    'text-align'=>$value[$key]['align'],
                    'font-family'=>'tahoma, arial, sans-serif',
                    'font-size'=>'8pt',
                    //'background-color'=>'rgba(13, 127, 3, 0.1)',
                ]
            ],
            'editableOptions' => [
            'header' => 'sales',
            'inputType' => \kartik\editable\Editable::INPUT_RANGE ,
            'size' => 'xs'
        
        //Refresh Display
        // 'displayValueConfig' => ArrayHelper::map(Customers::find()->where('STATUS<>3')->all(), 'CUST_KD', 'CUST_KD'),
      ],
        ];

        }elseif($value[$key]['FIELD'] == 'BOBOT_PERCENT'){
        $attDinamik[]=[
         'class'=>'kartik\grid\EditableColumn',
            'attribute'=>$value[$key]['FIELD'],
            'label'=>$value[$key]['label'],
            'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
            'hAlign'=>'right',
            'vAlign'=>'middle',
            //'mergeHeader'=>true,
            'noWrap'=>true,
            'group'=>$value[$key]['GRP'],
            'format'=>$value[$key]['FORMAT'],
            'headerOptions'=>[
                    'style'=>[
                    'text-align'=>'center',
                    'width'=>$value[$key]['FIELD'],
                    'font-family'=>'tahoma, arial, sans-serif',
                    'font-size'=>'8pt',
                    //'background-color'=>'rgba(74, 206, 231, 1)',
                    'background-color'=>'rgba('.$value[$key]['warna'].')',
                ]
            ],
            'contentOptions'=>[
                'style'=>[
                    'text-align'=>$value[$key]['align'],
                    'font-family'=>'tahoma, arial, sans-serif',
                    'font-size'=>'8pt',
                    //'background-color'=>'rgba(13, 127, 3, 0.1)',
                ]
            ],
            'editableOptions' => [
            'header' => 'sales',
            'inputType' => \kartik\editable\Editable::INPUT_MONEY,
            'size' => 'xs',
            'options'=>[
            'pluginOptions' => [
               'precision' => 1,
              ],
            ],
            
              
        
        //Refresh Display
        // 'displayValueConfig' => ArrayHelper::map(Customers::find()->where('STATUS<>3')->all(), 'CUST_KD', 'CUST_KD'),
      ],
        ];

        }else{
            $attDinamik[]=[
            'class'=>'kartik\grid\EditableColumn',
            'attribute'=>$value[$key]['FIELD'],
            'label'=>$value[$key]['label'],
            'filterType'=>$value[$key]['filterType'],
            'filter'=>$value[$key]['filter'],
            'filterOptions'=>['style'=>'background-color:rgba('.$value[$key]['filterwarna'].'); align:center'],
            'hAlign'=>'right',
            'vAlign'=>'middle',
            //'mergeHeader'=>true,
            'noWrap'=>true,
            'group'=>$value[$key]['GRP'],
            'format'=>$value[$key]['FORMAT'],
            'headerOptions'=>[
                    'style'=>[
                    'text-align'=>'center',
                    'width'=>$value[$key]['FIELD'],
                    'font-family'=>'tahoma, arial, sans-serif',
                    'font-size'=>'8pt',
                    //'background-color'=>'rgba(74, 206, 231, 1)',
                    'background-color'=>'rgba('.$value[$key]['warna'].')',
                ]
            ],
            'contentOptions'=>[
                'style'=>[
                    'text-align'=>$value[$key]['align'],
                    'font-family'=>'tahoma, arial, sans-serif',
                    'font-size'=>'8pt',
                    //'background-color'=>'rgba(13, 127, 3, 0.1)',
                ]
            ],
        'editableOptions' => [
            'header' => 'sales',
            'inputType' => \kartik\editable\Editable::INPUT_MONEY,
            'size' => 'xs'
        
        //Refresh Display
        // 'displayValueConfig' => ArrayHelper::map(Customers::find()->where('STATUS<>3')->all(), 'CUST_KD', 'CUST_KD'),
      ],
        ];
        }
        
    };
    /*STATUS TERM*/
    $attDinamik[] =[
        'label'=>'STT_DEFAULT',
        'mergeHeader'=>true,
        'format' => 'raw',
        'hAlign'=>'center',
        'value' => function ($model) {
                        return status($model);
        },
        'headerOptions'=>[
            'style'=>[
                'text-align'=>'center',
                'width'=>'80px',
                'font-family'=>'verdana, arial, sans-serif',
                'font-size'=>'9pt',
                'background-color'=>'rgba(249, 215, 100, 1)',
            ]
        ],
    ];
    /*GRIDVIEW ARRAY ACTION*/
    $actionClass='btn btn-info btn-xs';
    $actionLabel='Action';
    $attDinamik[]=[
        'class'=>'kartik\grid\ActionColumn',
        'dropdown' => true,
        'template' => '{activ}{review}',
        'dropdownOptions'=>['class'=>'pull-right dropup','style'=>['disable'=>true]],
        'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
        'dropdownButton'=>[
            'class' => $actionClass,
            'label'=>$actionLabel,
            'caret'=>'<span class="caret"></span>',
        ],
         'buttons' => [
                /* View PO | Permissian All */
                // 'view' => function ($url, $model) {
                //                 return tombolView($url, $model);
                //           },
                // 'review' => function ($url, $model) {
                //                 return tombolReview($url, $model);
                //           }
             'activ' =>function($url, $model, $key){
                    return  '<li>' .Html::a('<span class="fa fa-search-plus fa-dm"></span>'.Yii::t('app', 'Activ'),
                                                ['/master/sop-sales/activ-header','id'=>$model->ID],[
                                                //'data-target'=>"#img1-visit",
                                                ]). '</li>' . PHP_EOL ;
            }
        ],
        'headerOptions'=>[
            'style'=>[
                'text-align'=>'center',
                'width'=>'10px',
                'font-family'=>'tahoma, arial, sans-serif',
                'font-size'=>'9pt',
                'background-color'=>'rgba(249, 215, 100, 1)',
            ]
        ],
        'contentOptions'=>[
            'style'=>[
                'text-align'=>'center',
                'width'=>'10px',
                'height'=>'10px',
                'font-family'=>'tahoma, arial, sans-serif',
                'font-size'=>'9pt',
            ]
        ],
    ];



    /*GRID VIEW BASE*/
    $gvSopSales= GridView::widget([
        'id'=>'gv-sopx-sales',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.9); align:center'],
        'columns' => $attDinamik,
        /* [
            ['class' => 'yii\grid\SerialColumn'],
            'start',
            'end',
            'title',
            ['class' => 'yii\grid\ActionColumn'],
        ], */
        'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'gv-sopx-sales',
            ],
        ],
        'panel' => [
                    'heading'=>'<h3 class="panel-title" style="font-family: verdana, arial, sans-serif ;font-size: 9pt;">Sales</h3>',
                    'type'=>'info',
                    //'showFooter'=>false,
        ],
        'toolbar'=> [
         ['content'=>tombolCreate()],
     ],
        'hover'=>true, //cursor select
         'responsive'=>true,
        'responsiveWrap'=>true,
        'bordered'=>true,
        'striped'=>true,
    ]);
?>

<!-- <div class="content" > -->
    <!-- HEADER !-->
    <div  class="row" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;padding-bottom:20px;">
        <!-- HEADER !-->
        <div class="col-md-12">
            <?php
                echo $gvSopSales;
            ?>
        </div>
    </div>
<!-- </div> Body ! -->


<?php
/*
 * JS  CREATED
 * @author wawan
 * @since 1.2
*/
$this->registerJs("
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        $('#new-sop').on('show.bs.modal', function (event) {
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
            }),
",$this::POS_READY);

Modal::begin([
        'id' => 'new-sop',
        'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>New</b></h4></div>',
        // 'size' => Modal::SIZE_SMALL,
        'headerOptions'=>[
            'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
        ]
    ]);
Modal::end();

/*
 * JS  CREATED
 * @author wawan
 * @since 1.2
*/
$this->registerJs("
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        $('#new-sop-detail').on('show.bs.modal', function (event) {
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
            }),
",$this::POS_READY);

Modal::begin([
        'id' => 'new-sop-detail',
        'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>New</b></h4></div>',
        // 'size' => Modal::SIZE_SMALL,
        'headerOptions'=>[
            'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
        ]
    ]);
Modal::end();


?>
