<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use lukisongroup\master\models\Customers;

$this->params['breadcrumbs'][] = $this->title;
$this->sideCorp = 'Customers';                 				 /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = $sideMenu_control;//'umum_datamaster';   	 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Customers');   	 			 /* title pada header page */


$datatype =  ArrayHelper::map(Customers::find()->where('STATUS<>3')->groupBy('CUST_NM')->all(), 'CUST_KD', 'CUST_NM');



$gridColumns = [
        [ #serial column
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
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'10px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
    ],
	[ # disnm
      'attribute' => 'disnm',
      'label'=>'Distributor',
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'filterType'=>GridView::FILTER_SELECT2,
      'filter' => $cus_dis,
      'filterWidgetOptions'=>[
      'pluginOptions'=>[
        'allowClear'=>true,
        'contentOptions'=>[
          'style'=>[
            'text-align'=>'left',
            'font-family'=>'tahoma, arial, sans-serif',
            'font-size'=>'8pt',
          ] 
        ]
      ],
    ],
    'filterInputOptions'=>['placeholder'=>'Select'],
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'210px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'210px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
    ],
	 
	[  #custpnma
      'attribute' =>'custpnma',
      'label'=>' Customers.Parent',
      'hAlign'=>'left',
      'vAlign'=>'middle',
	    'group'=>true,
      'filterType'=>GridView::FILTER_SELECT2,
      'filter' => $cus_data,
      'filterWidgetOptions'=>[
      'pluginOptions'=>[
        'allowClear'=>true,
        'contentOptions'=>[
          'style'=>[
            'text-align'=>'left',
            'font-family'=>'tahoma, arial, sans-serif',
            'font-size'=>'8pt',
          ] 
        ]
      ],
    ],
    'filterInputOptions'=>['placeholder'=>'Select'],
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'250px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'250px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
    ],
	 [  #custnm
      'attribute' => 'custnm',
      'label'=>'Customers',
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'filterType'=>GridView::FILTER_SELECT2,
      'filter' => $child,
      'filterWidgetOptions'=>[
      'pluginOptions'=>[
        'allowClear'=>true,
        'contentOptions'=>[
          'style'=>[
            'text-align'=>'left',
            'font-family'=>'tahoma, arial, sans-serif',
            'font-size'=>'8pt',
          ] 
        ]
      ],
    ],
    'filterInputOptions'=>['placeholder'=>'Select'],
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'250px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'250px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
    ],
	[    #KD_ALIAS
      'attribute' => 'KD_ALIAS',
      'label'=>' Alias Code',
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'60px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'50px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
    ],
	[  #KD_CUSTOMERS
      'attribute' => 'KD_CUSTOMERS',
      'label'=>' ESM.Code',
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'headerOptions'=>[
        'style'=>[
          'text-align'=>'center',
          'width'=>'50px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'50px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
        ]
      ],
    ],
    [   #action column
      'class'=>'kartik\grid\ActionColumn',
      'dropdown' => true,
      'template' => '{update}{price}',
      'dropdownOptions'=>['class'=>'pull-right dropup'],
	    'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
      'buttons' => [
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
          'width'=>'10px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
          'background-color'=>'rgba(126, 189, 188, 0.9)',
        ]
      ],
      'contentOptions'=>[
        'style'=>[
          'text-align'=>'left',
          'width'=>'10px',
          'font-family'=>'tahoma, arial, sans-serif',
          'font-size'=>'8pt',
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
				'filterRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.9); align:center'],
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
					'heading'=>'<h7 class="panel-title">DISTRIBUTOR ALIAS CODE</h7>',
					// 'type'=>'warning',
					'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Plus',
							['modelClass' => 'Customersalias',]),'/master/customers/tambah-alias-customers',[
                'class' => 'btn btn-primary',
                              'data-toggle'=>"modal",
                              'id'=>'aliasmod',
                               'data-target'=>"#modal-create",
                               'class' => 'btn btn-primary btn-sm'
                              
              ]).' '. Html::a('<i class="glyphicon glyphicon-off"></i> '.Yii::t('app', 'Back',
							['modelClass' => 'Customersalias',]),'/master/customers',[
                'class' => 'btn btn-success btn-sm'
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
  'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-user"></div><div><h4 class="modal-title">ALIAS CUSTOMERS</h4></div>',
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
