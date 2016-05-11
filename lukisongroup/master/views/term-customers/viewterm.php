<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;;
use lukisongroup\master\models\Terminvest;
use lukisongroup\master\models\Termgeneral;
use lukisongroup\master\models\Customers;
use lukisongroup\master\models\Termcustomers;
use lukisongroup\master\models\Distributor;
use lukisongroup\hrd\models\Corp;
use lukisongroup\hrd\models\Jobgrade;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use kartik\detail\DetailView;


$this->sideCorp = 'ESM-Trading Terms';              /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_trading_term';               /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Trading Terms ');
	$aryStatus= [
		  ['STATUS' =>0, 'DESCRIP' => 'New'],
		  ['STATUS' =>1, 'DESCRIP' => 'Approved'],
		  ['STATUS' =>2, 'DESCRIP' => 'Reject']
	];
	$valStatus = ArrayHelper::map($aryStatus, 'STATUS', 'DESCRIP');


	/*
	 * STATUS FLOW DATA
	 * 1. NEW		= 0 	| Create First
	 * 2. APPROVED	= 1 	| Approved
	 * 3. REJECT	= 101	| Reject
	*/
	function statusTerm($model){
		if($model['STATUS']==0){
			/*New*/
			return Html::a('<i class="fa fa-square-o fa-md"></i> New', '#',['class'=>'btn btn-info btn-xs', 'style'=>['width'=>'100px'],'title'=>'New']);
		}elseif($model['STATUS']==1){
			/*Approved*/
			return Html::a('<i class="fa fa-check-square-o fa-md"></i>Approved', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Approved']);
		}elseif ($model['STATUS']==3){
			/*REJECT*/
			return Html::a('<i class="fa fa-remove fa-md"></i>Reject ', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Reject']);
		};
	}



	function PrintPdf($model){
		$title = Yii::t('app','Print');
		$options = [ 'id'=>'pdf-print-id',
			  'class'=>'btn btn-default btn-xs',
			  'title'=>'Print PDF',
			  'target' => '_blank'
		];
		$icon = '<span class="fa fa-print fa-fw"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/master/term-customers/cetakpdf','id'=>$model->ID_TERM]);
		$content = Html::a($label,$url, $options);
		return $content;
	}


?>
<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;8pt;padding-bottom:20px;">
	<!-- HEADER !-->
	<div  class="row">
		<!-- HEADER !-->
		<div class="col-md-12">
			<div class="col-md-1" style="float:left;">
				<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>
			</div>
			<div class="col-md-9" style="padding-top:15px;">
				<h3 class="text-center"><b> <?php echo  ucfirst($model->NM_TERM)  ?> </b></h3>
			</div>
			<div class="col-md-12">
				<hr style="height:10px;margin-top: 1px; margin-bottom: 1px;color:#94cdf0">
			</div>
		</div>
	</div>

	<!-- PARTIES/PIHAK !-->
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<div>

			</div>
			<dl>
				<?php
					$data = Customers::find()->where(['CUST_KD'=> $model->CUST_KD])->asArray()->one();
					$datadis = Distributor::find()->where(['KD_DISTRIBUTOR'=> $model->DIST_KD])->asArray()->one();
					$datacorp = Corp::find()->where(['CORP_ID'=> $model->PRINCIPAL_KD])->asArray()->one();
				 ?>

				<dt><h6><u><b>PARTIES/PIHAK BERSANGKUTAN:</b></u></h6></dt>
				<dd>1 :	<?= $data['CUST_NM'] ?></dd>
				<dd>2 :	<?= $datadis['NM_DISTRIBUTOR']?></dd>
				<dd>3 :	<?=$datacorp['CORP_NM']?></dd>
		  </dl>
		</div>
	</div>

	<!-- PERIODE/JANGKA WAKTU !-->
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<div>
			 <!-- echo periode($model); ?> -->
			</div>
				<dl>
				<dt><h6><u><b>Period/Jangka Waktu :</b></u></h6></dt>
				<dt style="width:80px; float:left;"> Dari: </dt>
				<dd>:	<?=$model->PERIOD_START ?></dd>
				<dt style="width:80px; float:left;">Sampai:</dt>
				<dd>:	<?=$model->PERIOD_END?></dd>
			</dl>
		</div>
	</div>

	<!-- TERM OF PAYMENT !-->
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<dl>
				<dt><h6><u><b>TERM OF PAYMENT :</b></u></h6></dt>
				<dd> <?= $model->TOP ?></dd>
			</dl>
		</div>
	</div>

	<!-- TARGET !-->
    <div class="row">
		<div class="col-xs-5 col-sm-5 col-md-5" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<dl>
				<dt style="width:80px;"><h6><u><b>TARGET :</b></u></h6></dt>
				<dd> Rp.<?=$model->TARGET_VALUE?></dd>
				<dd>	<?=$model->TARGET_TEXT ?> Rupiah</dd>

			</dl>
		</div>
	</div>

	<!-- TRADE INVESTMENT !-->
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<?php
				echo '<h6><u><b>TRADE INVESTMENT</b></u></h6>';
				echo  $grid = GridView::widget([
						'id'=>'gv-term-general',
						'dataProvider'=> $dataProvider1,
						'footerRowOptions'=>['style'=>'font-weight:bold;text-decoration: underline;'],
						'beforeHeader'=>[
							[
								'columns'=>[
									['content'=>'ITEMS TRAIDE INVESTMENT', 'options'=>['colspan'=>3,'class'=>'text-center info',]],
									['content'=>'PLAN BUDGET', 'options'=>['colspan'=>2, 'class'=>'text-center info']],
									['content'=>'ACTUAL BUDGET', 'options'=>['colspan'=>2, 'class'=>'text-center info']],
									['content'=>'', 'options'=>['colspan'=>1, 'class'=>'text-center info']],
									//['content'=>'Action Status ', 'options'=>['colspan'=>1,  'class'=>'text-center info']],
								],
							]
						],
						'columns'=>[
							[
								'class'=>'kartik\grid\SerialColumn',
								'contentOptions'=>['class'=>'kartik-sheet-style'],
								'width'=>'5%',
								'header'=>'No.',
								'headerOptions'=>[
									'style'=>[
									 'text-align'=>'center',
									 'width'=>'100px',
									 'font-family'=>'verdana, arial, sans-serif',
									 'font-size'=>'9pt',
									 'background-color'=>'rgba(97, 211, 96, 0.3)',
									]
								],
								'contentOptions'=>[
									'style'=>[
									 'text-align'=>'center',
									 'width'=>'100px',
									 'font-family'=>'tahoma, arial, sans-serif',
									 'font-size'=>'9pt',
									]
								],
							],
							[
								'attribute' => 'INVES_TYPE',
								'label'=>'Trade Investment',
								'hAlign'=>'left',
								'vAlign'=>'middle',
								'headerOptions'=>[
									'style'=>[
										 'width'=>'25%',
										 'text-align'=>'center',
										 'font-family'=>'tahoma, arial, sans-serif',
										 'font-size'=>'9pt',
										 'background-color'=>'rgba(97, 211, 96, 0.3)',
									]
								],
								'contentOptions'=>[
									'style'=>[
										 'text-align'=>'left',
										 'width'=>'25%',
										 'font-family'=>'tahoma, arial, sans-serif',
										 'font-size'=>'9pt',
									]
								],
								'pageSummaryOptions' => [
									'style'=>[
									   'border-left'=>'0px',
									   'border-right'=>'0px',
									]
								],

							],
							[
								'attribute' => 'PERIODE_END',
								'label'=>'Periode',
								'hAlign'=>'left',
								'vAlign'=>'middle',
								'noWrap'=>true,
								'value' => function($model) { return $model->PERIODE_START . "-" . $model->PERIODE_END;},
								'headerOptions'=>[
									'style'=>[
									 'text-align'=>'center',
									 'width'=>'15%',
									 'font-family'=>'tahoma, arial, sans-serif',
									 'font-size'=>'9pt',
									 'background-color'=>'rgba(97, 211, 96, 0.3)',
									]
								],
								'contentOptions'=>[
									'style'=>[
									 'text-align'=>'center',
									 'width'=>'15%',
									 'font-family'=>'tahoma, arial, sans-serif',
									 'font-size'=>'9pt',
									]
								],
								'pageSummary'=>function ($summary, $data, $widget){
									 return '<div> Total :</div>';
								},
								'pageSummaryOptions' => [
									'style'=>[
									   'font-family'=>'tahoma',
									   'font-size'=>'8pt',
									   'text-align'=>'right',
									   'border-left'=>'0px',

									]
								],
							],
							[	//BUDGET_PLAN
								//COL
								'attribute' => 'BUDGET_PLAN',
								'label'=>'Budget Plan',
								'hAlign'=>'left',
								'vAlign'=>'middle',
								'headerOptions'=>[
									'style'=>[
									 'text-align'=>'center',
									 'width'=>'17%',
									 'font-family'=>'tahoma, arial, sans-serif',
									 'font-size'=>'9pt',
									 'background-color'=>'rgba(97, 211, 96, 0.3)',
									]
								],
								'contentOptions'=>[
									'style'=>[
									 'text-align'=>'right',
									 'width'=>'17%',
									 'font-family'=>'tahoma, arial, sans-serif',
									 'font-size'=>'9pt',
									]
								],
								'pageSummaryFunc'=>GridView::F_SUM,
								'format'=>['decimal', 2],
								'pageSummary'=>true,
								'pageSummaryOptions' => [
									'style'=>[
									   'font-family'=>'tahoma',
									   'font-size'=>'8pt',
									   'text-align'=>'right',
									   'border-left'=>'0px',
									]
								],
							],
							[
								'attribute' => 'budget.TARGET_VALUE',
								'label'=>'%',
								'hAlign'=>'left',
								'vAlign'=>'middle',
								'value' => function($model) {
										if($model->budget->TARGET_VALUE == '')
										{
											 return  $model->budget->TARGET_VALUE = 0.00;
										}
										else {
											# code...
											 return $model->BUDGET_PLAN / $model->budget->TARGET_VALUE * 100;
										}
								},
								'headerOptions'=>[
									'style'=>[
										'text-align'=>'center',
										'width'=>'10%',
										'font-family'=>'tahoma, arial, sans-serif',
										'font-size'=>'9pt',
										'background-color'=>'rgba(97, 211, 96, 0.3)',
									]
								],
								'contentOptions'=>[
									'style'=>[
										'text-align'=>'right',
										'width'=>'10%',
										'font-family'=>'tahoma, arial, sans-serif',
										'font-size'=>'9pt',
									]
								],
								'pageSummaryFunc'=>GridView::F_SUM,
								'format'=>['decimal', 2],
								'pageSummary'=>true,
								'pageSummaryOptions' => [
									'style'=>[
										'font-family'=>'tahoma',
										'font-size'=>'8pt',
										'text-align'=>'right',
										'border-left'=>'0px',
									]
								 ],
								 'pageSummary'=>function ($summary, $data, $widget){
										return '<div> Total:</div>'
													 ;
									 },
							],
							[	//BUDGET_ACTUAL
								//COL
								'attribute' => 'BUDGET_ACTUAL',
								'label'=>'Budget Actual',
								'hAlign'=>'left',
								'vAlign'=>'middle',
								'headerOptions'=>[
									'style'=>[
										 'text-align'=>'center',
										 'width'=>'15%',
										 'font-family'=>'tahoma, arial, sans-serif',
										 'font-size'=>'9pt',
										 'background-color'=>'rgba(97, 211, 96, 0.3)',
									]
								],
								'contentOptions'=>[
									'style'=>[
										 'text-align'=>'right',
										 'width'=>'15%',
										 'font-family'=>'tahoma, arial, sans-serif',
										 'font-size'=>'9pt',
									]
								],
								'pageSummaryFunc'=>GridView::F_SUM,
								'format'=>['decimal', 2],
								'pageSummary'=>true,
								'pageSummaryOptions' => [
									'style'=>[
										 'font-family'=>'tahoma',
										 'font-size'=>'8pt',
										 'text-align'=>'right',
										 'border-left'=>'0px',
									]
								],
							'pageSummary'=>function ($summary, $data, $widget) use($dataProvider1,$modelnewaprov)	{
									$model=$dataProvider1->getModels();
									if(count($model) == 0)
									{
									  $total = $summary;
									}
									else{
										$total = $modelnewaprov;
									}
									return '<div>'.$total.'</div>';
									}
							],
							[	//PERCENT ACTUAL
								//COL
								'attribute' => 'budget.TARGET_VALUE',
								'label'=>'%',
								'hAlign'=>'left',
								'vAlign'=>'middle',
								'value' => function($model) {
										if($model->budget->TARGET_VALUE == '')
										{
											 return  $model->budget->TARGET_VALUE = 0.00;
										}
										else {
										  # code...
										   return $model->BUDGET_ACTUAL / $model->budget->TARGET_VALUE * 100;
										}
								},
								'headerOptions'=>[
									'style'=>[
									  'text-align'=>'center',
									  'width'=>'10%',
									  'font-family'=>'tahoma, arial, sans-serif',
									  'font-size'=>'9pt',
									  'background-color'=>'rgba(97, 211, 96, 0.3)',
									]
								],
								'contentOptions'=>[
									'style'=>[
									  'text-align'=>'right',
									   'width'=>'10%',
									  'font-family'=>'tahoma, arial, sans-serif',
									  'font-size'=>'9pt',
									]
								],
								'pageSummaryFunc'=>GridView::F_SUM,
								'format'=>['decimal', 2],
								'pageSummary'=>true,
								'pageSummaryOptions' => [
									'style'=>[
									  'font-family'=>'tahoma',
									  'font-size'=>'8pt',
									  'text-align'=>'right',
									  'border-left'=>'0px',
									]
							   ],
							],
							[
								'attribute'=>'STATUS',
								'label'=>'Status',
								'hAlign'=>'right',
								'vAlign'=>'middle',
								'filter'=>$valStatus,
								'filterOptions'=>[
									'style'=>'background-color:rgba(0, 95, 218, 0.3); align:center;',
									'vAlign'=>'middle',
								],
								'format' => 'html',
								'value'=>function ($model, $key, $index, $widget) {
									return statusTerm($model);
								},
								'noWrap'=>true,
								'headerOptions'=>[
									'style'=>[
										'text-align'=>'center',
										'width'=>'15%',
										'font-family'=>'tahoma, arial, sans-serif',
										'font-size'=>'8pt',
										'background-color'=>'rgba(97, 211, 96, 0.3)',
									]
								],
								'contentOptions'=>[
									'style'=>[
										'text-align'=>'center',
										'width'=>'15%',
										'font-family'=>'tahoma, arial, sans-serif',
										'font-size'=>'8pt',
										//'background-color'=>'rgba(13, 127, 3, 0.1)',
									]
								],
								//'pageSummaryFunc'=>GridView::F_SUM,
								//'pageSummary'=>true,
								'pageSummaryOptions' => [
									'style'=>[
											'text-align'=>'right',
											'font-family'=>'tahoma',
											'font-size'=>'8pt',
											'text-decoration'=>'underline',
											'font-weight'=>'bold',
											'border-left-color'=>'transparant',
											'border-left'=>'0px',
									]
								],
							],
						],
						'showPageSummary' => true,
						'pjax'=>true,
						'pjaxSettings'=>[
							'options'=>[
								'enablePushState'=>false,
								'id'=>'gv-term-general',
							],
						],
						/* 'toolbar' => [
							'',
						],
						'panel' => [
							'heading'=>'<h3 class="panel-title">TRADE INVESTMENT</h3>',
							'type'=>'success',
							'showFooter'=>false,
						], */
						'export' =>false,
					]);
				?>
		</div>
	</div>

	<!-- RABATE !-->
    <div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<dl>
				<dt><h6><u><b>Conditional Rabate : <?= $model->RABATE_CNDT ?></b></u></h6></dt>
			</dl>
		</div>
    </div>

   <!-- GROWTH !-->
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<dl>
			  <dt><h6><u><b>Growth : <?= $model->GROWTH ?> %</b></u></h6></dt>
			</dl>
		</div>
	</div>

	<!-- GENERAL TERM !-->
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12" style="font-family: tahoma ;font-size: 9pt;padding-left:30px">
			<?php
 		// 	 image($model);
			$image = $model->imagedisplay($model->ID_TERM);
			 ?>
			 <div>
				 <?php
				//  $img = Url::to('@web/upload/barang/').'df.jpg';
				 //
				//  $dataimage = $image->GENERAL_TERM !=''? '<img src="data:image/jpeg;base64,' . $image->GENERAL_TERM . '" />' : '<img src="'.$img.'" width="50" />';;
				//  	echo  $dataimage;

			?>
		</div>

		</div>
	</div>


	<div style="text-align:right;float:right">
		<?php echo PrintPdf($model); ?>
	</div>

	<!-- Signature !-->
	<div  class="col-md-12">
		<div  class="row" >
			<div class="col-md-6">
				<table id="tbl" class="table table-bordered" style="font-family: tahoma ;font-size: 8pt;">
					<!-- Tanggal!-->
					 <tr>
						<!-- Tanggal Pembuat RO!-->
						<th  class="col-md-1" style="text-align: center; height:20px">
							<div style="text-align:center;">
								<?php
									$placeTgl1=$model->SIG1_TGL!=0 ? Yii::$app->ambilKonvesi->convert($model->SIG1_TGL,'date') :'';
									echo '<b>Tangerang</b>,' . $placeTgl1;
								?>
							</div>

						</th>
						<!-- Tanggal Pembuat RO!-->
						<th class="col-md-1" style="text-align: center; height:20px">
							<div style="text-align:center;">
								<?php
									$placeTgl2=$model->SIG2_TGL!=0 ? Yii::$app->ambilKonvesi->convert($model->SIG2_TGL,'date') :'';
									echo '<b>Tangerang</b>,' . $placeTgl2;
								?>
							</div>

						</th>
						<!-- Tanggal PO Approved!-->
						<th class="col-md-1" style="text-align: center; height:20px">
							<div style="text-align:center;">
								<?php
									$placeTgl3=$model->SIG3_TGL!=0 ? Yii::$app->ambilKonvesi->convert($model->SIG3_TGL,'date') :'';
									echo '<b>Tangerang</b>,' . $placeTgl3;
								?>
							</div>
						</th>

					</tr>
					<!-- Department|Jbatan !-->
					 <tr>
						<th  class="col-md-1" style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
							<div>
								<b><?php  echo 'Created'; ?></b>
							</div>
						</th>
						<th class="col-md-1"  style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
							<div>
								<b><?php  echo 'Checked'; ?></b>
							</div>
						</th>
						<th class="col-md-1" style="background-color:rgba(126, 189, 188, 0.3);text-align: center; vertical-align:middle;height:20">
							<div>
								<b><?php  echo 'Approved'; ?></b>
							</div>
						</th>
					</tr>
					<!-- Signature !-->
					 <tr>
						<th class="col-md-1" style="text-align: center; vertical-align:middle; height:40px">
							<?php
							$ttd1 = $model->SIG1_SVGBASE64 !='' ? '<img style="width:80; height:40px" src='.$model->SIG1_SVGBASE64.'></img>':''
								?>
							  <?= $ttd1 ?>

						</th>
						<th class="col-md-1" style="text-align: center; vertical-align:middle">
							<?php
								$ttd2 =  $model->SIG2_SVGBASE64 !='' ? '<img style="width:80; height:40px" src='.$model->SIG2_SVGBASE64.'></img>':'';
								echo $ttd2
							?>
						</th>
						<th  class="col-md-1" style="text-align: center; vertical-align:middle">
							<?php
									$ttd3 = $model->SIG3_SVGBASE64 !='' ? '<img style="width:80; height:40px" src='.$model->SIG3_SVGBASE64.'></img>':'';
								  echo $ttd3
							?>
						</th>
					</tr>
					<!--Nama !-->
					 <tr>
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
							<div>
								<?php
									$sigNm1=$model->SIG1_NM!='none' ? '<b>'.$model->SIG1_NM.'</b>' : 'none';
									echo $sigNm1;
								?>
							</div>
						</th>
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
							<div>
								<?php
									$sigNm2=$model->SIG2_NM!='none' ? '<b>'.$model->SIG2_NM.'</b>' : 'none';
									echo $sigNm2;
								?>
							</div>
						</th>
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
							<div>
								<?php
									$sigNm3=$model->SIG3_NM!='none' ? '<b>'.$model->SIG3_NM.'</b>' : 'none';
									echo $sigNm3;
								?>
							</div>
						</th>
					</tr>
					<!-- Department|Jbatan !-->
					 <tr>
						<th style="text-align: center; vertical-align:middle;height:20">
							<div>
								<b><?php  echo 'Marketing & Sales'; ?></b>
							</div>
						</th>
						<th style="text-align: center; vertical-align:middle;height:20">
							<div>
								<b><?php  echo 'F & A'; ?></b>
							</div>
						</th>
						<th style="text-align: center; vertical-align:middle;height:20">
							<div>
								<b><?php  echo 'Director'; ?></b>
							</div>
						</th>
					</tr>
				</table>
			</div>
		</div>
	</div>
		  </div>
<?php
     $this->registerJs("
        $.fn.modal.Constructor.prototype.enforceFocus = function(){};
        $('#pihak').on('show.bs.modal', function (event) {
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
        'id' => 'pihak',
       'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Items Sku</h4></div>',
       'headerOptions'=>[
           'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
       ],
       ]);
       Modal::end();

       $this->registerJs("
          $.fn.modal.Constructor.prototype.enforceFocus = function(){};
          $('#periode').on('show.bs.modal', function (event) {
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
          'id' => 'periode',
         'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Items Sku</h4></div>',
         'headerOptions'=>[
             'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
         ],
         ]);
         Modal::end();

         $this->registerJs("
            $.fn.modal.Constructor.prototype.enforceFocus = function(){};
            $('#TOP').on('show.bs.modal', function (event) {
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
            'id' => 'TOP',
           'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Items Sku</h4></div>',
           'headerOptions'=>[
               'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
           ],
           ]);
           Modal::end();

           $this->registerJs("
              $.fn.modal.Constructor.prototype.enforceFocus = function(){};
              $('#TARGET').on('show.bs.modal', function (event) {
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
              'id' => 'TARGET',
             'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-book"></div><div><h4 class="modal-title">Create Items Sku</h4></div>',
             'headerOptions'=>[
                 'style'=> 'border-radius:5px; background-color: rgba(97, 211, 96, 0.3)',
             ],
             ]);
             Modal::end();

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
