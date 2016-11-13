<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
// use lukisongroup\assets\AppAssetJqueryJSignature;
// AppAssetJqueryJSignature::register($this);

use lukisongroup\master\models\Unitbarang;



$this->sideCorp = 'ESM-Trading Terms';              /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_trading_term';               /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Trading Terms ');

	/* LOCK STATUS TOMBOL */
	 $headerStatus=$roHeader->STATUS;

	/*
	 * DESCRIPTION FORM EDIT
	 * Form EDIT RO, dapat dibuka untuk prosess Edit [RQTY|UNIT|NOTE] | RQTY = Request Quantity
	 * Items Form EDIT RO dapat di edit jika belum ada ACTION APPROVAL dari Head atau Status masih PROCCESS
	 * Items Form EDIT RO dapat di edit jika STATUS tidak sama dengan DELETE|REJECT|UNKNOWN
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/

	/*
	 * Script Js For get Signature
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	 $this->registerJs('
			$(document).ready(function($) {
				/* Data Signature1 from DB */
				var ro_datadb1 =\''. $roHeader->SIG1_SVGBASE64 . '\'
					var i = new Image();
						i.src = ro_datadb1
						$(i).appendTo($("#ro-view-approval-sig1"));
				/* Data Signature2 from DB */
				var ro_datadb2 =\''. $roHeader->SIG2_SVGBASE64 . '\'
					var j = new Image();
						j.src = ro_datadb2
						$(j).appendTo($("#ro-view-approval-sig2"));
			});
	 ',$this::POS_BEGIN);

	/*
	 * Declaration Componen User Permission
	 * Function getPermission
	 * Modul Name[1=pO]
	*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses(5)){
			return Yii::$app->getUserOpt->Modul_akses(5);
		}else{
			return false;
		}
	}
	//print_r(getPermission());

	/*Not USED*/
	$arrayStt= [
		  ['STATUS' => '0', 'name' => 'PROCESS'],
		  ['STATUS' => '1', 'name' => 'APPROVED'],
		  ['STATUS' => '3', 'name' => 'REJECT'],
		  ['STATUS' => '4', 'name' => 'DELETE'],
	];
	$valStt = ArrayHelper::map($arrayStt, 'id', 'name');

	/*
	 * STATUS FLOW DATA
	 * 1. NEW		= 0 	| Create First
	 * 2. APPROVED	= 1 	| Item Approved
	 * 3. PROCESS	= 101	| Sign Auth1 | Data Sudah di buat dan di tanda tangani
	 * 4. CHECKED	= 102	| Sign Auth2 | Data Sudah Di Check  dan di tanda tangani
	 * 5. APPROVED	= 103	| Sign Auth3 | Data Sudah Di disetujui dan di tanda tangani
	 * 6. DELETE	= 3 	| Data Hidden | Data Di hapus oleh pembuat petama, jika belum di Approved
	 * 7. REJECT	= 4		| Data tidak di setujui oleh manager atau Atasan  lain
	 * 8. PANDING	= 5		| Menunggu keputusan berikutnya.
	 * 9. UNKNOWN	<>		| Data Tidak valid atau tidak sah
	*/
	function statusProcessRo($model){
		if($model->STATUS==0){
			return Html::a('<i class="glyphicon glyphicon-retweet"></i> New', '#',['class'=>'btn btn-info btn-xs', 'style'=>['width'=>'100px'],'title'=>'Detail']);
		}elseif($model->STATUS==1){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> Approved', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==3){
			return Html::a('<i class="glyphicon glyphicon-remove"></i> DELETE', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==4){
			return Html::a('<i class="glyphicon glyphicon-thumbs-down"></i> REJECT', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif($model->STATUS==5){
			return Html::a('<i class="glyphicon glyphicon-retweet"></i> Pending', '#',['class'=>'btn btn-danger btn-xs', 'style'=>['width'=>'100px'],'title'=>'Detail']);
		}elseif ($model->STATUS==101){
			return Html::a('<i class="glyphicon glyphicon-time"></i> Proccess', '#',['class'=>'btn btn-warning btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==102){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> Checked', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==103){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> Approved', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}else{
			return Html::a('<i class="glyphicon glyphicon-question-sign"></i> Unknown', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		};
	}

	/**
	 * LINK  Note
	 * @author wawan  
     * @since 1.2
	*/
	function PoNote($kd){
			$title = Yii::t('app','');
			$options = [ 'id'=>'rqt-note-id',
						  'data-toggle'=>"modal",
						  'data-target'=>"#rqt-note-review",
						  'class'=>'btn btn-info btn-xs',
						  'title'=>'RQT Note'
			];
			$icon = '<span class="fa fa-plus fa-lg"></span>';
			$label = $icon . ' ' . $title;
			$url = Url::toRoute(['/purchasing/request-term/update-note','id'=>$kd]);
			$content = Html::a($label,$url, $options);
			return $content;
	}

	/*
	 * SIGNATURE AUTH3 | Approved
	 * Permission Edit [BTN_SIGN3==1] & [Status 0=soDetail 101=soHeader]
	*/
	function SignCreated($roHeader){
		if(getPermission()){
			if(getPermission()->BTN_EDIT==1 AND $roHeader->STATUS==0 ){
				$title = Yii::t('app', 'Sign Hire');
				$options = [ 'id'=>'ro-auth1-id',
							  'data-toggle'=>"modal",
							  'data-target'=>"#ro-auth1-sign",
							  'class'=>'btn btn-info btn-xs',
							  'style'=>['width'=>'100px'],
							  'title'=>'Signature'
				];
				$icon = '<span class="glyphicon glyphicon-retweet"></span>';
				$label = $icon . ' ' . $title;
				$url = Url::toRoute(['/purchasing/request-term/sign-auth1-view','kd'=>$roHeader->KD_RIB]);
				//$options1['tabindex'] = '-1';
				$content = Html::a($label,$url, $options);
				return $content;
			}else{
				$title = Yii::t('app', 'Sign Hire');
				$options = [ 'id'=>'confirm-permission-id',
							  'data-toggle'=>"modal",
							  'data-target'=>"#confirm-permission-alert",
							  'class'=>'btn btn-info btn-xs',
							  'style'=>['width'=>'100px'],
							  'title'=>'Signature'
				];
				$icon = '<span class="glyphicon glyphicon-retweet"></span>';
				$label = $icon . ' ' . $title;
				$content = Html::button($label, $options);
				return $content;
			}
		}
	}

	/*
	 * SIGNATURE AUTH2 | CHECKED
	 * Permission Edit [BTN_SIGN2==1] &  [Status 0/5/4/103=soDetail 102=soHeader]
	*/
	function SignChecked($roHeader){
		if(getPermission()){
				$title = Yii::t('app', 'Sign Hire');
				$options = [ 'id'=>'ro-auth2-id',
							  'data-toggle'=>"modal",
							  'data-target'=>"#ro-auth2-sign",
							  'class'=>'btn btn-success btn-xs',
							  'style'=>['width'=>'100px'],
							  'title'=>'Signature'
				];
				$icon = '<span class="glyphicon glyphicon-retweet"></span>';
				$label = $icon . ' ' . $title;
				$url = Url::toRoute(['/purchasing/request-term/sign-auth2-view','kd'=>$roHeader->KD_RIB]);
				//$options1['tabindex'] = '-1';
				$content = Html::a($label,$url, $options);
				return $content;
			}else{
				$title = Yii::t('app', 'Sign Hire');
				$options = [ 'id'=>'confirm-permission-id',
							  'data-toggle'=>"modal",
							  'data-target'=>"#confirm-permission-alert",
							  'class'=>'btn btn-info btn-xs',
							  'style'=>['width'=>'100px'],
							  'title'=>'Signature'
				];
				$icon = '<span class="glyphicon glyphicon-retweet"></span>';
				$label = $icon . ' ' . $title;
				$content = Html::button($label, $options);
				return $content;
			}
	}

	/*
	 * SIGNATURE AUTH3 | Approved
	 * Permission Edit [BTN_SIGN3==1] & [Status 4/5/103=soDetail 103=soHeader]
	*/
	function SignApproved($roHeader){
		if(getPermission()){
				$title = Yii::t('app', 'Sign Hire');
				$options = [ 'id'=>'ro-auth3-id',
							  'data-toggle'=>"modal",
							  'data-target'=>"#ro-auth3-sign",
							  'class'=>'btn btn-success btn-xs',
							  'style'=>['width'=>'100px'],
							  'title'=>'Signature'
				];
				$icon = '<span class="glyphicon glyphicon-retweet"></span>';
				$label = $icon . ' ' . $title;
				$url = Url::toRoute(['/purchasing/request-order/sign-auth3-view','kd'=>$roHeader->KD_RIB]);
				//$options1['tabindex'] = '-1';
				$content = Html::a($label,$url, $options);
				return $content;
			}else{
				$title = Yii::t('app', 'Sign Hire');
				$options = [ 'id'=>'confirm-permission-id',
							  'data-toggle'=>"modal",
							  'data-target'=>"#confirm-permission-alert",
							  'class'=>'btn btn-info btn-xs',
							  'style'=>['width'=>'100px'],
							  'title'=>'Signature'
				];
				$icon = '<span class="glyphicon glyphicon-retweet"></span>';
				$label = $icon . ' ' . $title;
				$content = Html::button($label, $options);
				return $content;
			}
	}

 	/*
	 * Tombol add Item Barang yang suda ada
	 * permission crate Ro
	 * RenderAjak to file : additem.php
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	function tombolAddItem($kd,$status) {
		if(getPermission()){
			if(getPermission()->BTN_EDIT==1 AND ($status==0)){
				$title1 = Yii::t('app', 'AddItem');
				$options1 = [ 'id'=>'add-item',
							  'data-toggle'=>"modal",
							  'data-target'=>"#additem-ro",
							  'class' => 'btn btn-warning btn-xs',
				];
				$icon1 = '<span class="fa fa-plus fa-xs"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$url1 = Url::toRoute(['/purchasing/request-order/additem','kd'=>$kd]);
				$content = Html::a($label1,$url1, $options1);
				return $content;
			}else{
				$title1 = Yii::t('app', 'AddItem');
				$options1 = [ 'id'=>'ro-tambah-detail',
							  'data-toggle'=>"modal",
							  'data-target'=>"#confirm-permission-alert",
							  'class' => 'btn btn-warning btn-xs',
							  //'data-confirm'=>'Permission ! You do not have permission for this module.',
				];
				$icon1 = '<span class="fa fa-plus fa-xs"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$url1 = Url::toRoute(['#']);
				$content = Html::a($label1,$url1, $options1);
				return $content;
			};
		}else{
				$title1 = Yii::t('app', 'AddItem');
				$options1 = [ 'id'=>'ro-tambah-detail',
							  'data-toggle'=>"modal",
							  'data-target'=>"#confirm-permission-alert",
							  'class' => 'btn btn-warning btn-xs',
							  //'data-confirm'=>'Permission ! You do not have permission for this module.',
				];
				$icon1 = '<span class="fa fa-plus fa-xs"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$url1 = Url::toRoute(['#']);
				$content = Html::a($label1,$url1, $options1);
				return $content;
		}
	}

		/**
	 * LINK  upload
	 * @author wawan  
     * @since 1.2
	*/
	function Upload($kd){
			$title = Yii::t('app','');
			$options = [ 'id'=>'rqt-upload-id',
						  'data-toggle'=>"modal",
						  'data-target'=>"#rqt-upload-review",
						  'class'=>'btn btn-info btn-xs',
						  'title'=>'Upload'
			];
			$icon = '<span class="fa fa-cloud-upload"></span>';
			$label = $icon . ' ' . $title;
			$url = Url::toRoute(['/purchasing/request-term/upload-term','id'=>$kd->KD_RIB,'trm_id'=>$kd->TERM_ID]);
			$content = Html::a($label,$url, $options);
			return $content;
	}

	/*
	 * Tombol add Item Barang baru
	 * permission crate Ro
	 * RenderAjak to file : additem.php
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	function tombolNewItem($kd,$status,$roHeader) {
		if(getPermission()){
			if((getPermission()->BTN_EDIT==1 AND ($status==0)) ){
				$title1 = Yii::t('app', 'New');
				$options1 = [ 'id'=>'add-new-item-id',
							  'data-toggle'=>"modal",
							  'data-target'=>"#add-new-item",
							  'class' => 'btn btn-warning btn-xs',
				];
				$icon1 = '<span class="fa fa-edit fa-xs"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$url1 = Url::toRoute(['/purchasing/request-term/add-new-invest','kd'=>$kd,'term_id'=>$roHeader->TERM_ID,'cust_kd'=>$roHeader->CUST_ID_PARENT]);
				$content = Html::a($label1,$url1, $options1);
				return $content;
			}else{
				$title1 = Yii::t('app', 'New');
				$options1 = [ 'id'=>'ro-tambah-detail',
							  'data-toggle'=>"modal",
							  'data-target'=>"#confirm-permission-alert",
							  'class' => 'btn btn-warning btn-xs',
							  //'data-confirm'=>'Permission ! You do not have permission for this module.',
				];
				$icon1 = '<span class="fa fa-plus fa-xs"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$url1 = Url::toRoute(['#']);
				$content = Html::a($label1,$url1, $options1);
				return $content;
			};
		}else{
				$title1 = Yii::t('app', 'AddItem');
				$options1 = [ 'id'=>'ro-tambah-detail',
							  'data-toggle'=>"modal",
							  'data-target'=>"#confirm-permission-alert",
							  'class' => 'btn btn-warning btn-xs',
							  //'data-confirm'=>'Permission ! You do not have permission for this module.',
				];
				$icon1 = '<span class="fa fa-plus fa-xs"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$url1 = Url::toRoute(['#']);
				$content = Html::a($label1,$url1, $options1);
				return $content;
		}
	}


	/*
	 * Tombol View Detail Barang
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	function tombolViewDetail($url, $model) {
		$title1 = Yii::t('app', '');
		$options1 = [ 'id'=>'item-detail-id',
					  'data-toggle'=>"modal",
					  'data-target'=>"#item-detailview",
					  //'class' => 'btn btn-warning btn-xs',
		];
		$icon1 = '<span class="fa fa-eye fa-lg"></span>';
		$label1 = $icon1 . ' ' . $title1;
		$url1 = Url::toRoute(['/purchasing/request-term/item-detail-view','kdro'=>$model->KD_RIB]);
		$content = Html::a($label1,$url1, $options1);
		return $content;
	}


?>

<div class="container-fluid" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
	<!-- HEADER !-->
	<div class="col-md-12">
		<div class="col-md-1" style="float:left;">
			<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>
		</div>
		<div class="col-md-9" style="padding-top:15px;">
			<!--<h3 class="text-center"><b>Form Permintaan Barang & Jasa</b></h3>!-->
			<h3 class="text-center"><b>EDITING REQUEST TERM</b></h3>
		</div>
			<dt style="float:left;">Status RT</dt>
			<dd>: <?=statusProcessRo($roHeader);?></dd>
		<div class="col-md-12" style="padding-left:0px;">
			<hr>
		</div>
	</div>
	<!-- Title Descript !-->
	<div class="col-md-12">
		<dl>
			  <dt style="width:100px; float:left;">Date</dt>
			  <dd>: <?php echo date('d-M-Y'); ?></dd>
			  <dt style="width:100px; float:left;">Kode Rqt</dt>
			  <dd>: <?php echo $roHeader->KD_RIB; ?></dd>
			  <dt style="width:100px; float:left;">Customers</dt>
			  <dd>: <?php echo $roHeader->cus->CUST_NM; ?></dd>
			  <dt style="width:100px; float:left;">Departement</dt>
			  <dd>:
				<?php
				
					if (count($dept)!=0){
						echo $dept->DEP_NM;
					}else{
						echo 'Dept Set';
					}
				?>
			</dd>
		</dl>
	</div>
	<!-- Table Grid List RO Detail !-->
	<div class="col-md-12">
		<div style="align:right;">
			<!-- <div style="float:left;margin-right:5px"><tombolAddItem($roHeader->KD_RIB,$roHeader->STATUS);?></div> -->
			<div><?=tombolNewItem($roHeader->KD_RIB,$roHeader->STATUS,$roHeader);?></div>
		</div>
		<div>
			<?php
				echo GridView::widget([
					'id'=>'rt-process',
					'dataProvider'=> $dataProvider,
					'filterModel' => '',
					//'headerRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.3); align:center'],
					'filterRowOptions'=>['style'=>'background-color:rgba(126, 189, 188, 0.3); align:center'],
					'beforeHeader'=>[
						[
							'columns'=>[
								['content'=>'', 'options'=>['colspan'=>2,'class'=>'text-center info',]],
								['content'=>'Quantity', 'options'=>['colspan'=>5, 'class'=>'text-center info']],
								['content'=>'Remark', 'options'=>['colspan'=>5, 'class'=>'text-center info']],
								//['content'=>'Action Status ', 'options'=>['colspan'=>1,  'class'=>'text-center info']],
							],
						]
					],
					'columns' => [
						[
							/* View detail Item */
							'class'=>'kartik\grid\ActionColumn',
							'header'=>'#',
							'template' => '{detail}',
							'buttons' => [
								/* Approved RO | Permissian Status 101 | Dept = Dept login | GF >= M ($roHeader->STATUS!=101 or $roHeader->STATUS!=10)*/
								'detail' => function ($url, $model){
												return tombolViewDetail($url, $model);
											 },
							],
							'headerOptions'=>[
							'style'=>[
								'text-align'=>'center',
								'width'=>'5px',
								'font-family'=>'verdana, arial, sans-serif',
								'font-size'=>'8pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)',
							]
							],
							'contentOptions'=>[
								'style'=>[
									'text-align'=>'center',
									'width'=>'5px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
								]
							],

						],
						[
							/* Attribute Serial No */
							'class'=>'kartik\grid\SerialColumn',
							'contentOptions'=>['class'=>'kartik-sheet-style'],
							'width'=>'10px',
							'header'=>'No.',
							'headerOptions'=>[
							'style'=>[
								'text-align'=>'center',
								'width'=>'10px',
								'font-family'=>'verdana, arial, sans-serif',
								'font-size'=>'8pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)',
							]
							],
							'contentOptions'=>[
								'style'=>[
									'text-align'=>'center',
									'width'=>'10px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
								]
							],
						],
						/* ['attribute'=>'ID',], */
						[
							/* Attribute Items Barang */
							'label'=>'Type Investasi',
							'attribute'=>'nminvest',
							'hAlign'=>'left',
							'vAlign'=>'middle',
							'mergeHeader'=>true,
							'format' => 'raw',
							'headerOptions'=>[
								'style'=>[
									'text-align'=>'center',
									'width'=>'150px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
									'background-color'=>'rgba(126, 189, 188, 0.3)',
								]
							],
							'contentOptions'=>[
								'style'=>[
									'text-align'=>'left',
									'width'=>'150px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
								]
							],
						],
						[
							/* Attribute Request Quantity */
							'class'=>'kartik\grid\EditableColumn',
							'attribute'=>'RQTY',
							'label'=>'Qty.Request',
							'vAlign'=>'middle',
							'hAlign'=>'center',
							'mergeHeader'=>true,
							'readonly'=>function($model, $key, $index, $widget) use ($headerStatus) {
								//return (101 == $model->STATUS || 10 == $model->STATUS  || 3 == $model->STATUS  || 4 == $model->STATUS);// or 101 == $roHeader->STATUS);
								return (0 <> $model->STATUS || 103==$headerStatus); // Allow Status Process = 0);
							},
							'editableOptions' => [
								'header' => 'Update Quantity',
								'inputType' => \kartik\editable\Editable::INPUT_TEXT,
								'size' => 'sm',
								'options' => [
								  'pluginOptions' => ['min'=>0, 'max'=>50000]
								]
							],
							'headerOptions'=>[
								'style'=>[
									'text-align'=>'center',
									'width'=>'60px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
									'background-color'=>'rgba(126, 189, 188, 0.3)',
								]
							],
							'contentOptions'=>[
								'style'=>[
									'text-align'=>'left',
									'width'=>'60px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
								]
							],
						],
						[
							/* Attribute Submit Quantity */
							'attribute'=>'SQTY',
							'label'=>'Qty.Submit',
							'mergeHeader'=>true,
							'vAlign'=>'middle',
							'hAlign'=>'center',
							'headerOptions'=>[
								'style'=>[
									'text-align'=>'center',
									'width'=>'60px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
									'background-color'=>'rgba(126, 189, 188, 0.3)',
								]
							],
							'contentOptions'=>[
								'style'=>[
									'text-align'=>'left',
									'width'=>'60px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
								]
							],
						],
						[
							/* Attribute Unit Barang */
							'attribute'=>'UNIT',
							'label'=>'Unit',
							'hAlign'=>'left',
							'vAlign'=>'middle',
							'mergeHeader'=>true,
							'value'=>function($model){
								$model=Unitbarang::find()->where('KD_UNIT="'.$model->UNIT. '"')->one();
								if (count($model)!=0){
									$UnitNm=$model->NM_UNIT;
								}else{
									$UnitNm='Not Set';
								}
								return $UnitNm;
							},
							'headerOptions'=>[
								'style'=>[
									'text-align'=>'center',
									'width'=>'120px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
									'background-color'=>'rgba(126, 189, 188, 0.3)',
								]
							],
							'contentOptions'=>[
								'style'=>[
									'text-align'=>'left',
									'width'=>'120px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
								]
							],
						],
						[
							/* Attribute HARGA SUPPLIER */
							'class'=>'kartik\grid\EditableColumn',
							'attribute'=>'HARGA',
							'value'=>function($model){
									number_format($model->HARGA,2);
								},
							'label'=>'Price/Pcs',
							'vAlign'=>'middle',
							'hAlign'=>'center',
							'mergeHeader'=>true,
							'readonly'=>function($model, $key, $index, $widget) use ($headerStatus) {
								//return (101 == $model->STATUS || 10 == $model->STATUS  || 3 == $model->STATUS  || 4 == $model->STATUS);// or 101 == $roHeader->STATUS);
								return (0 <> $model->STATUS || 103==$headerStatus); // Allow Status Process = 0);
							},
							'editableOptions' => [
								'header' => 'Update Price',
								'inputType' => \kartik\editable\Editable::INPUT_MONEY ,
								'size' => 'sm',
								// 'options' => [
								//   'pluginOptions' => ['min'=>0, 'max'=>50000]
								// ]
							],
							'headerOptions'=>[
								'style'=>[
									'text-align'=>'center',
									'width'=>'100px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
									'background-color'=>'rgba(126, 189, 188, 0.3)',
								]
							],
							'contentOptions'=>[
								'style'=>[
									'text-align'=>'right',
									'width'=>'100px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
								]
							],
						],
						[
							/* Attribute */
							'class'=>'kartik\grid\EditableColumn',
							'attribute'=>'NOMER_INVOCE',
							'label'=>'No Invoce',
							'vAlign'=>'middle',
							'hAlign'=>'center',
							'mergeHeader'=>true,
							'readonly'=>function($model, $key, $index, $widget) use ($headerStatus) {
								//return (101 == $model->STATUS || 10 == $model->STATUS  || 3 == $model->STATUS  || 4 == $model->STATUS);// or 101 == $roHeader->STATUS);
								return (0 <> $model->STATUS || 103==$headerStatus); // Allow Status Process = 0);
							},
							'editableOptions' => [
								'header' => 'Update Invoice',
								'inputType' => \kartik\editable\Editable::INPUT_TEXT,
								'size' => 'sm',
								'options' => [
									'pluginOptions' => ['min'=>0, 'max'=>50000]
								]
							],
							'headerOptions'=>[
								'style'=>[
									'text-align'=>'center',
									'width'=>'120px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
									'background-color'=>'rgba(126, 189, 188, 0.3)',
								]
							],
							'contentOptions'=>[
								'style'=>[
									'text-align'=>'left',
									'width'=>'120px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
								]
							],
						],
						[
							/* Attribute */
							'class'=>'kartik\grid\EditableColumn',
							'attribute'=>'NOMER_FAKTURPAJAK',
							'label'=>'No faktur',
							'vAlign'=>'middle',
							'hAlign'=>'center',
							'mergeHeader'=>true,
							'readonly'=>function($model, $key, $index, $widget) use ($headerStatus) {
								//return (101 == $model->STATUS || 10 == $model->STATUS  || 3 == $model->STATUS  || 4 == $model->STATUS);// or 101 == $roHeader->STATUS);
								// return (0 <> $model->STATUS || 103==$headerStatus); // Allow Status Process = 0);
							},
							'editableOptions' => [
								'header' => 'Update NoFaktur pajak',
								'inputType' => \kartik\editable\Editable::INPUT_TEXT,
								'size' => 'sm',
								'options' => [
									'pluginOptions' => ['min'=>0, 'max'=>50000]
								]
							],
							'headerOptions'=>[
								'style'=>[
									'text-align'=>'center',
									'width'=>'120px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
									'background-color'=>'rgba(126, 189, 188, 0.3)',
								]
							],
							'contentOptions'=>[
								'style'=>[
									'text-align'=>'left',
									'width'=>'120px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
								]
							],
						],
						[
							/* Attribute NOTE Barang */
							'class'=>'kartik\grid\EditableColumn',
							'attribute'=>'INVESTASI_PROGRAM',
							'label'=>'Notes',
							'hAlign'=>'left',
							'mergeHeader'=>true,
							'readonly'=>function($model, $key, $index, $widget) use ($headerStatus) {
								// return (0 <> $model->STATUS || 103==$headerStatus); // Allow Status Process = 0;
							},
							'editableOptions' => [
								'header' => 'Update program',
								'inputType' => \kartik\editable\Editable::INPUT_TEXTAREA,
								'size' => 'sm',
								'options' => [
								  // 'pluginOptions' => ['min'=>0, 'max'=>50000]
								]
							],
							'headerOptions'=>[
								'style'=>[
									'text-align'=>'center',
									'width'=>'200px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
									'background-color'=>'rgba(126, 189, 188, 0.3)',
								]
							],
							'contentOptions'=>[
								'style'=>[
									'text-align'=>'left',
									'width'=>'200px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
								]
							],
						],

						[
							/* Attribute Status Detail RO */
							'attribute'=>'STATUS',
							'label'=>'Status',
							'hAlign'=>'center',
							'vAlign'=>'middle',
							'mergeHeader'=>true,
							'contentOptions'=>['style'=>'width: 100px'],
							'format' => 'html',
							'value'=>function ($model, $key, $index, $widget) {
										return statusProcessRo($model);
							},
							'headerOptions'=>[
							'style'=>[
								'text-align'=>'center',
								'width'=>'100px',
								'font-family'=>'verdana, arial, sans-serif',
								'font-size'=>'8pt',
								'background-color'=>'rgba(126, 189, 188, 0.3)',
							]
							],
							'contentOptions'=>[
								'style'=>[
									'text-align'=>'center',
									'width'=>'100px',
									'font-family'=>'verdana, arial, sans-serif',
									'font-size'=>'8pt',
								]
							],
						],
					],
					'pjax'=>true,
					'pjaxSettings'=>[
					'options'=>[
						'enablePushState'=>false,
						'id'=>'rt-process',
					   ],
					],
					'hover'=>true, //cursor select
					'responsive'=>true,
					'responsiveWrap'=>true,
					'bordered'=>true,
					'striped'=>'4px',
					'autoXlFormat'=>true,
					'export' => false,
				]);
			?>
		</div>
	</div>

	<!-- PO Note !-->
	<div  class="row">
		<div  class="col-md-12" style="font-family: tahoma ;font-size: 9pt;">
			<dt><b>General Notes :</b></dt>
			<hr style="height:1px;margin-top: 1px; margin-bottom: 1px;font-family: tahoma ;font-size:8pt;">
			<div>
				<div style="float:right;text-align:right;">
					 <?= PoNote($roHeader->KD_RIB) ?>
				</div>
				<div style="margin-left:5px">
					<dd><?= $roHeader->NOTE ?></dd>
					<dt>Invoice exchange can be performed on Monday through Tuesday time of 09:00AM-16:00PM</dt>
				</div>
			</div>
			<hr style="height:1px;margin-top: 1px;">
		</div>
	</div>

	<!-- PO Note !-->
	<div  class="row">
		<div  class="col-md-12" style="font-family: tahoma ;font-size: 9pt;">
			<div style="margin-bottom:2%;">

				 <?= upload($roHeader) ?>
				 
					 <b> upload file</b>
				
			</div>
			
			
		</div>
	</div>

	<!-- Signature !-->
	<div  class="col-md-12">
		<div  class="row" >
			<div class="col-md-6">
				<table id="tblRo" class="table table-bordered" style="font-family: tahoma ;font-size: 8pt;">
					<!-- Tanggal!-->
					 <tr>
						<!-- Tanggal Pembuat RO!-->
						<th  class="col-md-1" style="text-align: center; height:20px">
							<div style="text-align:center;">
								<?php
									$placeTgl1=$roHeader->SIG1_TGL!=0 ? Yii::$app->ambilKonvesi->convert($roHeader->SIG1_TGL,'date') :'';
									echo '<b>Tanggerang</b>,' . $placeTgl1;
								?>
							</div>

						</th>
						<!-- Tanggal Pembuat RO!-->
						<th class="col-md-1" style="text-align: center; height:20px">
							<div style="text-align:center;">
								<?php
									$placeTgl2=$roHeader->SIG2_TGL!=0 ? Yii::$app->ambilKonvesi->convert($roHeader->SIG2_TGL,'date') :'';
									echo '<b>Tanggerang</b>,' . $placeTgl2;
								?>
							</div>

						</th>
						<!-- Tanggal PO Approved!-->
						<th class="col-md-1" style="text-align: center; height:20px">
							<div style="text-align:center;">
								<?php
									$placeTgl3=$roHeader->SIG3_TGL!=0 ? Yii::$app->ambilKonvesi->convert($roHeader->SIG3_TGL,'date') :'';
									echo '<b>Tanggerang</b>,' . $placeTgl3;
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
								/*
								 * STATUS AUTH3=101 CURRENT SIGNATURE
								 * @author ptrnov [piter@lukison]
								 * @since 1.2
								*/
								$ttd1 = $roHeader->SIG1_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$roHeader->SIG1_SVGBASE64.'></img>' :SignCreated($roHeader);
								echo $ttd1;
							?>
						</th>
						<th class="col-md-1" style="text-align: center; vertical-align:middle">
							<?php
								/*
								 * STATUS AUTH3=103 CURRENT SIGNATURE
								 * @author ptrnov [piter@lukison]
								 * @since 1.2
								*/
								$ttd2 = $roHeader->SIG2_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$roHeader->SIG2_SVGBASE64.'></img>' : SignChecked($roHeader);
								echo $ttd2;
							?>
						</th>
						<th  class="col-md-1" style="text-align: center; vertical-align:middle">
							<?php
								/*
								 * STATUS AUTH3=103 CURRENT SIGNATURE
								 * @author ptrnov [piter@lukison]
								 * @since 1.2
								*/
								$ttd3 = $roHeader->SIG3_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$roHeader->SIG3_SVGBASE64.'></img>' : SignApproved($roHeader);
								echo $ttd3;
							?>
						</th>
					</tr>
					<!--Nama !-->
					 <tr>
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
							<div>
								<?php
									$sigNm1=$roHeader->SIG1_NM!='none' ? '<b>'.$roHeader->SIG1_NM.'</b>' : 'none';
									echo $sigNm1;
								?>
							</div>
						</th>
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
							<div>
								<?php
									$sigNm2=$roHeader->SIG2_NM!='none' ? '<b>'.$roHeader->SIG2_NM.'</b>' : 'none';
									echo $sigNm2;
								?>
							</div>
						</th>
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(126, 189, 188, 0.3);text-align: center;">
							<div>
								<?php
									$sigNm3=$roHeader->SIG3_NM!='none' ? '<b>'.$roHeader->SIG3_NM.'</b>' : 'none';
									echo $sigNm3;
								?>
							</div>
						</th>
					</tr>
				</table>
			</div>
			<!-- Button Submit!-->
			<div style="text-align:right; margin-top:80px; margin-right:15px">
				<!-- Button Back!-->
				<a href="/purchasing/request-term" class="btn btn-info btn-xs" role="button" style="width:90px">Kembali</a>
				<!-- Button Cetak!-->
				<?php
					echo Html::a('<i class="fa fa-print fa-fw fa-xs"></i> Print', ['cetakpdf','kd'=>$roHeader->KD_RIB,'v'=>'0'], ['target' => '_blank', 'class' => 'btn btn-success btn-xs','style'=>['width'=>'90px']]);
				?>
				<?php
					echo Html::a('<i class="fa fa-print fa-fw fa-xs"></i> Print Tmp', ['temp-cetakpdf','kd'=>$roHeader->KD_RIB,'v'=>'0'], ['target' => '_blank', 'class' => 'btn btn-success btn-xs','style'=>['width'=>'90px']]);
				?>
			</div>
		</div>
	</div>
</div>
<?php
	/*
	 * JS Modal Add Items
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#additem-ro').on('show.bs.modal', function (event) {
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
		'id' => 'additem-ro',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-pencil-square-o"></div><div><h4 class="modal-title">Add Item</h4></div>',
		//'size' => 'modal-lg',
		'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(131, 160, 245, 0.5)',
			]
	]);
	Modal::end();


$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#rqt-upload-review').on('show.bs.modal', function (event) {
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
		'id' => 'rqt-upload-review',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-pencil-square-o"></div><div><h4 class="modal-title">Note</h4></div>',
		//'size' => 'modal-lg',
		'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(131, 160, 245, 0.5)',
			]
	]);
	Modal::end();

	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#rqt-note-review').on('show.bs.modal', function (event) {
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
		'id' => 'rqt-note-review',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-pencil-square-o"></div><div><h4 class="modal-title">Note</h4></div>',
		//'size' => 'modal-lg',
		'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(131, 160, 245, 0.5)',
			]
	]);
	Modal::end();


	

	/*
	 * JS Modal New Add Items
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#add-new-item').on('show.bs.modal', function (event) {
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
		'id' => 'add-new-item',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-pencil-square-o"></div><div><h4 class="modal-title">Add New Item</h4></div>',
		//'size' => 'modal-lg',
		'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(131, 160, 245, 0.5)',
			]
	]);
	Modal::end();

	/* Items Detail View
	 * JS Modal New Add Items
	 * @author ptrnov  <piter@lukison.com>
	 * @since 1.1
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#item-detailview').on('show.bs.modal', function (event) {
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
		'id' => 'item-detailview',
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-pencil-square-o"></div><div><h4 class="modal-title">Card Detal Items</h4></div>',
		//'size' => 'modal-lg',
		'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color: rgba(131, 160, 245, 0.5)',
			]
	]);
	Modal::end();

	/*SIGN AUTHOR1*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#ro-auth1-sign').on('show.bs.modal', function (event) {
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
			'id' => 'ro-auth1-sign',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Signature Authorize</b></h4></div>',
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
		]);
	Modal::end();

	/*SIGN AUTHOR2*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#ro-auth2-sign').on('show.bs.modal', function (event) {
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
			'id' => 'ro-auth2-sign',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Signature Authorize</b></h4></div>',
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
		]);
	Modal::end();

	/*SIGN AUTHOR3*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#ro-auth3-sign').on('show.bs.modal', function (event) {
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
			'id' => 'ro-auth3-sign',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Signature Authorize</b></h4></div>',
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
		]);
	Modal::end();

	/*
	 * Button Modal Confirm Popup
	 * @author ptrnov [piter@lukison]
	 * @since 1.2
	*/
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
			$('#confirm-permission-alert').on('show.bs.modal', function (event) {
				//var button = $(event.relatedTarget)
				//var modal = $(this)
				//var title = button.data('title')
				//var href = button.attr('href')
				//modal.find('.modal-title').html(title)
				//modal.find('.modal-body').html('')
				/* $.post(href)
					.done(function( data ) {
						modal.find('.modal-body').html(data)
					}); */
				}),
	",$this::POS_READY);
	Modal::begin([
			'id' => 'confirm-permission-alert',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/warning/denied.png',  ['class' => 'pnjg', 'style'=>'width:40px;height:40px;']).'</div><div style="margin-top:10px;"><h4><b>Permmission Confirm !</b></h4></div>',
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(142, 202, 223, 0.9)'
			]
		]);
		echo "<div>You do not have permission for this module.
				<dl>
					<dt>Contact : itdept@lukison.com</dt>
					<dt style='width:70px; float:left;'>Status RO</dt>
					<dd>:".statusProcessRo($roHeader)."</dd>
				</dl>
			</div>";
	Modal::end();

?>
