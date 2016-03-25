<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use lukisongroup\master\models\Customers;


/* @var $this yii\web\View */
/* @var $searchModel lukisongroup\master\models\BarangaliasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/*
 * Declaration Componen User Permission
 * Function profile_user
*/

$datatype =  ArrayHelper::map(Customers::find()->where('STATUS<>3')->groupBy('CUST_NM')->all(), 'CUST_KD', 'CUST_NM');



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
      'attribute' => 'disnm',
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
      'attribute' => 'custnm',
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
      'attribute' => 'KD_CUSTOMERS',
      'label'=>'Kode Customers',
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
      'attribute' => 'KD_ALIAS',
      'label'=>' Alias Code',
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
      'class'=>'kartik\grid\ActionColumn',
      'dropdown' => true,
      'template' => '{view}{update}{price}',
      'dropdownOptions'=>['class'=>'pull-right dropup'],
	  'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
      'buttons' => [
          'view' =>function($url, $model, $key){
              return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
                            ['view-alias','id'=>$model->ID],[
                            'data-toggle'=>"modal",
                            'data-target'=>"#modal-view",
                            'data-title'=> $model->KD_CUSTOMERS,
                            ]). '</li>';
          },
          'update' =>function($url, $model, $key){
              return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Edit'),
                            ['update-alias','id'=>$model->KD_CUSTOMERS],[
                            'data-toggle'=>"modal",
                            'data-target'=>"#modal-create",
                            'data-title'=> $model->KD_CUSTOMERS,
                            ]). '</li>';
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
				'id'=>'gv-brg-alias',
				'dataProvider'=> $dataProvider,
				'filterModel' => $searchModel,
				'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
				'columns' => $gridColumns,
				'pjax'=>true,
					'pjaxSettings'=>[
						'options'=>[
							'enablePushState'=>false,
							'id'=>'gv-brg-prodak',
						],
					 ],
				'toolbar' => [
					'{export}',
				],
				'panel' => [
					'heading'=>'<h3 class="panel-title">List Nama Alias</h3>',
					'type'=>'warning',
					'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Logout',
							['modelClass' => 'Kategori',]),'/master/customers/price-logout',[
                'class' => 'btn btn-success'
              ]),
					      'showFooter'=>false,
				],

				'export' =>['target' => GridView::TARGET_BLANK],
				'exportConfig' => [
					GridView::PDF => [ 'filename' => 'Alias'.'-'.date('ymdHis') ],
					GridView::EXCEL => [ 'filename' => 'Alias'.'-'.date('ymdHis') ],
				],
			]);
		?>
	</div>
</div>
<?php
/*Create and edit*/

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

  /*View*/

  $this->registerJs("
     $.fn.modal.Constructor.prototype.enforceFocus = function(){};
     $('#modal-view').on('show.bs.modal', function (event) {
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
        'id' => 'modal-view',
    'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">View Alias Code</h4></div>',
    'headerOptions'=>[
        'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
    ],
    ]);
    Modal::end();

  ?>
