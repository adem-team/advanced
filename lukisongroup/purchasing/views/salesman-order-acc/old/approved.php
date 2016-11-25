<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
// use lukisongroup\assets\AppAssetJqueryJSignature;
// AppAssetJqueryJSignature::register($this); 

use lukisongroup\master\models\Unitbarang;

$this->sideCorp = 'Request Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'mDefault';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Data Master');         		 /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;               /* belum di gunakan karena sudah ada list sidemenu, on plan next*/
 
	/* LOCK STATUS TOMBOL */
	/* LOCK STATUS TOMBOL */
	 $headerStatus=$roHeader->STATUS;

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
 
	/*Status Sign Signature Login*/
	$arrayStt= [
		  ['status' => 0, 'DESCRIP' => 'PROCESS'],
		  ['status' => 1, 'DESCRIP' => 'PENDING'],
		  ['status' => 101, 'DESCRIP' => 'APPROVED'],
		  ['status' => 4, 'DESCRIP' => 'REJECT'],
	];
	$valStt = ArrayHelper::map($arrayStt, 'status', 'DESCRIP');

 
	/*
	 * Declaration Componen User Permission
	 * Function getPermission
	 * Modul Name[1=RO]
	*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses(1)){
			return Yii::$app->getUserOpt->Modul_akses(1);
		}else{		
			return false;
		}	 
	}
	//print_r(getPermission());
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
	//print_r(getPermissionEmp());
	
 
	 /*
	 * STATUS Prosess Request Order
	 * 1. PROCESS	=0 		| Pertama RO di buat
	 * 2. PENDING	=1		| Ro Tertunda
	 * 3. APPROVED	=101	| Ro Sudah Di Approved
	 * 4. COMPLETED	=10		| Ro Sudah selesai | RO->PO->RCVD
	 * 5. DELETE	=3 		| Ro Di hapus oleh pembuat petama, jika belum di Approved
	 * 6. REJECT	=4		| Ro tidak di setujui oleh Atasan manager keatas
	 * 7. UNKNOWN	<>		| Ro tidak valid
	*/
	function statusProcessRo($model){
		if($model->STATUS==0){
			return Html::a('<i class="glyphicon glyphicon-retweet"></i> PROCESS', '#',['class'=>'btn btn-warning btn-xs', 'style'=>['width'=>'100px'],'title'=>'Detail']);
		}elseif ($model->STATUS==1){
			return Html::a('<i class="glyphicon glyphicon-time"></i> PENDING', '#',['class'=>'btn btn-warning btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==101){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> APPROVED', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==10){
			return Html::a('<i class="glyphicon glyphicon-ok"></i> COMPLETED', '#',['class'=>'btn btn-info btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}elseif ($model->STATUS==3){
			return Html::a('<i class="glyphicon glyphicon-remove"></i> DELETE', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);						
		}elseif ($model->STATUS==4){
			return Html::a('<i class="glyphicon glyphicon-thumbs-down"></i> REJECT', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
		}else{
			return Html::a('<i class="glyphicon glyphicon-question-sign"></i> UNKNOWN', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);	
		};		
	} 
	
	/*
	 * SIGNATURE AUTH1 | CREATED
	 * Status Value Signature1 | PurchaseOrder
	 * Permission Edit [BTN_SIGN1==1] & [Status 0=process 1=CREATED]
	*/
	function SignCreated($roHeader){
		$title = Yii::t('app', 'Sign Hire');
		$options = [ 'id'=>'po-auth1',	
					  'data-toggle'=>"modal",
					  'data-target'=>"#po-auth1-sign",											
					  'class'=>'btn btn-danger btn-xs', 
					  'style'=>['width'=>'100px'],
					  'title'=>'Detail'
		]; 
		$icon = '<span class="glyphicon glyphicon-retweet"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/purchasing/sales-order/sign-created-view','kdpo'=>$roHeader->KD_RO]);
		//$options1['tabindex'] = '-1';
		$content = Html::a($label,$url, $options);
		return $content;	
	}
	
	/*
	 * SIGNATURE AUTH2 | CHECKED
	 * Status Value Signature1 | PurchaseOrder
	 * Permission Edit [BTN_SIGN1==1] & [Status 0=process 1=CREATED]
	*/
	function SignChecked($roHeader){
		$title = Yii::t('app', 'Sign Hire');
		$options = [ 'id'=>'po-auth1',	
					  'data-toggle'=>"modal",
					  'data-target'=>"#po-auth1-sign",											
					  'class'=>'btn btn-danger btn-xs', 
					  'style'=>['width'=>'100px'],
					  'title'=>'Detail'
		]; 
		$icon = '<span class="glyphicon glyphicon-retweet"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/purchasing/sales-order/sign-created-view','kdpo'=>$roHeader->KD_RO]);
		//$options1['tabindex'] = '-1';
		$content = Html::a($label,$url, $options);
		return $content;	
	}
	
	/*
	 * SIGNATURE AUTH3 | Approved
	 * Status Value Signature1 | PurchaseOrder
	 * Permission Edit [BTN_SIGN1==1] & [Status 0=process 101=Approved]
	*/
	function SignApproved($roHeader){
		$title = Yii::t('app', 'Sign Hire');
		$options = [ 'id'=>'emp-auth',	
					  'data-toggle'=>"modal",
					  'data-target'=>"#emp-auth-sign",											
					  'class'=>'btn btn-warning btn-xs', 
					  'style'=>['width'=>'150px'],
					  'title'=>'Detail'
		]; 
		$icon = '<span class="glyphicon glyphicon-retweet"></span>';
		$label = $icon . ' ' . $title;
		$url = Url::toRoute(['/purchasing/sales-order/approved_authorize','kd'=>$roHeader->KD_RO]);
		//$options1['tabindex'] = '-1';
		$content = Html::a($label,$url, $options);
		return $content;			
	}
	
	
	/*
	 * Tombol Modul Approval -> Check By User login
	 * Permission Edit [BTN_SIGN1==1] & [Status 0=process 101=Approved]
	 * EMP_ID=UserLogin & BTN_SIGN1==1 &  Status 0 = Action Edit Show/bisa edit
	 * EMP_ID=UserLogin & BTN_SIGN1==1 &  Status 0 = Action Edit Hide/tidak bisa edit
	 * 1. Hanya User login dengan permission modul RO=1 dengan BTN_SIGN1==1 dan Permission Jabatan SVP keatas yang bisa melakukan Approval (Tanpa Kecuali)
	 * 2. Action APPROVAL Akan close atau tidak bisa di lakukan jika sudah Approved | status Approved =101 | Permission sign1
	*/
	function tombolApproval($url, $model){
		if(getPermission()){
			//Permission Jabatan
			$a=getPermissionEmp()->JOBGRADE_ID;
			$b=getPermission()->BTN_SIGN1;
			if($a == 'SEVP' OR $a == 'EVP' OR $a == 'SVP' OR $a == 'VP' OR $a == 'AVP' OR $a == 'SM' OR $a == 'M' OR $a == 'AM' OR $a == 'S' AND $b==1 ){
				 if($model->STATUS == 0){ // 0=process 101=Approved
					$title = Yii::t('app', 'Approved');
					$options = [ 'id'=>'approved',
								 'data-pjax' => true,
								// 'data'=>['idc'=>$model->ID],
								 //'data-target'=>'#data-toggle-rodetail-approved',	
								 'data-toggle-approved'=>$model->ID,				
					]; 
					$icon = '<span class="glyphicon glyphicon-ok"></span>';
					$label = $icon . ' ' . $title;
					//$url = Url::toRoute(['/purchasing/sales-order/approved_rodetail','kd'=>$model->KD_RO]);
					//$url = Url::toRoute(['/purchasing/sales-order/approved']);
					//$url = Url::toRoute(['/purchasing/sales-order/approved_rodetail']);
					//$options['tabindex'] = '-1';
					return '<li>' . Html::a($label, '' , $options) . '</li>' . PHP_EOL;
				}
			}
		}	
	}
 
	/*
	 * Tombol Modul Reject -> Check By User login
	 * Permission Edit [BTN_SIGN1==1] & [Status 4=Reject]
	 */
	 
	function tombolReject($url, $model) {
		if(getPermission()){
			//Permission Jabatan
			$a=getPermissionEmp()->JOBGRADE_ID;
			$b=getPermission()->BTN_SIGN1;
			if($a == 'SEVP' OR $a == 'EVP' OR $a == 'SVP' OR $a == 'VP' OR $a == 'AVP' OR $a == 'SM' OR $a == 'M' OR $a == 'AM' OR $a == 'S' AND $b==1 ){
				 if($model->STATUS == 0){ // 0=process 4= Reject
					$title = Yii::t('app', 'Reject');
					$options = [ 'id'=>'reject',
								 'data-pjax'=>true,
								 'data-toggle-reject' => $model->ID							
					]; 
					$icon = '<span class="glyphicon glyphicon-ok"></span>';
					$label = $icon . ' ' . $title;
					//$url = Url::toRoute(['/purchasing/sales-order/approved','kd'=>$model->KD_RO]);
					//$url = Url::toRoute(['/purchasing/sales-order/approved']);
					//$url = Url::toRoute(['/purchasing/sales-order/approved']);
					$options['tabindex'] = '-1';
					return '<li>' . Html::a($label, '' , $options) . '</li>' . PHP_EOL;
				}
			}
		}	
	}
	/*
	 * Tombol Modul Cancel -> Check By User login
	 * Permission Edit [BTN_SIGN1==1] & [Status 0=Process]
	 * Cancel Back To Process
	*/ 
	function tombolCancel($url, $model){
		if(getPermission()){
			//Permission Jabatan
			$a=getPermissionEmp()->JOBGRADE_ID;
			$b=getPermission()->BTN_SIGN1;
			if($a == 'SEVP' OR $a == 'EVP' OR $a == 'SVP' OR $a == 'VP' OR $a == 'AVP' OR $a == 'SM' OR $a == 'M' OR $a == 'AM' OR $a == 'S' AND $b==1 ){
				 if($model->STATUS !== 101 or $model->STATUS !== 4 or $model->STATUS !== 3 or $model->STATUS !== 0){ // 0=process 4= Reject
					$title = Yii::t('app', 'Cancel');
					$options = [ 'id'=>'cancel',
								 'data-pjax'=>true,
								 'data-toggle-cancel' => $model->ID							
					]; 
					$icon = '<span class="glyphicon glyphicon-ok"></span>';
					$label = $icon . ' ' . $title;
					return '<li>' . Html::a($label, '' , $options) . '</li>' . PHP_EOL;
				}
			}
		}	
	}
	
	/*
	 * Tombol Modul Konci -> 
	 * Permission [Status 101=10]
	 * CLOSED 101 or 10
	*/ 
	function tombolKonci($url, $model){
		$title = Yii::t('app', 'LOCKED');
		$options = [ 'id'=>'closed']; 
		$icon = '<span class="glyphicon glyphicon-lock"></span>';
		$label = $icon . ' ' . $title;
		return '<li>' . Html::a($label, '' , $options) . '</li>' . PHP_EOL;	
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
			<h3 class="text-center"><b>FORM REVIEW SALES ORDER</b></h3>			
		</div>
		<div class="col-md-12" style="padding-left:0px;">
			<hr>
		</div>
	</div>
	<!-- Title Descript !-->
	<div class="col-md-12">
		<dl>
			<dt style="width:100px; float:left;">Date</dt>
			<dd>: <?php echo date('d-M-Y'); ?></dd>
			<dt style="width:100px; float:left;">Nomor</dt>
			<dd>: <?php echo $roHeader->KD_RO; ?></dd>     	  
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
			<dt style="width:100px; float:left;">Status RO</dt>	 
			<dd style="color:red">: 
			<?php 
				if ($headerStatus ==0){
					echo 'PROCESS';
				}elseif($headerStatus==1){
					echo 'PENDING';
				}elseif($headerStatus==101){
					echo 'APPROVED';
				}elseif($headerStatus==10){
					echo 'COMPLETED';
				}elseif($headerStatus==4){
					echo 'REJECT';
				}else{
					echo 'UNKNOWN';
				};
			?>
			</dd>
		</dl>
	</div>
	<!-- Table Grid List RO Detail !-->
	<div class="col-md-12">
		<?php 
			echo GridView::widget([
				'id'=>'ro-process',
				'dataProvider'=> $dataProvider,
				'filterModel' => '',
				//'headerRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
				'filterRowOptions'=>['style'=>'background-color:rgba(97, 211, 96, 0.3); align:center'],
				'beforeHeader'=>[
					[
						'columns'=>[
							['content'=>'', 'options'=>['colspan'=>2,'class'=>'text-center info',]], 
							['content'=>'Quantity', 'options'=>['colspan'=>3, 'class'=>'text-center info']], 
							['content'=>'Remark', 'options'=>['colspan'=>3, 'class'=>'text-center info']], 
							//['content'=>'Action Status ', 'options'=>['colspan'=>1,  'class'=>'text-center info']], 
						],
					]
				], 
				'columns' => [
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
								'background-color'=>'rgba(97, 211, 96, 0.3)',
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
						'label'=>'Items',
						'attribute'=>'NM_BARANG',
						'hAlign'=>'left',	
						'vAlign'=>'middle',
						'mergeHeader'=>true,
						'format' => 'raw',	
						'headerOptions'=>[				
							'style'=>[
								'text-align'=>'center',
								'width'=>'200px',
								'font-family'=>'verdana, arial, sans-serif',
								'font-size'=>'8pt',
								'background-color'=>'rgba(97, 211, 96, 0.3)',
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
						/* Attribute Request Quantity */
						'attribute'=>'RQTY',
						'label'=>'Qty.Request',						
						'vAlign'=>'middle',
						'hAlign'=>'center',	
						'mergeHeader'=>true,
						'headerOptions'=>[				
							'style'=>[
								'text-align'=>'center',
								'width'=>'60px',
								'font-family'=>'verdana, arial, sans-serif',
								'font-size'=>'8pt',
								'background-color'=>'rgba(97, 211, 96, 0.3)',
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
						'class'=>'kartik\grid\EditableColumn',
						'attribute'=>'SQTY',	
						'label'=>'Qty.Submit',
						'mergeHeader'=>true,											
						'vAlign'=>'middle',	
						'hAlign'=>'center',
						'readonly'=>function($model, $key, $index, $widget) use ($headerStatus) {
							return (0 <> $model->STATUS || 0<> $headerStatus); // Allow Status Process = 0;
						},
						'editableOptions' => [
							'header' => 'Update Quantity',
							'inputType' => \kartik\editable\Editable::INPUT_TEXT,
							'size' => 'sm',	
							'options' => [
							  'pluginOptions' => ['min'=>0, 'max'=>50000]
						    ]
						],
						//'width'=>'7%', 
						//'format'=>['decimal', 2],
						'headerOptions'=>[				
							'style'=>[
								'text-align'=>'center',
								'width'=>'60px',
								'font-family'=>'verdana, arial, sans-serif',
								'font-size'=>'8pt',
								'background-color'=>'rgba(97, 211, 96, 0.3)',
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
								'background-color'=>'rgba(97, 211, 96, 0.3)',
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
						/* Attribute Unit Barang */
						'class'=>'kartik\grid\EditableColumn',
						'attribute'=>'NOTE',
						'label'=>'Notes',
						'hAlign'=>'left',						
						'mergeHeader'=>true,
						'readonly'=>function($model, $key, $index, $widget) use ($headerStatus) {
								return (0 <> $model->STATUS || 0<> $headerStatus); // Allow Status Process = 0;
						},
						'editableOptions' => [
								'header' => 'Update Quantity',
								'inputType' => \kartik\editable\Editable::INPUT_TEXTAREA,
								'size' => 'md',	
								'options' => [
								  'pluginOptions' => ['min'=>0, 'max'=>50000]
								]
							],
						'headerOptions'=>[				
							'style'=>[
								'text-align'=>'center',
								'width'=>'200px',
								'font-family'=>'verdana, arial, sans-serif',
								'font-size'=>'8pt',
								'background-color'=>'rgba(97, 211, 96, 0.3)',
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
						'options'=>['id'=>'test-ro'],						
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
								'background-color'=>'rgba(97, 211, 96, 0.3)', 
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
					[
						'class'=>'kartik\grid\ActionColumn',
						'dropdown' => true,
						'template' => '{approved} {reject} {cancel} {closed}',
						'dropdownOptions'=>['class'=>'pull-right dropup'],									
						//'headerOptions'=>['class'=>'kartik-sheet-style'],
						'dropdownButton'=>['class'=>'btn btn-default btn-xs'],
						'buttons' => [						
							/* Approved RO | Permissian Status 101 | Dept = Dept login | GF >= M ($roHeader->STATUS!=101 or $roHeader->STATUS!=10)*/
							'approved' => function ($url, $model) use ($headerStatus) {
											if ($headerStatus!==101	 && $headerStatus!==10) {
												return tombolApproval($url, $model);
											}else{
											}
										},
							/* Reject RO | Permissian Status 4; | Dept = Dept login | GF >= M */
							'reject' => function ($url, $model) use ($headerStatus) {											
											if ($headerStatus!==101	 && $headerStatus!==10) {
												return tombolReject($url, $model);
											}
										},
							/* Cancel RO | Permissian Status 0; | Dept = Dept login | GF >= M */
							'cancel' => function ($url, $model) use ($headerStatus){
											if ($headerStatus!==101 && $headerStatus!==10) {
												return tombolCancel($url, $model);
											}
										},
							'closed' => function ($url, $model) use ($headerStatus){
											if ($headerStatus==101 OR $headerStatus==10) {
												//return Html::label('<i class="glyphicon glyphicon-lock dm"></i> LOCKED','',['class'=>'label label-danger','style'=>['align'=>'center']]);
												return  tombolKonci($url, $model);
											}
										},
						],
						'headerOptions'=>[				
							'style'=>[
								'text-align'=>'center',
								'width'=>'100px',
								'font-family'=>'verdana, arial, sans-serif',
								'font-size'=>'8pt',
								'background-color'=>'rgba(97, 211, 96, 0.3)', 
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
					'id'=>'ro-process',
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
					<!-- Signature !-->
					 <tr>
						<th class="col-md-1" style="text-align: center; vertical-align:middle; height:40px">
							<?php 
								$ttd1 = $roHeader->SIG1_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$roHeader->SIG1_SVGBASE64.'></img>' :SignCreated($roHeader);
								echo $ttd1;
							?> 
						</th>								
						<th class="col-md-1" style="text-align: center; vertical-align:middle">
							<?php 
								$ttd2 = $roHeader->SIG2_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$roHeader->SIG2_SVGBASE64.'></img>' : SignChecked($roHeader);
								echo $ttd2;
							?> 
						</th>
						<th  class="col-md-1" style="text-align: center; vertical-align:middle">
							<?php 
								$ttd3 = $roHeader->SIG3_SVGBASE64!='' ?  '<img style="width:80; height:40px" src='.$roHeader->SIG3_SVGBASE64.'></img>' : SignApproved($roHeader);
								echo $ttd3;
							?> 
						</th>
					</tr>
					<!--Nama !-->
					 <tr>
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(97, 211, 96, 0.3);text-align: center;">
							<div>		
								<?php
									$sigNm1=$roHeader->SIG1_NM!='none' ? '<b>'.$roHeader->SIG1_NM.'</b>' : 'none';
									echo $sigNm1;
								?>
							</div>
						</th>								
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(97, 211, 96, 0.3);text-align: center;">
							<div>		
								<?php
									$sigNm2=$roHeader->SIG2_NM!='none' ? '<b>'.$roHeader->SIG2_NM.'</b>' : 'none';
									echo $sigNm2;
								?>
							</div>
						</th>
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20; background-color:rgba(97, 211, 96, 0.3);text-align: center;">
							<div>		
								<?php
									$sigNm3=$roHeader->SIG3_NM!='none' ? '<b>'.$roHeader->SIG3_NM.'</b>' : 'none';
									echo $sigNm3;
								?>
							</div>
						</th>
					</tr>
					<!-- Department|Jbatan !-->
					 <tr>
						<th  class="col-md-1" style="text-align: center; vertical-align:middle;height:20">
							<div>		
								<b><?php  echo 'Created'; ?></b>
							</div>
						</th>								
						<th class="col-md-1"  style="text-align: center; vertical-align:middle;height:20">
							<div>		
								<b><?php  echo 'Checked'; ?></b>
							</div>
						</th>
						<th class="col-md-1" style="text-align: center; vertical-align:middle;height:20">
							<div>		
								<b><?php  echo 'Approved'; ?></b>
							</div>
						</th>
					</tr>
				</table>				
			</div>
			<!-- Button Submit!-->
			<div style="text-align:right; margin-top:80px; margin-right:15px">
				<!-- Button Back!-->
				<a href="/purchasing/sales-order" class="btn btn-info btn-xs" role="button" style="width:90px">Back</a>
				<!-- Button Cetak!-->
				<?php 
					echo Html::a('<i class="fa fa-print fa-fw fa-xs"></i> Print', ['cetakpdf','kd'=>$roHeader->KD_RO,'v'=>'101'], ['target' => '_blank', 'class' => 'btn btn-success btn-xs','style'=>['width'=>'90px']]);
				?>				
			</div>
		</div>
		
	</div>	
</div>
<?php
	$this->registerJs("
		$(document).on('click', '[data-toggle-approved]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-approved');
			$.ajax({
					//url: '/purchasing/sales-order/approved_rodetail?id=' + idx,
					url: '/purchasing/sales-order/approved_rodetail',
					type: 'POST',
					//contentType: 'application/json; charset=utf-8',
					data:'id='+idx,
					dataType: 'json',
					success: function(result) {
						if (result == 1){
							// Success
							$.pjax.reload({container-fluid:'#ro-process'});
						} else {
							// Fail
						}
					}
				});

		});
		$(document).on('click', '[data-toggle-reject]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-reject');
			$.ajax({
					url: '/purchasing/sales-order/reject_rodetail',
					type: 'POST',
					//contentType: 'application/json; charset=utf-8',
					data:'id='+idx,
					dataType: 'json',
					success: function(result) {
						if (result == 1){
							$.pjax.reload({container-fluid:'#ro-process'});
						} 
					}
				});
		});
		
		$(document).on('click', '[data-toggle-cancel]', function(e){
			e.preventDefault();
			var idx = $(this).data('toggle-cancel');
			$.ajax({
					url: '/purchasing/sales-order/cancel_rodetail',
					type: 'POST',
					//contentType: 'application/json; charset=utf-8',
					data:'id='+idx,
					dataType: 'json',
					success: function(result) {
						if (result == 1){
							$.pjax.reload({container-fluid:'#ro-process'});
						} 
					}
				});
		});
		
	",$this::POS_READY);
	
	$this->registerJs("
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};	
			$('#emp-auth-sign').on('show.bs.modal', function (event) {
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
			'id' => 'emp-auth-sign',
			//'header' => '<h4 class="modal-title">Signature Authorize</h4>',
			'header' => '<div style="float:left;margin-right:10px">'. Html::img('@web/img_setting/login/login1.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']).'</div><div style="margin-top:10px;"><h4><b>Signature Authorize</b></h4></div>',
			//'size' => 'modal-xs'
			'size' => Modal::SIZE_SMALL,
			'headerOptions'=>[
				'style'=> 'border-radius:5px; background-color:rgba(230, 251, 225, 1)'
			]
		]);
	Modal::end();
?>
			