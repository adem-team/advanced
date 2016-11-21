<?php

/*
 * DAILY LOG PERSONAL ABSENSI
 * PERIODE 23-22
 * @author ptrnov  [piter@lukison.com]
 * @since 1.2
*/
echo GridView::widget([
	'id'=>'daily-personal-rekap',
	'dataProvider' => $dataProvider,
	//'filterModel' => $searchModel,
	'beforeHeader'=>$getHeaderLabelWrap,
	//'showPageSummary' => true,
	'columns' =>$attDinamik,
	//'floatHeader'=>true,
	'pjax'=>true,
	'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'absen-rekap',
		],
	],
	'panel' => [
				'heading'=>'<h3 class="panel-title">DAILY ATTENDANCE PERIODE</h3>',
				'type'=>'warning',
				// 'before'=> Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add Customer ',
						// ['modelClass' => 'Kategori',]),'/master/barang/create',[
							// 'data-toggle'=>"modal",
								// 'data-target'=>"#modal-create",
									// 'class' => 'btn btn-success'
												// ]),
				'showFooter'=>false,
	],
	'toolbar'=> [
		//'{items}',
	],
	'hover'=>true, //cursor select
	'responsive'=>true,
	'responsiveWrap'=>true,
	'bordered'=>true,
	'striped'=>true,
	//'perfectScrollbar'=>true,
	//'autoXlFormat'=>true,
	//'export' => false,
]);
?>