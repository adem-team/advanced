<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\TermcustomersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$aryStt= [
    ['STATUS' => 0, 'STT_NM' => 'DISABLE'],
    ['STATUS' => 1, 'STT_NM' => 'ENABLE'],
];
$valStt = ArrayHelper::map($aryStt, 'STATUS', 'STT_NM');

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
      'attribute' => 'cus.CUST_NM',
      'label'=>'Nama Customers',
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
      'attribute' => 'NM_TERM',
      'label'=>'Nama Perjanjian',
      'hAlign'=>'left',
      'vAlign'=>'middle',
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
      'attribute' => 'dis.NM_DISTRIBUTOR',
      'label'=>'Nama Distributor',
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
      'attribute' =>'corp.CORP_NM',
      'label'=>'Nama Pihak 2',
      // 'filter' => $userCorp,
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
      'attribute' => 'PERIOD_END',
      'label'=>'Tanggal Berakhir Perjanjian',
      'filterType'=>GridView::FILTER_SELECT2,
      // 'filter' => $typeBrg,
      'filterWidgetOptions'=>[
        'pluginOptions'=>['allowClear'=>true],
      ],
      'filterInputOptions'=>['placeholder'=>'Any author'],
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
      'attribute' => 'PERIOD_START',
      'label'=>'Tanggal awal Perjanjian',
      'filterType'=>GridView::FILTER_SELECT2,
      // 'filter' => $kat,
      'filterWidgetOptions'=>[
        'pluginOptions'=>['allowClear'=>true],
      ],
      'filterInputOptions'=>['placeholder'=>'Any author'],
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
         if ($model->STATUS == 1) {
          return Html::a('<i class="fa fa-check"></i> &nbsp;Enable', '',['class'=>'btn btn-success btn-xs', 'title'=>'Aktif']);
        } else if ($model->STATUS == 0) {
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
      'template' => '{view}{update}',
      'dropdownOptions'=>['class'=>'pull-right dropup'],
      'buttons' => [
          'view' =>function($url, $model, $key){
              return  '<li>' .Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Review'),
                            ['/master/term-customers/view','id'=>$model->ID_TERM],[
                            // 'data-toggle'=>"modal",
                            // 'data-target'=>"#modal-view",
                            // 'data-title'=> $model->ID_TERM,
                            ]). '</li>' . PHP_EOL;
          },
          'update' =>function($url, $model, $key){
              return  '<li>' . Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
                            ['/master/term-customers/view-term-cus','id'=>$model->ID_TERM],[
                            // 'data-toggle'=>"modal",
                            // 'data-target'=>"#modal-create",
                            'data-title'=> $model->ID_TERM,
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
?>


<div class="container-full">
	<div style="padding-left:15px; padding-right:15px">
		<?= $grid = GridView::widget([
				'id'=>'gv-term-customers',
				'dataProvider'=> $dataProvider,
				'filterModel' => $searchModel,
				'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
				'columns' => $gridColumns,
				'pjax'=>true,
					'pjaxSettings'=>[
						'options'=>[
							'enablePushState'=>false,
							'id'=>'gv-term-customers',
						],
					 ],
				'toolbar' => [
					'{export}',
				],
				'panel' => [
					'heading'=>'<h3 class="panel-title">LIST PERJANJIAN</h3>',
					'type'=>'warning',
					'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Term ',
							['modelClass' => 'Termcustomers',]),'/master/term-customers/create',[
								'data-toggle'=>"modal",
									'data-target'=>"#modal-create",
										'class' => 'btn btn-success'
													]),
					'showFooter'=>false,
				],

				'export' =>['target' => GridView::TARGET_BLANK],
				'exportConfig' => [
					GridView::PDF => [ 'filename' => 'kategori'.'-'.date('ymdHis') ],
					GridView::EXCEL => [ 'filename' => 'kategori'.'-'.date('ymdHis') ],
				],
			]);
		?>
	</div>
</div>
<?php
$this->registerJs("
   $.fn.modal.Constructor.prototype.enforceFocus = function(){};
   $('#modal-create').on('show.bs.modal', function (event) {
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
      'id' => 'modal-create',
  'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Items Sku</h4></div>',
  'headerOptions'=>[
      'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
  ],
  ]);
  Modal::end();
