
<?php
use kartik\helpers\Html;
use yii\helpers\Url;
use dosamigos\gallery\Gallery;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\bootstrap\Modal;
use lukisongroup\widget\models\NotulenModul;

use lukisongroup\hrd\models\Employe;
use yii\helpers\ArrayHelper;

$this->registerCss($this->render('letter.css'));

$this->registerCss($this->render('accordion.css'));

$this->registerJs($this->render('set_person.js'),$this::POS_READY);


function kembali(){
        $title = Yii::t('app','');
        $options = [ 'id'=>'notulen-back-id',
             'class'=>'btn-xs',
             'title'=>'Back',
        ];
        $icon = '<span class="fa fa-rotate-left fa-xs"> Back</span>';
        $label = $icon . ' ' . $title;
        //$label = 'Reply';
        $url = Url::toRoute('/widget/notulen');
        $content = Html::a($label,$url, $options);
        return $content;
    }


  function btnTanggal($model){
    // if($model->start != '' && $model->end == '')
    // {
    //   $title = Yii::t('app',substr($model->start,0,11).' - '.'xxxx-xx-xx');
    // }elseif($model->end != '' && $model->start == '')
    // {
    //   $title = Yii::t('app','xxxx-xx-xx'.' - '.substr($model->end,0,11));
    // }elseif($model->start != '' && $model->end != '')
    // {
    //    $title = Yii::t('app',substr($model->start,0,11).' - '.substr($model->end,0,11));
    //  }else{
    //     $title = Yii::t('app','xxxx-xx-xx'.' - '.'xxxx-xx-xx');
    //  }



    $title = $model->start != '' ? Yii::$app->formatter->format($model->start, 'date'): Yii::t('app','xxxx-xx-xx');

        //$title = Yii::t('app','xxxx-xx-xx');
        $options = [ 'id'=>'notu-tgl-id',
             'data-toggle'=>"modal",
             'data-target'=>"#tanggal-id",
             'class'=>'btn-xs',
             'title'=>$title,
        ];
        // $icon = '<span class="fa fa-rotate-left fa-xs"> Back</span>';
        $label = $title;
        //$label = 'Reply';
        $url = Url::toRoute(['/widget/notulen/set-tanggal','id'=>$model->id]);
        $content = Html::a($label,$url, $options);
        return $content;
    }

    function btnAcara($acara){
      $title = $acara[0]->SCHEDULE != '' ? $acara[0]->SCHEDULE : Yii::t('app','---------------');
        $options = [ 'id'=>'notu-acara-id',
             'class'=>'btn-xs',
             'data-toggle'=>"modal",
             'data-target'=>"#acara",
             'title'=>$title,
        ];
        // $icon = '<span class="fa fa-rotate-left fa-xs"> Back</span>';
        $label = $title;
        //$label = 'Reply'; $acara[0]->SCHEDULE 
        $url = Url::toRoute(['/widget/notulen/set-acara','id'=>$acara[0]->NOTULEN_ID]);
        $content = Html::a($label,$url, $options);
        return $content;
    }

      function btnRapat($acara){
        $title = $acara[0]->RESULT_SCHEDULE != '' ? $acara[0]->RESULT_SCHEDULE : Yii::t('app','---------------');
        $options = [ 'id'=>'notu-rapat-id',
             'class'=>'btn-xs',
             'data-toggle'=>"modal",
             'data-target'=>"#rapat",
             'title'=>$title,
        ];
        // $icon = '<span class="fa fa-rotate-left fa-xs"> Back</span>';
        $label = $title;
        //$label = 'Reply';
        $url = Url::toRoute(['/widget/notulen/set-hasil','id'=>$acara[0]->NOTULEN_ID]);
        $content = Html::a($label,$url, $options);
        return $content;
    }

    function btnSetMateri($model){
        $title = $model->title != '' ? $model->title : Yii::t('app','---------------');
        $options = [ 'id'=>'notu-rapat-id',
             'class'=>'btn-xs',
             'data-toggle'=>"modal",
             'data-target'=>"#rapat",
             'title'=>$title,
        ];
        // $icon = '<span class="fa fa-rotate-left fa-xs"> Back</span>';
        $label = $title;
        //$label = 'Reply';
        $url = Url::toRoute(['/widget/notulen/set-title','id'=>$model->id]);
        $content = Html::a($label,$url, $options);
        return $content;
    }


     function btnSetRoom($model){
        $title = $model->ROOM != '' ? $model->ROOM : Yii::t('app','---------------');
        $options = [ 'id'=>'notu-ruang-id',
             'class'=>'btn-xs',
             'data-toggle'=>"modal",
             'data-target'=>"#ruang",
             'title'=>$title,
        ];
        // $icon = '<span class="fa fa-rotate-left fa-xs"> Back</span>';
        $label = $title;
        //$label = 'Reply';
        $url = Url::toRoute(['/widget/notulen/set-ruang','id'=>$model->id]);
        $content = Html::a($label,$url, $options);
        return $content;
    }


    function btnSetTime($acara){
      if( $acara[0]->TIME_START != '' && $acara[0]->TIME_END != '' )
      {
         $title = $acara[0]->TIME_START.' - '.$acara[0]->TIME_END;
      }elseif($acara[0]->TIME_END != '' && $acara[0]->TIME_START == '' ){
         $title ='xx:xx'.' - '.$acara[0]->TIME_END;
      }elseif($acara[0]->TIME_START != '' && $acara[0]->TIME_END == '')
      {
         $title =$acara[0]->TIME_START.' - '.'xx:xx';
       }else{
           $title ='xx:xx'.' - '.'xx:xx';
       }
        $options = [ 'id'=>'notu-set-time',
             'class'=>'btn-xs',
             'data-toggle'=>"modal",
             'data-target'=>"#jam-id",
             'title'=>$title,
        ];
        // $icon = '<span class="fa fa-rotate-left fa-xs"> Back</span>';
        $label = $title;
        //$label = 'Reply';
        $url = Url::toRoute(['/widget/notulen/set-time','id'=>$acara[0]->NOTULEN_ID]);
        $content = Html::a($label,$url, $options);
        return $content;
    }

    function SignCreated($acara){
		$title = Yii::t('app', 'Sign Hire');
		$options = [ 'id'=>'notulen-auth1',
					  'data-toggle'=>"modal",
					  'data-target'=>"#notulen-auth1-sign",
					  'class'=>'a_demo_two',
					  'style'=>['width'=>'100px'],
					  'title'=>'Detail'
		];
		$icon = '<span class="glyphicon glyphicon-retweet"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/widget/notulen/sign-auth1-view','id'=>$acara[0]->NOTULEN_ID]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

   function Signvalid(){
    $title = Yii::t('app', 'Sign Hire');
    $options = [ 'id'=>'notulen-auth1',
            // 'data-toggle'=>"modal",
            // 'data-target'=>"#notulen-auth1-sign",
            'class'=>'a_demo_two',
            'style'=>['width'=>'100px'],
            'title'=>'Detail'
    ];
    $icon = '<span class="glyphicon glyphicon-retweet"></span>';
    $label = $icon . ' ' . $title;
    // $url = Url::toRoute(['/widget/notulen/sign-auth1-view','id'=>$acara[0]->NOTULEN_ID]);
    $content = Html::a($label,'#', $options);
    return $content;
  }

	  function SignCreated2($acara){
		$title = Yii::t('app', 'Sign Hire');
		$options = [ 'id'=>'notulen-auth2',
					  'data-toggle'=>"modal",
					  'data-target'=>"#notulen-auth2-sign",
					  'class'=>'btn btn-warning btn-xs',
					  'style'=>['width'=>'100px'],
					  'title'=>'Detail'
		];
		$icon = '<span class="glyphicon glyphicon-retweet"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/widget/notulen/sign-auth2-view','id'=>$acara[0]->NOTULEN_ID]);
		$content = Html::a($label,$url, $options);
		return $content;
	}

 

	function SIGN_2($acara)
	{
		$data = Employe::find()->where(['EMP_ID'=>$acara[0]->SIG2_ID])->one();
		return $data->SIGSVGBASE64;
	}

	function SIGN_1($acara)
	{
		$data = Employe::find()->where(['EMP_ID'=>$acara[0]->SIG1_ID])->one();
		return $data->SIGSVGBASE64;
	}

	/*
	 * LIST MEMO CALENDAR 
	 * PERIODE 23-22
	 * @author ptrnov  [piter@lukison.com]
	 * @since 1.2
	*/
	$actionClass='btn btn-info btn-xs';
	$actionLabel='Update';
	$attDinamikNotulen =[];				
	/*GRIDVIEW ARRAY FIELD HEAD*/
	$headColomnNotulen=[
		['ID' =>0, 'ATTR' =>['FIELD'=>'title','SIZE' => '300px','label'=>'TITLE','align'=>'left','warna'=>'159, 221, 66, 1']],
		['ID' =>1, 'ATTR' =>['FIELD'=>'start','SIZE' => '20px','label'=>'DATE START','align'=>'left','warna'=>'159, 221, 66, 1']],				
		['ID' =>2, 'ATTR' =>['FIELD'=>'end','SIZE' => '20px','label'=>'DATE END','align'=>'left','warna'=>'159, 221, 66, 1']],
		
	];
	$gvHeadColomnNotulen = ArrayHelper::map($headColomnNotulen, 'ID', 'ATTR');
	/*GRIDVIEW NUMBER*/
	$attDinamikNotulen[]=[
		/* Attribute Serial No */
			'class'=>'kartik\grid\SerialColumn',
			'width'=>'5px',
			'header'=>'No.',
			'hAlign'=>'center',
			'headerOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'5px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
					'background-color'=>'rgba(0, 95, 218, 0.3)',
				]
			],
			'contentOptions'=>[
				'style'=>[
					'text-align'=>'center',
					'width'=>'5px',
					'font-family'=>'tahoma',
					'font-size'=>'8pt',
				]
			],
			'pageSummaryOptions' => [
				'style'=>[
					'border-right'=>'0px',
				]
			]
	];
	
	/*GRIDVIEW ARRAY ROWS*/
	foreach($gvHeadColomnNotulen as $key =>$value[]){
		$attDinamikNotulen[]=[		
			'attribute'=>$value[$key]['FIELD'],
			'label'=>$value[$key]['label'],
			'filter'=>true,
			'hAlign'=>'right',
			'vAlign'=>'middle',
			//'mergeHeader'=>true,
			'noWrap'=>true,			
			'headerOptions'=>[		
					'style'=>[									
					'text-align'=>'center',
					'width'=>$value[$key]['SIZE'],
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					//'background-color'=>'rgba(97, 211, 96, 0.3)',
					'background-color'=>'rgba('.$value[$key]['warna'].')',
				]
			],  
			'contentOptions'=>[
				'style'=>[
					'width'=>$value[$key]['SIZE'],
					'text-align'=>$value[$key]['align'],
					'font-family'=>'tahoma, arial, sans-serif',
					'font-size'=>'8pt',
					//'background-color'=>'rgba(13, 127, 3, 0.1)',
				]
			],
			//'pageSummaryFunc'=>GridView::F_SUM,
			//'pageSummary'=>true,
			// 'pageSummaryOptions' => [
				// 'style'=>[
						// 'text-align'=>'right',		
						//'width'=>'12px',
						// 'font-family'=>'tahoma',
						// 'font-size'=>'8pt',	
						// 'text-decoration'=>'underline',
						// 'font-weight'=>'bold',
						// 'border-left-color'=>'transparant',		
						// 'border-left'=>'0px',									
				// ]
			// ],	
		];	
	};
	
	/*GRIDVIEW ARRAY ACTION*/
	$attDinamikNotulen[]=[
		'class'=>'kartik\grid\ActionColumn',
		'dropdown' => true,
		'template' => '{view}',
		'dropdownOptions'=>['class'=>'pull-right dropdown','style'=>['disable'=>true]],
		'dropdownButton'=>[
			'class' => $actionClass,
			'label'=>$actionLabel,
			//'caret'=>'<span class="caret"></span>',
		],
		'buttons' => [
			'view' =>function($url, $model, $key){
					return  '<li>' .Html::a('<span class="fa fa-eye"></span>'.Yii::t('app', 'View'),
												['/widget/notulen/view','id'=>$model->id],[
												'id'=>'notulen-id',
												// 'data-toggle'=>"modal",
												// 'data-target'=>"#alias-cust",
												]). '</li>' . PHP_EOL;
			},				
		],
		'headerOptions'=>[
			'style'=>[
				'text-align'=>'center',
				'width'=>'10px',
				'font-family'=>'tahoma, arial, sans-serif',
				'font-size'=>'9pt',
				'background-color'=>'rgba(159, 221, 66, 1)',
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
	
	/*SET  GRID VIEW LIST EVENT*/
	$gvNutulen= GridView::widget([
		'dataProvider' => $dataProvider,
		// 'filterModel' => $searchModelNotulen,
		'filterRowOptions'=>['style'=>'background-color:rgba(255, 221, 66, 1); align:center'],
		'columns' => $attDinamikNotulen,
		'floatOverflowContainer'=>true,
		'floatHeader'=>true,
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
				'id'=>'absen-rekap',
			],
		],
		'panel' => [
					'heading'=>"<span class='fa fa-edit'><b> LIST NOTULEN</b></span>",
					'type'=>'info',
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
	]); 




?>
<div id='body-notulen'>
<!--<div class="fold">-->
	<!-- Tema  -->
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="row" style="margin-top:35px;margin-left:1px;margin-right:10px;">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<?php echo Html::img('http://lukisongroup.com/img_setting/kop/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-center">
				<!-- <h5 class="text-left"><b>FORM PERMINTAAN BARANG & JASA</b></h5> !-->
				<h4 class="text-center" style="padding-top:30px"><b>NOTULEN RAPAT</b></h4>
			</div>
			
			<div class="col-xs-3 col-sm-3 col-md-2 col-lg-2 text-left" >
				<div class="hidden-xs">
					<!-- <b class="text-right"> echo btnTanggal($model) ?></b> -->
					<nav class="menu" style="padding-top:100px;">
						<input type="checkbox" href="#" class="menu-open" name="menu-open" id="menu-open" />
						<label class="menu-open-button" for="menu-open"> <span class="lines line-1"></span> <span class="lines line-2"></span> <span class="lines line-3"></span> </label>
						<a href="#" class="menu-item item-1"> <i class="fa fa-anchor"></i> </a> 
						<a href="#" class="menu-item item-2"> <i class="fa fa-coffee"></i> </a> 
						<a href="#" class="menu-item item-3"> <i class="fa fa-envelope-o"></i> </a> 
						<a href="/widget/notulen/" class="menu-item item-4"> <i class="fa fa-undo"></i></a> 
						<a href="#" class="menu-item item-5"> <i class="fa fa-print fa-fw"></i> </a> 
						<a href="#" class="menu-item item-6"> <i class="fa fa-diamond"></i> </a>
					</nav>
				 </div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">			
				<div style="padding-top:20px;">
					<hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
					<hr style="height:1px;margin-top: 1px; margin-bottom: 10px;">
				</div>
			</div>
		</div>
	</div>
	<!-- header -->
	<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
		<div class="row" style="margin-left:1px;padding-top:10px">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  style="margin-left:0;">
				<dl>
				<!-- tanggal -->
				  <dt style="width:150px; float:left;">Tanggal</dt> 
				  <dd style="color:rgba(87, 163, 247, 1)">:<b><?php echo btnTanggal($model) ?></b></dd>
				  <!-- waktu -->
				  <dt style="width:150px; float:left;">Waktu</dt>
				  <dd style="color:rgba(87, 163, 247, 1)">:<?= btnSetTime($acara) ?> </dd>

				   <!-- tempat -->
						<dt style="width:150px; float:left;">Tempat</dt>
						<dd style="color:rgba(87, 163, 247, 1)">:  <b><?= btnSetRoom($model) ?></b></dd>
						<!-- materi rapat -->
						<dt style="width:150px; float:left;">Materi Rapat</dt>
						<dd>: <?php echo btnSetMateri($model); ?></dd>
				</dl>
				
			</div>
		</div>
	</div>
	
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
		<div class="row" style="margin-top:10px;margin-left:10px;margin-right:10px;">
			<!-- <div class="col-sm-12"> -->
			<section class="ac-container" >
				<div>
					  <input id="ac-1" name="accordion-1" type="radio" checked="">
					  <label for="ac-1"> 

					   <!--    Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['/widget/notulen/set-person','id'=>$acara[0]->NOTULEN_ID],
											['data-toggle'=>"modal",
											'id'=>'per-id',
													'data-target'=>"#person-notulen"]) ?> -->
						  <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>','#',['id'=>'per-id']) ?>
						   Peserta Rapat


					  </label>
					<article class="ac-small">
						<br>
							<ul>
								<?php

								   $peserta = explode(',',$acara[0]->USER_ID);
								  

									 if(count($peserta) != 0)
								   {

								   	 foreach ($peserta as $key => $value) {
								   	 	# code...
								   	 	$val_id[] = $value;
								   	 }


								   	 $selected = (new \yii\db\Query())
									            ->select(["CONCAT(em.EMP_NM, ' ',em.EMP_NM_BLK) AS full_name"])
									            ->from('dbm001.user as us')
									            ->innerJoin('dbm002.a0001 as em','em.EMP_ID = us.EMP_ID')
									            ->where(['and','us.status' => 10,['<>','us.EMP_ID','LG.2015.000000'],['in', 'us.id',$val_id]])
									            ->all();

									  foreach ($selected as $key => $value) {
									  	# code...
									  	?>

									  	<li><?= Html::a($value['full_name'], ['/widget/notulen/set-person','id'=>$acara[0]->NOTULEN_ID],
													['data-toggle'=>"modal",
															'data-target'=>"#person-notulen"]) ?> 
										</li>


									  	<?php

									  }

								   }



								 ?>

							</ul>
						<br>
					</article>
				</div>
				<div>
					<input id="ac-2" name="accordion-1" type="radio">
					<label for="ac-2">			  
						<?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['/widget/notulen/set-acara','id'=>$acara[0]->NOTULEN_ID],
										['data-toggle'=>"modal",
												'data-target'=>"#acara"]) ?>
					   Susunan Acara

					</label>
					<article class="ac-medium">
						<?= btnAcara($acara) ?>
					</article>
				</div>
				<div>
					<input  id="ac-3" name="accordion-1" type="radio">
					<label for="ac-3">
						<?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['/widget/notulen/set-hasil','id'=>$acara[0]->NOTULEN_ID],
										['data-toggle'=>"modal",
										 'data-target'=>"#rapat",
										 

										 ]);
						?>
						Hasil Rapat
					</label>
					<article class="ac-large">
						<?= btnRapat($acara) ?>
						<?=$gvNutulen?>

					</article>
				</div>
		  </section>
		  <!-- </div> -->
		</div>
	</div>

	<div  class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"  >
			<div  class="row" style="margin-top:50px;margin-left:50px;margin-bottom:50px">
				<dl>
					<dt>Notulis,</dt>
					</dl>
					  <dl>
					  <?php
						 $ttd2 = $acara[0]->SIGN_STT2!= 0 ?  '<img style="width:80 ; height:40px;" src='.SIGN_2($acara).'></img>' :SignCreated2($acara);
						 echo $ttd2;
					  ?>
				</dl>
				<dl>
					  <?php
							$name2 = $acara[0]->SIG2_NM != '' ? $acara[0]->SIG2_NM : 'none' ;
							echo $name2;
					   ?>
				</dl>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="person-notulen" role="dialog">
		<div class="modal-dialog">		
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				   <div style="float:left;margin-right:10px;" class="fa fa-2x fa fa-pencil"></div><div><h5 class="modal-title"><h5><b>NOTULEN</b></h5></div>
				</div>
				<div class="modal-body">
				  <?= $this->render('set_person',[
					  'person_form'=>$person_form,
					  'items'=>$items,
					  'id'=>$model->id
				  ]) ?>
				</div>
				<div class="modal-footer">
				</div>
			</div>		  
		</div>
	</div>
 </div>




<?php

$this->registerJs("
            $.fn.modal.Constructor.prototype.enforceFocus = function() {};
            $('#notulen-auth1-sign').on('show.bs.modal', function (event) {
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

/*modal*/
Modal::begin([
    'id' => 'notulen-auth1-sign',
    'header' => '<div style="float:left;margin-right:10px;" class="fa fa-2x fa fa-pencil"></div><div><h5 class="modal-title"><h5><b>NOTULEN</b></h5></div>',
    'size' => Modal::SIZE_SMALL,
    'headerOptions'=>[
        'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
    ],
  ]);
    echo "<div id='modalContentSign1'></div>";
    Modal::end(); 

    $this->registerJs("
            $.fn.modal.Constructor.prototype.enforceFocus = function() {};
            $('#notulen-auth2-sign').on('show.bs.modal', function (event) {
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

/*modal*/
Modal::begin([
    'id' => 'notulen-auth2-sign',
    'header' => '<div style="float:left;margin-right:10px;" class="fa fa-2x fa fa-pencil"></div><div><h5 class="modal-title"><h5><b>NOTULEN</b></h5></div>',
    'size' => Modal::SIZE_SMALL,
    'headerOptions'=>[
        'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
    ],
  ]);
    echo "<div id='modalContentSign2'></div>";
    Modal::end(); 


	$this->registerJs("
				$.fn.modal.Constructor.prototype.enforceFocus = function() {};
				$('#rapat').on('show.bs.modal', function (event) {
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

	/*modal*/
	Modal::begin([
		'id' => 'rapat',
		'header' => '<div style="float:left;margin-right:10px;" class="fa fa-2x fa fa-pencil"></div><div><h5 class="modal-title"><h5><b>NOTULEN</b></h5></div>',
		// 'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
		],
	]);
		echo "<div id='modalContentNotulen'></div>";
    Modal::end(); 

    $this->registerJs("
				$.fn.modal.Constructor.prototype.enforceFocus = function() {};
				$('#ruang').on('show.bs.modal', function (event) {
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

	/*modal*/
	Modal::begin([
		'id' => 'ruang',
		'header' => '<div style="float:left;margin-right:10px;" class="fa fa-2x fa fa-pencil"></div><div><h5 class="modal-title"><h5><b>NOTULEN</b></h5></div>',
		// 'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
		],
	]);
		echo "<div id='modalContentNotulen'></div>";
    Modal::end(); 

    $this->registerJs("
            $.fn.modal.Constructor.prototype.enforceFocus = function() {};
            $('#acara').on('show.bs.modal', function (event) {
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


    /*modal*/
Modal::begin([
    'id' => 'acara',
    'header' => '<div style="float:left;margin-right:10px;" class="fa fa-2x fa fa-pencil"></div><div><h5 class="modal-title"><h5><b>NOTULEN</b></h5></div>',
    // 'size' => Modal::SIZE_SMALL,
    'headerOptions'=>[
        'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
    ],
  ]);
    echo "<div id='modalContentacara'></div>";
    Modal::end();

//      $this->registerJs("
//             $.fn.modal.Constructor.prototype.enforceFocus = function() {};
//             $('#person-notulen').on('show.bs.modal', function (event) {
//                 var button = $(event.relatedTarget)
//                 var modal = $(this)
//                 var title = button.data('title')
//                 var href = button.attr('href')
//                 modal.find('.modal-title').html(title)
//                 modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
//                 $.post(href)
//                     .done(function( data ) {
//                         modal.find('.modal-body').html(data)
//                     });
//                 }),
//     ",$this::POS_READY);


//     /*modal*/
// Modal::begin([
//     'id' => 'person-notulen',
//     'header' => '<div style="float:left;margin-right:10px;" class="fa fa-2x fa fa-pencil"></div><div><h5 class="modal-title"><h5><b>NOTULEN</b></h5></div>',
//     // 'size' => Modal::SIZE_SMALL,
//     'headerOptions'=>[
//         'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
//     ],
//   ]);
//     echo "<div id='modalContentPerson'></div>";
//     Modal::end(); 

 
 
 
 
 
 
	/*MODAL JAM NOTULEN*/
	$this->registerJs("
				$.fn.modal.Constructor.prototype.enforceFocus = function() {};
				$('#jam-id').on('show.bs.modal', function (event) {
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

	/*modal*/
	Modal::begin([
		'id' => 'jam-id',
		'header' => '<div style="float:left;margin-right:10px;" class="fa fa-2x fa fa-pencil"></div><div><h5 class="modal-title"><h5><b>TIME NOTULEN</b></h5></div>',
		'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
		],
	]);
		echo "<div id='modalContentNotulen'></div>";
    Modal::end();
	
	/*MODAL TANGGAL NOTULEN*/
    $this->registerJs("
		$.fn.modal.Constructor.prototype.enforceFocus = function() {};
		$('#tanggal-id').on('show.bs.modal', function (event) {
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
		'id' => 'tanggal-id',
		'header' => '<div style="float:left;margin-right:10px;" class="fa fa-2x fa fa-pencil"></div><div><h5 class="modal-title"><h5><b>TANGGAL NOTULEN</b></h5></div>',
		'size' => Modal::SIZE_SMALL,
		'headerOptions'=>[
			'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
		],
	]);
		echo "<div id='modalContentacara'></div>";
    Modal::end();    


?>