<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use lukisongroup\master\models\Unitbarang;
use lukisongroup\assets\AppAssetJqueryJSignature;
AppAssetJqueryJSignature::register($this); 
$this->sideCorp = 'ESM Request Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_esm';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Data Master');         /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

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
	 * Modul Name[1=RO]
	*/
	function getPermission(){
		if (Yii::$app->getUserOpt->Modul_akses(1)){
			return Yii::$app->getUserOpt->Modul_akses(1)->mdlpermission;
		}else{		
			return false;
		}	 
	} 
 
 $arrayStt= [
	  ['STATUS' => '0', 'name' => 'PROCESS'],
	  ['STATUS' => '1', 'name' => 'APPROVED'],
	  ['STATUS' => '3', 'name' => 'REJECT'],
	  ['STATUS' => '4', 'name' => 'DELETE'],
 ];
 $valStt = ArrayHelper::map($arrayStt, 'id', 'name');

 /*
 * STATUS Prosess Request Order
 * 1. PROCESS	=0 		| Pertama RO di buat
 * 2. APPROVED	=101	| Ro Sudah Di Approved
 * 3. DELETE	=3 		| Ro Di hapus oleh pembuat petama, jika belum di Approved
 * 4. REJECT	=4		| Ro tidak di setujui oleh Atasan manager keatas
 * 5. UNKNOWN	<>		| Ro tidak valid
*/
function statusProcessRo($model){
	if($model->STATUS==0){
		return Html::a('<i class="glyphicon glyphicon-retweet"></i> PROCESS', '#',['class'=>'btn btn-warning btn-xs', 'style'=>['width'=>'100px'],'title'=>'Detail']);
	}elseif ($model->STATUS==101){
		return Html::a('<i class="glyphicon glyphicon-ok"></i> APPROVED', '#',['class'=>'btn btn-success btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
	}elseif ($model->STATUS==3){
		return Html::a('<i class="glyphicon glyphicon-remove"></i> DELETE', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);						
	}elseif ($model->STATUS==4){
		return Html::a('<i class="glyphicon glyphicon-thumbs-down"></i> REJECT', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);
	}else{
		return Html::a('<i class="glyphicon glyphicon-question-sign"></i> UNKNOWN', '#',['class'=>'btn btn-danger btn-xs','style'=>['width'=>'100px'], 'title'=>'Detail']);	
	};		
}

function SignApproved(){
	return Html::a('<i class="glyphicon glyphicon-retweet"></i> Waiting for approval', '#',['class'=>'btn btn-warning btn-xs', 'style'=>['width'=>'160px'],'title'=>'Detail']);
} 
 
 
	/*
	 * Tombol Modul Create
	 * permission crate Ro
	*/
	function tombolAddItem($kd,$status){
		if(getPermission()){
			if(getPermission()->BTN_EDIT==1 AND $status<>101 ){
				$title1 = Yii::t('app', 'AddItem');
				$options1 = [ 'id'=>'add-item',	
							  'data-toggle'=>"modal",
							  'data-target'=>"#additem-ro",											
							  'class' => 'btn btn-warning',
				]; 
				$icon1 = '<span class="fa fa-plus fa-lg"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$url1 = Url::toRoute(['/purchasing/request-order/additem','kd'=>$kd]);
				$content = Html::a($label1,$url1, $options1);
				return $content;								
			}else{
				$title1 = Yii::t('app', 'AddItem');
				$options1 = [ 'id'=>'ro-tambah-detail',						  									
							  'class' => 'btn btn-warning',										  
							  'data-confirm'=>'Permission Failed, The data can not be changed !',
				]; 
				$icon1 = '<span class="fa fa-plus fa-lg"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$url1 = Url::toRoute(['#']);
				$content = Html::a($label1,$url1, $options1);
				return $content;
			}; 
		}else{
				$title1 = Yii::t('app', 'AddItem');
				$options1 = [ 'id'=>'ro-tambah-detail',						  									
							  'class' => 'btn btn-warning',										  
							  'data-confirm'=>'Permission Failed, The data can not be changed  !',
				]; 
				$icon1 = '<span class="fa fa-plus fa-lg"></span>';
				$label1 = $icon1 . ' ' . $title1;
				$url1 = Url::toRoute(['#']);
				$content = Html::a($label1,$url1, $options1);
				return $content;
		}				
	} 
 
?>

<div class="container" style="font-family: verdana, arial, sans-serif ;font-size: 8pt;">
	<!-- HEADER !-->
	<div class="col-md-12">
		<div class="col-md-1" style="float:left;">
			<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg', 'style'=>'width:100px;height:70px;']); ?>	
		</div>
		<div class="col-md-9" style="padding-top:15px;">
			<h3 class="text-center"><b>Form Permintaan Barang & Jasa</b></h3>				
		</div>
		<div class="col-md-11">
			<hr>
		</div>
	</div>
	<!-- Title Descript !-->
	<div class="col-md-11">
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
		</dl>
	</div>
	<!-- Table Grid List RO Detail !-->
	<div class="col-md-11">		
		<div style="align:right;">
			<?php
				//echo Html::a('<i class="fa fa-print fa-fw"></i> Cetak', ['cetakpdf','kd'=>$roHeader->KD_RO], ['target' => '_blank', 'class' => 'btn btn-success']);
				echo tombolAddItem($roHeader->KD_RO,$roHeader->STATUS);
				//print_r($roHeader->KD_RO);
			?>
		</div>			
		<div>
			<?php 				
				echo GridView::widget([
					'id'=>'ro-process',
					'dataProvider'=> $dataProvider,
					'filterModel' => '',
					'headerRowOptions'=>['style'=>'background-color:rgba(0, 95, 218, 0.3); align:center'],
					'filterRowOptions'=>['style'=>'background-color:rgba(0, 95, 218, 0.3); align:center'],
					'beforeHeader'=>[
						[
							'columns'=>[
								['content'=>'', 'options'=>['colspan'=>2,'class'=>'text-center info',]], 
								['content'=>'Quantity', 'options'=>['colspan'=>3, 'class'=>'text-center info']], 
								['content'=>'Remark', 'options'=>['colspan'=>2, 'class'=>'text-center info']], 
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
							'headerOptions'=>['class'=>'kartik-sheet-style']
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
							'contentOptions'=>['style'=>'width: 200px'], 
						],
						[
							/* Attribute Request Quantity */
							'class'=>'kartik\grid\EditableColumn',
							'attribute'=>'RQTY',
							'label'=>'Qty.Request',						
							'vAlign'=>'middle',
							'hAlign'=>'center',	
							'mergeHeader'=>true,
							'contentOptions'=>['style'=>'width: 60px'],
							'readonly'=>function($model, $key, $index, $widget) {
								return (101 == $model->STATUS);// or 101 == $roHeader->STATUS);
							},
							'editableOptions' => [
								'header' => 'Update Quantity',
								'inputType' => \kartik\editable\Editable::INPUT_TEXT,
								'options' => [
								  'pluginOptions' => ['min'=>0, 'max'=>50000]
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
							'contentOptions'=>['style'=>'width: 60px'],
						],
						[
							/* Attribute Unit Barang */
							'class'=>'kartik\grid\EditableColumn',
							'attribute'=>'UNIT',
							'label'=>'pcs',
							'hAlign'=>'left',						
							'vAlign'=>'middle',
							'mergeHeader'=>true,
							'contentOptions'=>['style'=>'width: 100px'], 
							'value'=>function($model){
								$model=Unitbarang::find()->where('KD_UNIT="'.$model->UNIT. '"')->one();
								if (count($model)!=0){
									$UnitNm=$model->NM_UNIT;
								}else{
									$UnitNm='Not Set';
								}
								return $UnitNm;
							}
						],
						[
							/* Attribute Unit Barang */
							'class'=>'kartik\grid\EditableColumn',
							'attribute'=>'NOTE',
							'label'=>'Noted',
							'hAlign'=>'left',						
							'mergeHeader'=>true,
							'contentOptions'=>[ 'style'=>'width: 200px'], 
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
									}	
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
	</div>
	
	<!-- Signature !-->
	<div  class="col-md-11">
		<?php 
			$tgl1 = explode(' ',$roHeader->CREATED_AT);
			$awl1 = explode('-',$tgl1[0]); 
			$blnAwl1 = date("F", mktime(0, 0, 0, $awl1[1], 1));
			
			$tgl2 = explode(' ',$roHeader->SIG2_TGL);
			$awl2 = explode('-',$tgl2[0]); 
			$blnAwl2 = date("F", mktime(0, 0, 0, $awl2[1], 1));		
			
		?>
		<div style="float:left;">
			<table id="tblRo" class="table table-bordered" style="width:550px;font-family: verdana, arial, sans-serif ;font-size: 8pt;">
				<!-- Tanggal!-->
				 <tr>
					<!-- Tanggal Pembuat RO!-->
					<th style="text-align: center; height:20px">
						<div style="margin-left:50px">
							<b>Tanggerang</b>, <?php echo ' '.$awl1[2].'-'.$blnAwl1.'-'.$awl1[0];  ?>
						</div> 
					
					</th>		
					<!-- Tanggal PO Approved!-->				
					<th style="text-align: center; height:20px">
						<div style="margin-left:50px">
							<b>Tanggerang</b>, <?php echo ' '.$awl2[2].'-'.$blnAwl2.'-'.$awl2[0];;  ?>
						</div> 				
					</th>	
				</tr>
				<!--Keterangan !-->
				 <tr>
					<th style="background-color:rgba(0, 95, 218, 0.3);text-align: center; height:20px">
						  Mengajukan,
					</th>								
					<th style="background-color:rgba(0, 95, 218, 0.3);text-align: center; height:20px">
						  Menyetujui,
					</th>	
				</tr>
				<!-- Signature !-->
				 <tr>
					<th style="text-align: center; vertical-align:middle;width:180; height:80px">
						<div id="ro-view-approval-sig1"><div>
					</th>								
					<th style="text-align: center; vertical-align:middle;width:180; height:80px">
						<?php 
							if ($roHeader->STATUS==101){
								echo '<div id="ro-view-approval-sig2">';
							}else{
								echo SignApproved();
							}
						?>						
					</th>
				</tr>
				<!--Nama !-->
				 <tr>
					<th style="text-align: center; vertical-align:middle;height:20">
						<div>		
							<b><?php  echo $roHeader->EMP_NM; ?></b>
						</div>
					</th>								
					<th style="text-align: center; vertical-align:middle;height:20">
						<div>		
							<b><?php  echo $roHeader->SIG2_NM; ?></b>
						</div>
					</th>
				</tr>
			</table>
		</div>
		<!-- Button Submit!-->
		<div style="text-align:right; margin-top:80px">
			<!-- Button Back!-->
			<a href="/purchasing/request-order" class="btn btn-info" role="button">Kembali</a>
			<!-- Button Cetak!-->
			<?php 
				echo Html::a('<i class="fa fa-print fa-fw"></i> Cetak', ['cetakpdf','kd'=>$roHeader->KD_RO], ['target' => '_blank', 'class' => 'btn btn-success']);
			?>				
		</div>
	</div>	
</div>
<?php
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
		'header' => '<div style="float:left;margin-right:10px" class="fa fa-2x fa-pencil-square-o"></div><div><h4 class="modal-title">Add New Item</h4></div>',
		//'size' => 'modal-lg',
		'headerOptions'=>[				
				//'style'=> 'border-radius:5px; background-color: rgba(0, 255, 52, 0.1)',
				//'style'=> 'border-radius:5px; background-color: rgba(45, 184, 255, 0.4)',
				//'style'=> 'border-radius:5px; background-color: rgba(215, 190, 203, 0.6)',
				//'style'=> 'border-radius:5px; background-color: rgba(215, 40, 40, 0.1)',
				//'style'=> 'border-radius:5px; background-color: rgba(215, 72, 30, 0.6)',
				//'style'=> 'border-radius:5px; background-color: rgba(215, 120, 30, 0.3)',
				//'style'=> 'border-radius:5px; background-color: rgba(255, 106, 0, 0.8)',
				'style'=> 'border-radius:5px; background-color: rgba(131, 160, 245, 0.5)',
				
				
				
			]
	]);
	Modal::end();
?>
