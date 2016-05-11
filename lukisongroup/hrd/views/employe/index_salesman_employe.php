
<?php
/* extensions*/
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;


?>


<?php
$gridColumns = [
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
          'font-size'=>'9pt',
          'background-color'=>'rgba(97, 211, 96, 0.3)',
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
    ],
    [
      'attribute' => 'NM_FIRST',
      'label'=>'Nama awal',
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'150px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
          'background-color'=>'rgba(97, 211, 96, 0.3)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'150px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
        ]
      ],
    ],
    [
      'attribute' => 'NM_MIDDLE',
      'label'=>'Item Name',
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'value'=>function($model){
         return $model->NM_MIDDLE.''.$model->NM_END;
      },
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'200px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
          'background-color'=>'rgba(97, 211, 96, 0.3)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'200px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
        ]
      ],
    ],
    [
      'attribute' => 'JOIN_DATE',
      'label'=>'Tanggal Gabung',
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'150px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
          'background-color'=>'rgba(97, 211, 96, 0.3)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'150px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
        ]
      ],
    ],
    [
      'attribute' => 'STATUS',
      'filter' => $valStt,
      'format' => 'raw',
      'hAlign'=>'center',
      'value'=>function($model){
         if ($model->STATUS == 0) {
          return Html::a('<i class="fa fa-check"></i> &nbsp;Enable', '',['class'=>'btn btn-success btn-xs', 'title'=>'Aktif']);
        } else if ($model->STATUS == 1) {
          return Html::a('<i class="fa fa-close"></i> &nbsp;Disable', '',['class'=>'btn btn-danger btn-xs', 'title'=>'Deactive']);
        }
      },
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'80px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
          'background-color'=>'rgba(97, 211, 96, 0.3)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'80px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
        ]
      ],
    ],
    [
      'class'=>'kartik\grid\ActionColumn',
      'dropdown' => true,
      'template' => '{view}{update}{edit}{price}{lihat}',
      'dropdownOptions'=>['class'=>'pull-right dropup'],
      'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
      'buttons' => [
          'view' =>function($url, $model, $key){
              return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
                            ['/master/barang/view','id'=>$model->ID],[
                            'data-toggle'=>"modal",
                            'data-target'=>"#modal-view",
                            'data-title'=> $model->ID,
                            ]). '</li>' . PHP_EOL;
          },
          'update' =>function($url, $model, $key){
              return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Edit'),
                            ['update','id'=>$model->ID],[
                            'data-toggle'=>"modal",
                            'data-target'=>"#modal-create",
                            'data-title'=> $model->ID,
                            ]). '</li>' . PHP_EOL;
          },
          'edit' =>function($url, $model, $key){
              return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Create Kode Alias'),
                            ['createalias','id'=>$model->ID],[
                            'data-toggle'=>"modal",
                            'data-target'=>"#modal-create",
                            'data-title'=> $model->ID,
                            ]). '</li>' . PHP_EOL;
          },
              ],
              'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'150px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
          'background-color'=>'rgba(97, 211, 96, 0.3)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'150px',
          'height'=>'10px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'9pt',
        ]
      ],

          ],

      ];

/* gridview salesman */
echo $salesman_gv= GridView::widget([
        'id'=>'sales-gv',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
        'columns' => $gridColumns,
		'panel'=>[
            //'heading' =>true,// $hdr,//<div class="col-lg-4"><h8>'. $hdr .'</h8></div>',
            'type' =>GridView::TYPE_SUCCESS,
          	'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create ',
						['modelClass' => 'ProfileSales',]),'/hrd/employe/create',[
															'data-toggle'=>"modal",
															'data-target'=>"#activity-emp",
															'class' => 'btn btn-success'
															])
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
                'id'=>'sales-gv',
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

    ?>
