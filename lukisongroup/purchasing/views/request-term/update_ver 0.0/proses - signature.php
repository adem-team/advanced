<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use lukisongroup\assets\AppAssetJquerySignature_1_1_2;
AppAssetJquerySignature_1_1_2::register($this); 
/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\ro\Requestorder */

$this->sideCorp = 'ESM Request Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_esm';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Data Master');         /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


/* $this->registerJs('
			var  jsonData1= $.ajax({
			  url: "http://api.lukisongroup.com/login/signatures?id=2",
			  type: "GET",
			  dataType:"json",
			  //data:"id_user='. Yii::$app->user->identity->id.'&pilih=0", /*[0=Dept,1=user]
			  async: false
			  }).responseText;		  
			  var myData = jsonData;
			  
			$(document).ready(function() {
				$('#sigPad').signaturePad({displayOnly:true}).regenerate(nilai.signature);
			});
		
	',$this::POS_READY) */;

	//$this->registerJsFile('http://lukisongroup.com/angular/signature/js/jquery.min.js',['position' => \yii\web\View::POS_HEAD],1); 
	//$this->registerJs('var $i = jQuery.noConflict();alert($i.fn.jquery);',$this::POS_HEAD,1);
	//$this->registerJsFile('http://lukisongroup.com/angular/signature/jquery.signaturepad.js',['position' => \yii\web\View::POS_BEGIN]);
	//$this->registerJsFile('http://lukisongroup.com/angular/signature/jquery.signaturepad.min.js',['position' => \yii\web\View::POS_BEGIN]);
	//$this->registerJsFile('http://lukisongroup.com/angular/signature/assets/json2.min.js');
	//$this->registerJsFile('http://lukisongroup.com/angular/signature/assets/flashcanvas.js');
	//$this->registerJsFile('http://lukisongroup.com/angular/signature/js/jquery.min.js');
?>



<div class="requestorder-view" style="margin:0px 20px;">
<style>
.kbw-signature { width: 400px; height: 200px; }
</style>
    <center>
		<h2 style="margin-bottom:0px;"><b>Form Permintaan Barang</b></h2>
		<h3 style="margin-top:0px;">Nomor : <?php echo $reqro->KD_RO; ?></h3>
	</center>

    <!-- p>
        < ?= Html::a('Update', ['update', 'id' => $reqro->ID], ['class' => 'btn btn-primary']) ?>
        < ?= Html::a('Delete', ['delete', 'id' => $reqro->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p -->

    <!-- ?= DetailView::widget([
        'model' => $reqro,
        'attributes' => [
            'ID',
            'KD_RO',
            'NOTE:ntext',
            'ID_USER',
            'KD_CORP',
            'KD_CAB',
            'KD_DEP',
            'STATUS',
            'CREATED_AT',
            'UPDATED_ALL',
            'DATA_ALL:ntext',
        ],
    ]) ? -->
<br/>

		<form action="/purchasing/request-order/simpanproses" method="post">
    <table class="table table-striped" style="background-color:#fff; border:1px solid #7D7DB2; ">
        <thead style="background-color:#A1A1E6; ">
            <th>No.</th>            
            <th>Kode Barang</th>
			<th>Nama Barang</th>
            <th>Quantity</th>
            <th>Satuan Barang</th>
            <th>Catatan</th>
            <th></th>
        </thead>


        <tbody>
		<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
		<input type="hidden" name="kd" value="<?php echo $reqro->KD_RO; ?>" />
        <?php 
			$sts = 1; $no=0; 
			foreach($detro as $ro){ 
			$no=$no+1; 
			
			if($ro->STATUS == 3) {} else { if($ro->STATUS == 0 ){ $sts=0; }
		?>
            <tr>
                <td><?php echo $no; ?></td>
				<td><?php echo $ro->KD_BARANG; ?></td>
                <td><?php echo $ro->NM_BARANG; ?></td>                
                <td><?php echo $ro->RQTY; ?></td>
                <td><?php echo $ro->UNIT; ?></td>
                <td><?php echo $ro->NOTE; ?></td>
                <td><?php if($ro->STATUS == 0){ ?><input type="checkbox" value="<?php echo $ro->ID; ?>" name="ck[]" /><?php } else { echo '<i class="fa fa-check" style="color:blue;"></i>'; } ?></td>
            </tr>
			<?php } } ?>
        </tbody>
    </table>
	
	<!-- div style="text-align:left; float:left;">
	<?php 
		echo Html::a('<i class="fa fa-print fa-fw"></i> Cetak', ['cetakpdf','kd'=>$reqro->KD_RO], ['target' => '_blank', 'class' => 'btn btn-warning']);
	?>
	</div -->
	
	<div style="text-align:right;">
		<?php if($sts == 0){ ?><button type="submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;&nbsp;Terima RO</button><?php } ?>
	</div>
	<div style="clear:both;"></div>
<br/>
<?php 


    $tgl = explode(' ',$reqro->CREATED_AT);
    $awl = explode('-',$tgl[0]); 
    $blnAwl = date("F", mktime(0, 0, 0, $awl[1], 1));
?>
<div class="row">
  <div class="col-md-8">
</div>
  <div class="col-md-4">
  <b>Tanggerang, <?php echo $awl[2].' - '.$blnAwl.' - '.$awl[0];  ?></b><br/>
  yang mengajukan,
  <br/><br/><br/><br/>
  <!--<div ng-app="AppSignature" ng-controller="CtrlSignature" >!-->
 <!-- {{9+1}} 
  
	 {{nilai.signature}}!-->
	 <div >
	<?php
	
			/* //var sig=[{"lx":15,"ly":47,"mx":15,"my":46},{"lx":15,"ly":47,"mx":15,"my":47},{"lx":16,"ly":44,"mx":15,"my":47},{"lx":19,"ly":39,"mx":16,"my":44},{"lx":22,"ly":34,"mx":19,"my":39},{"lx":24,"ly":25,"mx":22,"my":34},{"lx":25,"ly":17,"mx":24,"my":25},{"lx":28,"ly":10,"mx":25,"my":17},{"lx":30,"ly":7,"mx":28,"my":10},{"lx":32,"ly":5,"mx":30,"my":7},{"lx":33,"ly":3,"mx":32,"my":5},{"lx":34,"ly":3,"mx":33,"my":3},{"lx":35,"ly":3,"mx":34,"my":3},{"lx":37,"ly":3,"mx":35,"my":3},{"lx":39,"ly":3,"mx":37,"my":3},{"lx":41,"ly":3,"mx":39,"my":3},{"lx":42,"ly":3,"mx":41,"my":3},{"lx":42,"ly":4,"mx":42,"my":3},{"lx":43,"ly":4,"mx":42,"my":4},{"lx":44,"ly":6,"mx":43,"my":4},{"lx":45,"ly":6,"mx":44,"my":6},{"lx":45,"ly":8,"mx":45,"my":6},{"lx":46,"ly":9,"mx":45,"my":8},{"lx":47,"ly":10,"mx":46,"my":9},{"lx":47,"ly":11,"mx":47,"my":10},{"lx":47,"ly":12,"mx":47,"my":11},{"lx":47,"ly":14,"mx":47,"my":12},{"lx":45,"ly":16,"mx":47,"my":14},{"lx":42,"ly":18,"mx":45,"my":16},{"lx":37,"ly":20,"mx":42,"my":18},{"lx":33,"ly":22,"mx":37,"my":20},{"lx":28,"ly":23,"mx":33,"my":22},{"lx":25,"ly":24,"mx":28,"my":23},{"lx":21,"ly":25,"mx":25,"my":24},{"lx":16,"ly":26,"mx":21,"my":25},{"lx":14,"ly":26,"mx":16,"my":26},{"lx":12,"ly":26,"mx":14,"my":26},{"lx":11,"ly":26,"mx":12,"my":26},{"lx":10,"ly":26,"mx":11,"my":26},{"lx":15,"ly":11,"mx":15,"my":10},{"lx":15,"ly":11,"mx":15,"my":11},{"lx":14,"ly":10,"mx":15,"my":11},{"lx":13,"ly":12,"mx":14,"my":10},{"lx":11,"ly":15,"mx":13,"my":12},{"lx":11,"ly":17,"mx":11,"my":15},{"lx":11,"ly":19,"mx":11,"my":17},{"lx":11,"ly":20,"mx":11,"my":19},{"lx":11,"ly":21,"mx":11,"my":20},{"lx":12,"ly":22,"mx":11,"my":21},{"lx":13,"ly":24,"mx":12,"my":22},{"lx":14,"ly":25,"mx":13,"my":24},{"lx":16,"ly":26,"mx":14,"my":25},{"lx":19,"ly":27,"mx":16,"my":26},{"lx":24,"ly":28,"mx":19,"my":27},{"lx":36,"ly":32,"mx":24,"my":28},{"lx":49,"ly":34,"mx":36,"my":32},{"lx":64,"ly":36,"mx":49,"my":34},{"lx":80,"ly":36,"mx":64,"my":36},{"lx":92,"ly":36,"mx":80,"my":36},{"lx":100,"ly":36,"mx":92,"my":36},{"lx":106,"ly":36,"mx":100,"my":36},{"lx":110,"ly":36,"mx":106,"my":36},{"lx":111,"ly":36,"mx":110,"my":36},{"lx":112,"ly":36,"mx":111,"my":36},{"lx":112,"ly":34,"mx":112,"my":36},{"lx":112,"ly":33,"mx":112,"my":34},{"lx":112,"ly":28,"mx":112,"my":33},{"lx":112,"ly":23,"mx":112,"my":28},{"lx":112,"ly":19,"mx":112,"my":23},{"lx":112,"ly":14,"mx":112,"my":19},{"lx":112,"ly":11,"mx":112,"my":14},{"lx":111,"ly":8,"mx":112,"my":11},{"lx":110,"ly":8,"mx":111,"my":8},{"lx":109,"ly":8,"mx":110,"my":8},{"lx":107,"ly":8,"mx":109,"my":8},{"lx":103,"ly":11,"mx":107,"my":8},{"lx":95,"ly":17,"mx":103,"my":11},{"lx":87,"ly":24,"mx":95,"my":17},{"lx":80,"ly":33,"mx":87,"my":24},{"lx":77,"ly":36,"mx":80,"my":33},{"lx":76,"ly":39,"mx":77,"my":36},{"lx":76,"ly":40,"mx":76,"my":39},{"lx":76,"ly":41,"mx":76,"my":40},{"lx":78,"ly":42,"mx":76,"my":41},{"lx":80,"ly":42,"mx":78,"my":42},{"lx":85,"ly":42,"mx":80,"my":42},{"lx":89,"ly":42,"mx":85,"my":42},{"lx":93,"ly":40,"mx":89,"my":42},{"lx":97,"ly":37,"mx":93,"my":40},{"lx":100,"ly":34,"mx":97,"my":37},{"lx":102,"ly":32,"mx":100,"my":34},{"lx":103,"ly":31,"mx":102,"my":32},{"lx":103,"ly":30,"mx":103,"my":31},{"lx":104,"ly":30,"mx":103,"my":30},{"lx":105,"ly":30,"mx":104,"my":30},{"lx":106,"ly":33,"mx":105,"my":30},{"lx":107,"ly":34,"mx":106,"my":33},{"lx":108,"ly":36,"mx":107,"my":34},{"lx":110,"ly":36,"mx":108,"my":36},{"lx":114,"ly":36,"mx":110,"my":36},{"lx":119,"ly":36,"mx":114,"my":36},{"lx":123,"ly":32,"mx":119,"my":36},{"lx":126,"ly":28,"mx":123,"my":32},{"lx":126,"ly":24,"mx":126,"my":28},{"lx":126,"ly":23,"mx":126,"my":24},{"lx":124,"ly":29,"mx":126,"my":23},{"lx":121,"ly":37,"mx":124,"my":29},{"lx":117,"ly":43,"mx":121,"my":37},{"lx":116,"ly":45,"mx":117,"my":43},{"lx":116,"ly":43,"mx":116,"my":45},{"lx":117,"ly":36,"mx":116,"my":43},{"lx":120,"ly":30,"mx":117,"my":36},{"lx":122,"ly":28,"mx":120,"my":30},{"lx":125,"ly":24,"mx":122,"my":28},{"lx":127,"ly":22,"mx":125,"my":24},{"lx":128,"ly":21,"mx":127,"my":22},{"lx":130,"ly":21,"mx":128,"my":21},{"lx":131,"ly":21,"mx":130,"my":21},{"lx":133,"ly":21,"mx":131,"my":21},{"lx":134,"ly":21,"mx":133,"my":21},{"lx":134,"ly":22,"mx":134,"my":21},{"lx":134,"ly":24,"mx":134,"my":22},{"lx":134,"ly":27,"mx":134,"my":24},{"lx":131,"ly":30,"mx":134,"my":27},{"lx":127,"ly":32,"mx":131,"my":30},{"lx":125,"ly":33,"mx":127,"my":32},{"lx":126,"ly":33,"mx":125,"my":33},{"lx":130,"ly":33,"mx":126,"my":33},{"lx":133,"ly":33,"mx":130,"my":33},{"lx":138,"ly":33,"mx":133,"my":33},{"lx":144,"ly":33,"mx":138,"my":33},{"lx":145,"ly":33,"mx":144,"my":33},{"lx":146,"ly":33,"mx":145,"my":33},{"lx":146,"ly":31,"mx":146,"my":33},{"lx":146,"ly":27,"mx":146,"my":31},{"lx":146,"ly":23,"mx":146,"my":27},{"lx":149,"ly":18,"mx":146,"my":23},{"lx":151,"ly":16,"mx":149,"my":18},{"lx":152,"ly":15,"mx":151,"my":16},{"lx":153,"ly":15,"mx":152,"my":15},{"lx":153,"ly":17,"mx":153,"my":15},{"lx":153,"ly":24,"mx":153,"my":17},{"lx":153,"ly":31,"mx":153,"my":24},{"lx":153,"ly":36,"mx":153,"my":31},{"lx":152,"ly":40,"mx":153,"my":36},{"lx":152,"ly":41,"mx":152,"my":40},{"lx":152,"ly":38,"mx":152,"my":41},{"lx":152,"ly":33,"mx":152,"my":38},{"lx":152,"ly":29,"mx":152,"my":33},{"lx":152,"ly":27,"mx":152,"my":29},{"lx":152,"ly":26,"mx":152,"my":27},{"lx":153,"ly":25,"mx":152,"my":26},{"lx":154,"ly":25,"mx":153,"my":25},{"lx":156,"ly":25,"mx":154,"my":25},{"lx":159,"ly":27,"mx":156,"my":25},{"lx":161,"ly":28,"mx":159,"my":27},{"lx":162,"ly":28,"mx":161,"my":28},{"lx":163,"ly":30,"mx":162,"my":28},{"lx":164,"ly":30,"mx":163,"my":30},{"lx":165,"ly":30,"mx":164,"my":30},{"lx":166,"ly":30,"mx":165,"my":30},{"lx":167,"ly":28,"mx":166,"my":30},{"lx":168,"ly":26,"mx":167,"my":28},{"lx":168,"ly":22,"mx":168,"my":26},{"lx":168,"ly":20,"mx":168,"my":22},{"lx":168,"ly":19,"mx":168,"my":20}];
			//var $jnoc = $.noConflict();
			//$x = $.noConflict(true);
			//(function($x) { 
				$i("document").ready(function() {
					$i(".sigPad").signaturePad({displayOnly:true}).regenerate([{"lx":15,"ly":47,"mx":15,"my":46},{"lx":15,"ly":47,"mx":15,"my":47},{"lx":16,"ly":44,"mx":15,"my":47},{"lx":19,"ly":39,"mx":16,"my":44},{"lx":22,"ly":34,"mx":19,"my":39},{"lx":24,"ly":25,"mx":22,"my":34},{"lx":25,"ly":17,"mx":24,"my":25},{"lx":28,"ly":10,"mx":25,"my":17},{"lx":30,"ly":7,"mx":28,"my":10},{"lx":32,"ly":5,"mx":30,"my":7},{"lx":33,"ly":3,"mx":32,"my":5},{"lx":34,"ly":3,"mx":33,"my":3},{"lx":35,"ly":3,"mx":34,"my":3},{"lx":37,"ly":3,"mx":35,"my":3},{"lx":39,"ly":3,"mx":37,"my":3},{"lx":41,"ly":3,"mx":39,"my":3},{"lx":42,"ly":3,"mx":41,"my":3},{"lx":42,"ly":4,"mx":42,"my":3},{"lx":43,"ly":4,"mx":42,"my":4},{"lx":44,"ly":6,"mx":43,"my":4},{"lx":45,"ly":6,"mx":44,"my":6},{"lx":45,"ly":8,"mx":45,"my":6},{"lx":46,"ly":9,"mx":45,"my":8},{"lx":47,"ly":10,"mx":46,"my":9},{"lx":47,"ly":11,"mx":47,"my":10},{"lx":47,"ly":12,"mx":47,"my":11},{"lx":47,"ly":14,"mx":47,"my":12},{"lx":45,"ly":16,"mx":47,"my":14},{"lx":42,"ly":18,"mx":45,"my":16},{"lx":37,"ly":20,"mx":42,"my":18},{"lx":33,"ly":22,"mx":37,"my":20},{"lx":28,"ly":23,"mx":33,"my":22},{"lx":25,"ly":24,"mx":28,"my":23},{"lx":21,"ly":25,"mx":25,"my":24},{"lx":16,"ly":26,"mx":21,"my":25},{"lx":14,"ly":26,"mx":16,"my":26},{"lx":12,"ly":26,"mx":14,"my":26},{"lx":11,"ly":26,"mx":12,"my":26},{"lx":10,"ly":26,"mx":11,"my":26},{"lx":15,"ly":11,"mx":15,"my":10},{"lx":15,"ly":11,"mx":15,"my":11},{"lx":14,"ly":10,"mx":15,"my":11},{"lx":13,"ly":12,"mx":14,"my":10},{"lx":11,"ly":15,"mx":13,"my":12},{"lx":11,"ly":17,"mx":11,"my":15},{"lx":11,"ly":19,"mx":11,"my":17},{"lx":11,"ly":20,"mx":11,"my":19},{"lx":11,"ly":21,"mx":11,"my":20},{"lx":12,"ly":22,"mx":11,"my":21},{"lx":13,"ly":24,"mx":12,"my":22},{"lx":14,"ly":25,"mx":13,"my":24},{"lx":16,"ly":26,"mx":14,"my":25},{"lx":19,"ly":27,"mx":16,"my":26},{"lx":24,"ly":28,"mx":19,"my":27},{"lx":36,"ly":32,"mx":24,"my":28},{"lx":49,"ly":34,"mx":36,"my":32},{"lx":64,"ly":36,"mx":49,"my":34},{"lx":80,"ly":36,"mx":64,"my":36},{"lx":92,"ly":36,"mx":80,"my":36},{"lx":100,"ly":36,"mx":92,"my":36},{"lx":106,"ly":36,"mx":100,"my":36},{"lx":110,"ly":36,"mx":106,"my":36},{"lx":111,"ly":36,"mx":110,"my":36},{"lx":112,"ly":36,"mx":111,"my":36},{"lx":112,"ly":34,"mx":112,"my":36},{"lx":112,"ly":33,"mx":112,"my":34},{"lx":112,"ly":28,"mx":112,"my":33},{"lx":112,"ly":23,"mx":112,"my":28},{"lx":112,"ly":19,"mx":112,"my":23},{"lx":112,"ly":14,"mx":112,"my":19},{"lx":112,"ly":11,"mx":112,"my":14},{"lx":111,"ly":8,"mx":112,"my":11},{"lx":110,"ly":8,"mx":111,"my":8},{"lx":109,"ly":8,"mx":110,"my":8},{"lx":107,"ly":8,"mx":109,"my":8},{"lx":103,"ly":11,"mx":107,"my":8},{"lx":95,"ly":17,"mx":103,"my":11},{"lx":87,"ly":24,"mx":95,"my":17},{"lx":80,"ly":33,"mx":87,"my":24},{"lx":77,"ly":36,"mx":80,"my":33},{"lx":76,"ly":39,"mx":77,"my":36},{"lx":76,"ly":40,"mx":76,"my":39},{"lx":76,"ly":41,"mx":76,"my":40},{"lx":78,"ly":42,"mx":76,"my":41},{"lx":80,"ly":42,"mx":78,"my":42},{"lx":85,"ly":42,"mx":80,"my":42},{"lx":89,"ly":42,"mx":85,"my":42},{"lx":93,"ly":40,"mx":89,"my":42},{"lx":97,"ly":37,"mx":93,"my":40},{"lx":100,"ly":34,"mx":97,"my":37},{"lx":102,"ly":32,"mx":100,"my":34},{"lx":103,"ly":31,"mx":102,"my":32},{"lx":103,"ly":30,"mx":103,"my":31},{"lx":104,"ly":30,"mx":103,"my":30},{"lx":105,"ly":30,"mx":104,"my":30},{"lx":106,"ly":33,"mx":105,"my":30},{"lx":107,"ly":34,"mx":106,"my":33},{"lx":108,"ly":36,"mx":107,"my":34},{"lx":110,"ly":36,"mx":108,"my":36},{"lx":114,"ly":36,"mx":110,"my":36},{"lx":119,"ly":36,"mx":114,"my":36},{"lx":123,"ly":32,"mx":119,"my":36},{"lx":126,"ly":28,"mx":123,"my":32},{"lx":126,"ly":24,"mx":126,"my":28},{"lx":126,"ly":23,"mx":126,"my":24},{"lx":124,"ly":29,"mx":126,"my":23},{"lx":121,"ly":37,"mx":124,"my":29},{"lx":117,"ly":43,"mx":121,"my":37},{"lx":116,"ly":45,"mx":117,"my":43},{"lx":116,"ly":43,"mx":116,"my":45},{"lx":117,"ly":36,"mx":116,"my":43},{"lx":120,"ly":30,"mx":117,"my":36},{"lx":122,"ly":28,"mx":120,"my":30},{"lx":125,"ly":24,"mx":122,"my":28},{"lx":127,"ly":22,"mx":125,"my":24},{"lx":128,"ly":21,"mx":127,"my":22},{"lx":130,"ly":21,"mx":128,"my":21},{"lx":131,"ly":21,"mx":130,"my":21},{"lx":133,"ly":21,"mx":131,"my":21},{"lx":134,"ly":21,"mx":133,"my":21},{"lx":134,"ly":22,"mx":134,"my":21},{"lx":134,"ly":24,"mx":134,"my":22},{"lx":134,"ly":27,"mx":134,"my":24},{"lx":131,"ly":30,"mx":134,"my":27},{"lx":127,"ly":32,"mx":131,"my":30},{"lx":125,"ly":33,"mx":127,"my":32},{"lx":126,"ly":33,"mx":125,"my":33},{"lx":130,"ly":33,"mx":126,"my":33},{"lx":133,"ly":33,"mx":130,"my":33},{"lx":138,"ly":33,"mx":133,"my":33},{"lx":144,"ly":33,"mx":138,"my":33},{"lx":145,"ly":33,"mx":144,"my":33},{"lx":146,"ly":33,"mx":145,"my":33},{"lx":146,"ly":31,"mx":146,"my":33},{"lx":146,"ly":27,"mx":146,"my":31},{"lx":146,"ly":23,"mx":146,"my":27},{"lx":149,"ly":18,"mx":146,"my":23},{"lx":151,"ly":16,"mx":149,"my":18},{"lx":152,"ly":15,"mx":151,"my":16},{"lx":153,"ly":15,"mx":152,"my":15},{"lx":153,"ly":17,"mx":153,"my":15},{"lx":153,"ly":24,"mx":153,"my":17},{"lx":153,"ly":31,"mx":153,"my":24},{"lx":153,"ly":36,"mx":153,"my":31},{"lx":152,"ly":40,"mx":153,"my":36},{"lx":152,"ly":41,"mx":152,"my":40},{"lx":152,"ly":38,"mx":152,"my":41},{"lx":152,"ly":33,"mx":152,"my":38},{"lx":152,"ly":29,"mx":152,"my":33},{"lx":152,"ly":27,"mx":152,"my":29},{"lx":152,"ly":26,"mx":152,"my":27},{"lx":153,"ly":25,"mx":152,"my":26},{"lx":154,"ly":25,"mx":153,"my":25},{"lx":156,"ly":25,"mx":154,"my":25},{"lx":159,"ly":27,"mx":156,"my":25},{"lx":161,"ly":28,"mx":159,"my":27},{"lx":162,"ly":28,"mx":161,"my":28},{"lx":163,"ly":30,"mx":162,"my":28},{"lx":164,"ly":30,"mx":163,"my":30},{"lx":165,"ly":30,"mx":164,"my":30},{"lx":166,"ly":30,"mx":165,"my":30},{"lx":167,"ly":28,"mx":166,"my":30},{"lx":168,"ly":26,"mx":167,"my":28},{"lx":168,"ly":22,"mx":168,"my":26},{"lx":168,"ly":20,"mx":168,"my":22},{"lx":168,"ly":19,"mx":168,"my":20}]);
				});
			//})(jQuery);	
			// } ) ( jQuery ) */
	 $this->registerJs('
	 var sig={"lines":[[[13,144.5],[11,139.5],[12,130.5],[19,116.5],[36,99.5],[58,87.5],[82,73.5],[105,62.5],[126,56.5],[134,54.5],[135,54.5],[131,100.5],[126,123.5],[115,144.5],[102,160.5],[92,168.5],[84,170.5],[79,170.5],[73,168.5],[69,158.5],[66,140.5],[71,122.5],[84,101.5],[108,84.5],[152,72.5],[187,70.5],[208,74.5],[217,86.5],[219,94.5],[217,114.5],[205,134.5],[187,146.5],[170,150.5],[165,150.5],[164,146.5],[161,126.5],[171,101.5],[188,73.5],[207,47.5],[223,37.5],[224,37.5],[227,43.5],[225,71.5],[222,97.5],[213,119.5],[210,131.5],[215,121.5],[219,115.5],[231,98.5],[242,85.5],[247,84.5],[251,84.5],[253,99.5],[253,117.5],[253,126.5],[253,127.5],[253,122.5],[258,109.5],[267,92.5],[274,84.5],[276,83.5],[279,84.5],[281,103.5],[281,119.5],[281,129.5],[281,130.5],[282,130.5],[288,119.5],[295,111.5],[298,107.5],[299,107.5],[299,112.5],[299,120.5],[299,124.5]]]};
		$(document).ready(function($) {	 
				$("#sig").signature();
				$("#redrawSignature").signature();
				$("#redrawSignature").signature({disabled: true});
				//$("#redrawSignature").signature({guideline: true});
				/* $("#redrawSignature").signature({guideline: true, 
					guidelineOffset: 0, guidelineIndent: 0, guidelineColor: "#ff0000"}
				); */
				
				$("#sig").signature({
					change: function(event, ui) { 
						$("#redrawSignature").signature("draw", sig);
					}
				});
				
				/* $("#redrawButton").click(function() {
					$("#redrawSignature").signature("draw", {"lines":[[[100,100],[180,50],[180,150],[100,100]], 
    [[140,75],[100,50],[100,150],[140,125]]]}); 
				});	 */
				
			
		});			
			   
	',$this::POS_BEGIN); 
	?>
  </div>
	<div id="sig"></div>
   
   <p style="clear: both;"><button id="clear">Clear</button> 
	<button id="json">To JSON</button> <button id="svg">To SVG</button> <button id="redrawButton">SHOW</button>
   </p>
	<div style="border:false" id="redrawSignature"></div>
	<button id="redrawButton">Draw</button>
   <!--</div>!-->
  <?php echo $employ->EMP_NM.' '.$employ->EMP_NM_BLK; ?>
  </div>
 
</div>



</div>

