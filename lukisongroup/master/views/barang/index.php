<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use lukisongroup\master\models\Barang;
use lukisongroup\hrd\models\Corp;
use lukisongroup\master\models\Tipebarang;
use lukisongroup\master\models\Kategori;

$userCorp = ArrayHelper::map(Corp::find()->where('CORP_STS<>3')->all(), 'CORP_ID', 'CORP_NM');
$typeBrg = ArrayHelper::map(Tipebarang::find()->where('STATUS<>3 and PARENT=1')->groupBy('NM_TYPE')->all(), 'KD_TYPE', 'NM_TYPE');
$kat = ArrayHelper::map(Kategori::find()->where('STATUS<>3 and PARENT=1')->groupBy('NM_KATEGORI')->all(), 'KD_KATEGORI', 'NM_KATEGORI');

	/*
	 * Declaration Componen User Permission
	 * Function profile_user
	*/
	function getPermissionEmp(){
		if (Yii::$app->getUserOpt->profile_user()){
			return Yii::$app->getUserOpt->profile_user()->emp;
		}else{
			return false;
		}
	}

$this->sideCorp = 'Master Data';              /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = $sideMenu_control;//'umum_datamaster';               /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Umum - Barang ');
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
			/*IMAGE ATTRIBUTE*/
			[
				/*Author -ptr.nov- image*/
               'attribute' => 'Image',
			   'mergeHeader'=>true,
               'format' => 'html', //'format' => 'image',
               'value'=>function($data){
                            return Html::img(Yii::$app->urlManager->baseUrl.'/upload/barang/' . $data->IMAGE, ['width'=>'40']);
                },
				'headerOptions'=>[
					'style'=>[
						'text-align'=>'center',
						'width'=>'40px',
						'font-family'=>'tahoma, arial, sans-serif',
						'font-size'=>'9pt',
						'background-color'=>'rgba(97, 211, 96, 0.3)',
					]
				],
            ],
			[
				'attribute' => 'KD_BARANG',
				'label'=>'SKU',
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
				'attribute' => 'NM_BARANG',
				'label'=>'Item Name',
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
				'attribute' => 'unitbrg',
				'label'=>'Item Unit',
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
				'label'=>'Corporation',
				'filter' => $userCorp,
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
				'attribute' => 'tipebrg',
				'label'=>'Type',
				'filterType'=>GridView::FILTER_SELECT2,
				'filter' => $typeBrg,
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
				'attribute' => 'nmkategori',
				'label'=>'Category',
				'filterType'=>GridView::FILTER_SELECT2,
				'filter' => $kat,
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
				'template' => '{view}{update}{edit}{price}{lihat}',
				'dropdownOptions'=>['class'=>'pull-right dropup'],
				'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
				'buttons' => [
						'view' =>function($url, $model, $key){
								return  '<li>' .Html::a('<span class="fa fa-eye fa-dm"></span>'.Yii::t('app', 'View'),
															['/master/barang/view','id'=>$model->ID],[
															'data-toggle'=>"modal",
															'data-target'=>"#modal-view",
															'data-title'=> $model->KD_BARANG,
															]). '</li>' . PHP_EOL;
						},
						'update' =>function($url, $model, $key){
								return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Edit'),
															['update','id'=>$model->ID],[
															'data-toggle'=>"modal",
															'data-target'=>"#modal-create",
															'data-title'=> $model->KD_BARANG,
															]). '</li>' . PHP_EOL;
						},
						'edit' =>function($url, $model, $key){
								return  '<li>' . Html::a('<span class="fa fa-edit fa-dm"></span>'.Yii::t('app', 'Create Kode Alias'),
															['createalias','id'=>$model->KD_BARANG],[
															'data-toggle'=>"modal",
															'data-target'=>"#modal-create",
															'data-title'=> $model->KD_BARANG,
															]). '</li>' . PHP_EOL;
						},
              'price' =>function($url, $model, $key) {
								$gF=getPermissionEmp()->GF_ID;
								if ($gF<=4){
									return  '<li>' . Html::a('<span class="fa fa-money fa-dm"></span>'.Yii::t('app', 'Price List Items'),
															['/master/barang/login-price-view'],[
															'data-toggle'=>"modal",
															'data-target'=>"#modal-price",
															]). '</li>' . PHP_EOL;
								}
						},
						'lihat' =>function($url, $model, $key) {
							$gF=getPermissionEmp()->GF_ID;
							if ($gF<=4){
								return  '<li>' . Html::a('<span class="fa fa-user"></span>'.Yii::t('app', 'Alias Data List'),
														['/master/barang/loginalias'],[
														'data-toggle'=>"modal",
														'data-target'=>"#modal-alias",
														]). '</li>' . PHP_EOL;
							}
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
				'id'=>'gv-brg-prodak',
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
					'heading'=>'<h3 class="panel-title">LIST ITEMS PRODUCTION</h3>',
					'type'=>'warning',
					'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Items ',
							['modelClass' => 'Kategori',]),'/master/barang/create',[
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




<!--

<p>
<i class="fa fa-check fa-sm" style="color:blue;" title="Aktif"></i> Aktif  &nbsp;&nbsp;&nbsp;&nbsp;
<i class="fa fa-times fa-sm" style="color:red;" title="Tidak Aktif" ></i> Tidak Aktif
</p>
!-->


<?php
	/*View*/
	$this->registerJs("
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
       'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">View Items Sku</h4></div>',
		'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
		],
    ]);
    Modal::end();



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

	/*Price*/
	$this->registerJs("
		 $.fn.modal.Constructor.prototype.enforceFocus = function(){};
		 $('#modal-price').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var modal = $(this)
			var title = button.data('title')
			var href = button.attr('href')
			//modal.find('.modal-title').html(title)
			modal.find('.modal-body').html('<i class=\"fa fa-dolar fa-spin\"></i>')
			$.post(href)
				.done(function( data ) {
					modal.find('.modal-body').html(data)
				});
			})
	",$this::POS_READY);
    Modal::begin([
        'id' => 'modal-price',
        'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Price Login Autorize</b></h4></div>',
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
    ]);
    Modal::end();

		/*alias*/
		$this->registerJs("
			 $.fn.modal.Constructor.prototype.enforceFocus = function(){};
			 $('#modal-alias').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget)
				var modal = $(this)
				var title = button.data('title')
				var href = button.attr('href')
				//modal.find('.modal-title').html(title)
				modal.find('.modal-body').html('<i class=\"fa fa-dolar fa-spin\"></i>')
				$.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)
					});
				})
		",$this::POS_READY);
			Modal::begin([
					'id' => 'modal-alias',
					'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Login Autorize</b></h4></div>',
				'size' => Modal::SIZE_SMALL,
				'headerOptions'=>[
					'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
				]
			]);
			Modal::end();
