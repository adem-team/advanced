<?php
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
use yii\helpers\ArrayHelper;
use yii\web\Request;
use kartik\daterange\DateRangePicker;
use yii\db\ActiveRecord;
use yii\data\ArrayDataProvider;
use dosamigos\gallery\Gallery;


$this->registerJs($this->render('modal_issue.js'));

	function statusIssue($model){
		if($model->STATUS==1){
			/*REVIEW*/
			// return Html::a('<i class="fa fa-square-o fa-md"></i> REVIEW','#',['class'=>'btn btn-info btn-xs', 'style'=>['width'=>'100px'],'title'=>'Review']);
			return  Html::button(Yii::t('app', 'Review'),
						['value'=>url::to(['link-berita','id'=>$model->ID]),
						'id'=>'modal-btn-issue',
						'class'=>"btn btn-info btn-xs",
						'style'=>['width'=>'100px'],						
					  ]);

		}elseif($model->STATUS==2){
			/*PROCESS*/
			return Html::a('<i class="fa fa-check-square-o fa-md"></i> OPEN',url::toRoute(['/widget/berita/detail-berita-open','id'=>$model->ID_ISSUE_REF]),['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Process']);
		}elseif ($model->STATUS==3){
			/*CLODED*/
			return Html::a('<i class="glyphicon glyphicon-remove"></i> CLOSED',url::toRoute(['/widget/berita/detail-berita-open','id'=>$model->ID_ISSUE_REF]),['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Closed']);
		};
	}
	
	$btn_srch = Html::button(Yii::t('app', 'Search Date'),
						['value'=>url::to(['ambil-tanggal-issue']),
						'id'=>'modalButtonIssueTgl',
						'class'=>"btn btn-info btn-sm"						
					  ]);
					  
					  // Html::a('<i class="fa fa-search"></i> Search Date',
							// '/master/review-visit/ambil-tanggal-issue',
							// [		
								// 'data-toggle'=>"modal",		
								// 'data-target'=>"#modal-tgl-issue",		
								// 'class' => 'btn btn-info btn-sm'		
						   // ]
						// );
						
$gridColumns = [
	[ #serial column
		'class'=>'kartik\grid\SerialColumn',
		'contentOptions'=>['class'=>'kartik-sheet-style'],
		'width'=>'10px',
		'header'=>'No.',
		'noWrap'=>true,
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
	[
		'attribute' => 'TGL',
		'label'=>'TGL',
		'hAlign'=>'center',
		'vAlign'=>'middle',
		'filter'=>false,
		'noWrap'=>true,
		'mergeHeader'=>true,
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
			  'text-align'=>'center',
			  'width'=>'50px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			]
		],
	],
	[
		'attribute' => 'NM_CUSTOMER',
		'label'=>'CUSTOMER',
		'hAlign'=>'left',
		'filterOptions'=>[
			'colspan'=>3,
		],
		'vAlign'=>'middle',
		'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'150px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
			  'text-align'=>'left',
			  'width'=>'150px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			]
		],
	],
	[
		'attribute' => 'UserNm',
		'label'=>'SALES.NM',
		'hAlign'=>'left',
		'vAlign'=>'top',
		'mergeHeader'=>true,
		'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'100px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
			  'text-align'=>'left',
			  'width'=>'100px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			]
		],
	],
	[
		'attribute' => 'Geonm',
		'label'=>'GEO',
		'hAlign'=>'left',
		'vAlign'=>'top',
		'mergeHeader'=>true,
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
	[
		'attribute' => 'ISI_MESSAGES',
		'label'=>'ISSUE NOTE',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'400px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
			  'text-align'=>'left',
			  'width'=>'400px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			]
		],
	],
	[	//COL-1
		/* Attribute Status Detail RO */
		'attribute'=>'STATUS',
		'options'=>['id'=>'test-ro'],
		'label'=>'Status',
		'hAlign'=>'center',
		'vAlign'=>'middle',
		'mergeHeader'=>true,
		'contentOptions'=>['style'=>'width: 100px'],
		'format' => 'raw',
		'value'=>function ($model, $key, $index, $widget) {
					return statusIssue($model);
		},
		'headerOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'80px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			  'background-color'=>'rgba(126, 189, 188, 0.9)',
			]
		],
		'contentOptions'=>[
			'style'=>[
			  'text-align'=>'center',
			  'width'=>'80px',
			  'font-family'=>'tahoma, arial, sans-serif',
			  'font-size'=>'8pt',
			]
		],
	],
];

$issueMemo= GridView::widget([
	'id'=>'gv-dashboard-issue',
	'dataProvider' => $dataProviderIssue,
	'filterModel' => $searchModelIssue,
	'filterRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.9); align:center'],
	'columns' => $gridColumns,
	'pjax'=>true,
	'pjaxSettings'=>[
		'options'=>[
			'enablePushState'=>false,
			'id'=>'gv-dashboard-issue',
		],
	],
	'summary'=>false,
	'panel' => [
		'heading'=>false,//'<div style="float:left;margin-right:10px" class="fa fa-2x fa-bicycle"></div><div><h4 class="modal-title">Store Issue</h4></div>'.' '.'<div style="float:right; margin-top:-22px;margin-right:0px;">'.$btn_srch.'</div>', 
		'type'=>'success',
		'before'=> $btn_srch
	],
	'toolbar'=> [
		//['content'=>toMenuAwal().toExportExcel()],
		''//'{items}',
	],
]); 
	/**
	* Button Set Date
	*/
	$this->registerJs("		
		$('#modal-button-set-date-issue').on('show.bs.modal', function (event) {
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
		'id' => 'modal-button-set-date-issue',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-search-plus"></div><div><h4 class="modal-title">SEARCH DATE</h4></div>',
		'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(129, 220, 238, 1)',
		],
	]);
	Modal::end(); 
?>
<?=$issueMemo?>
<?php
$this->registerJs("		
  //       $.fn.modal.Constructor.prototype.enforceFocus = function(){};	
		// $(document).on('click','#modalButtonIssueTgl', function(ehead){ 			  
		// 	$('#modal-issue-tgl').modal('show')
		// 	.find('#modalContentIssueTgl')
		// 	.load(ehead.target.value);
		// });		  
			
         // $('#modal-tgl-issue').on('show.bs.modal', function (event) {		
          //   var button = $(event.relatedTarget)		
          //   var modal = $('#modal-tgl-issue').find('#modalContenTglIssue').load(event.target.value);
			 
            // var title = button.data('title')		
            // var href = button.attr('href')		
             //modal.find('.modal-title').html(title)		
             //modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')		
             // $.post(href)		
                 // .done(function( data ) {		
                     // modal.find('.modal-body').html(data)		
                 // });		
           //  })		
			 // $('#modal-rooms').modal('show')
						// .find('#modalContentRooms')
						// .html(data)
			 
			 
			 
     ",$this::POS_READY);
	 
     Modal::begin([		
         'id' => 'modal-issue-tgl',		
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-search"></div><div><h4 class="modal-title"> SEARCH DATE</h4></div>',	
		 'size' => Modal::SIZE_SMALL,	
         'headerOptions'=>[		
                 'style'=> 'border-radius:5px; background-color: rgba(90, 171, 255, 0.7)',		
         ],		
     ]);		
		echo "<div id='modalContentIssueTgl'></div>";
     Modal::end();

    

   


      Modal::begin([		
         'id' => 'modal-issue',		
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-address-book-o"></div><div><h4 class="modal-title">Berita Acara</h4></div>',	
		 'size' => Modal::SIZE_SMALL,	
         'headerOptions'=>[		
                 'style'=> 'border-radius:5px; background-color: rgba(90, 171, 255, 0.7)',		
         ],		
     ]);		
		echo "<div id='modalContentIssue'></div>";
     Modal::end();


    ?>
    

