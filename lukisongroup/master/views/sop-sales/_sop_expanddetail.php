
<?php

use yii\helpers\ArrayHelper;
use kartik\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Json;
use yii\web\Response;
use yii\web\Request;
use kartik\daterange\DateRangePicker;
use yii\db\ActiveRecord;
use lukisongroup\master\models\SopSalesHeader;



/*
     * GRID VIEW detail sop
     * @author wawan  
     * @since 1.2
    */
    $attDinamik =[];
    /*GRIDVIEW ARRAY FIELD HEAD*/
    $headColomnEvent=[
        ['ID' =>0, 'ATTR' =>['FIELD'=>'TGL','SIZE' => '50px','label'=>'Tanggal','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>true,'filterwarna'=>'126, 189, 188, 0.9']],
        ['ID' =>1, 'ATTR' =>['FIELD'=>'SCORE_RSLT','SIZE' => '10px','label'=>'Jumlah Score','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],
        ['ID' =>2, 'ATTR' =>['FIELD'=>'SCORE_PERCENT_MIN','SIZE' => '10px','label'=>'Score Persentase min','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],
        ['ID' =>3, 'ATTR' =>['FIELD'=>'SCORE_PERCENT_MAX','SIZE' => '10px','label'=>'Score Persentase max','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'126, 189, 188, 0.9']],
        //['ID' =>4, 'ATTR' =>['FIELD'=>'STATUS','SIZE' => '10px','label'=>'STATUS','align'=>'left','warna'=>'249, 215, 100, 1','GRP'=>false,'FORMAT'=>'html','filter'=>true,'filterType'=>false,'filterwarna'=>'249, 215, 100, 1']],
    ];
    $gvHeadColomn = ArrayHelper::map($headColomnEvent, 'ID', 'ATTR');
    /*GRIDVIEW SERIAL ROWS*/
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
            'attribute'=>$value[$key]['FIELD'],
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
        }elseif($value[$key]['FIELD'] == 'SCORE_RSLT'){
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
        ];

        }else{
            $attDinamik[]=[
           
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
        ];
        }
    };
 

    /*GRID VIEW BASE*/
	$detail_sop= GridView::widget([
		'id'=>'sop-detail-idxy',
		'dataProvider' => $dataProvider_detail,
		// 'filterModel' => $searchModel_detail,
		//'filterRowOptions'=>['style'=>'background-color:rgba(74, 206, 231, 1); align:center'],
		/* 'beforeHeader'=>[
			[
				'columns'=>[
					['content'=>'ITEMS TRAIDE INVESTMENT', 'options'=>['colspan'=>3,'class'=>'text-center info',]],
					['content'=>'PLAN BUDGET', 'options'=>['colspan'=>2, 'class'=>'text-center info']],
					['content'=>'ACTUAL BUDGET', 'options'=>['colspan'=>2, 'class'=>'text-center info']],
					['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center info']],
					//['content'=>'Action Status ', 'options'=>['colspan'=>1,  'class'=>'text-center info']],
				],
			]
		], */
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
				'id'=>'sop-detail-idxy',
			],
		],
		'panel' => [
					'heading'=>'<h3 class="panel-title" style="font-family: verdana, arial, sans-serif ;font-size: 9pt;">Detail</h3>',
					'type'=>'info',

					// 'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create detail ',
     //        				['modelClass' => 'Customers',]),'/master/sop-sales/create-detail-sop',[
     //                          'data-toggle'=>"modal",
     //                          'id'=>'detail-sop-modal-id',
     //                           'data-target'=>"#new-sop-detail",
     //                           'class' => 'btn btn-success btn-sm'
     //                          ])
					//'showFooter'=>false,
		],
		 'toolbar'=> [
         ['content'=>detailtombol($detail_id)],
     ],
		'summary'=>false,
		// 'toolbar'=>false,
		// 'panel'=>false,
		'hover'=>true, //cursor select
		'responsive'=>true,
		'responsiveWrap'=>true,
	]);

      


?>




    <!-- HEADER !-->
    <div  class="row" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;padding-bottom:20px;">

    <div class="col-sm-6">
        <?=  Yii::$app->controller->renderPartial('sop_detailexpand',[
                'model_header'=>$model_detail = SopSalesHeader::find()->where(['ID'=>$detail_id])->one(),
               
            ]) ?>
            </div>
            </div>
            <div  class="row" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;padding-bottom:20px;">
        <!-- HEADER !-->
        <div class="col-md-12">
            <?php
                echo $detail_sop;
            ?>
        </div>
    </div>
