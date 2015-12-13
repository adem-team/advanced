<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\widgets\DetailView;
use lukisongroup\master\models\Unitbarang;
/* use lukisongroup\assets\AppAssetJquerySignature_1_1_2;
AppAssetJquerySignature_1_1_2::register($this);  */

$this->title = $reqro->KD_RO;
$this->params['breadcrumbs'][] = ['label' => 'Request Order', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('http://lukisongroup.com/angular/signature/js/jquery.min.js',['position' => \yii\web\View::POS_HEAD],1); 
$mpdf=new mPDF();
$mpdf->SetJS("print(
			var  jsonData= $.ajax({
			  url: 'http://api.lukisongroup.com/login/signatures?id=2',
			  type: 'GET',
			  dataType:'json',			
			  async: false
			  }).responseText;		  
			  var myData1 = jsonData;
			  sig1 = myData1;
			  //alert(sig);
	)") ; 

	$mpdf->SetJS('print(
		$(document).ready(function() {	 
				$("#svgsignature1").signature();
				$("#redrawsignature1").signature();
				$("#redrawsignature1").signature({disabled: true});				
				$("#svgsignature1").signature({
					change: function(event, ui) { 
						$("#redrawsignature1").signature("draw", sig1);
						var coba1=$("#redrawsignature1").signature("toSVG");	
						 document.getElementById("ptrsvg1").innerHTML = coba1;							
					}
				});
				
				
		});					   
	)'); 
	?>
<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
</head>
<style>
@media print {
	body { font-family: verdana, arial, sans-serif ; }
	.pnjg{ width:120px; }
	.ttl{ text-align:center; }
	
	table{
		width:100%;
	}
	 th,td {
            padding: 4px 4px 4px 4px ;
			margin: 0px;
            }
	th {
		border-bottom: 2px solid #333333 ;
		}
	td {
		border-bottom: 1px dotted #999999 ;
		}
	tfoot td {
		border-bottom-width: 0px ;
		border-top: 2px solid #333333 ;
		padding-top: 20px ;
		}
}
</style>

<div class="ttl">
	<center>
		<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg']);?>
	</center>


    <center>
		<h2 style="margin-bottom:0px;"><b>Form Permintaan Barang</b></h2>
		<h3 style="margin-top:0px;">Nomor : <?= Html::encode($this->title) ?></h3>
	</center>

<br/><br/>
    <table>

        <thead>
            <tr>
				<th>No.</th>				
				<th>Kode Barang</th>
				<th>Nama Barang</th>
				<th>Quantity</th>
				<th>Satuan Barang</th>
				<th>Catatan</th>
            </tr>
        </thead>
		
        <?php $no=0; foreach($detro as $ro){ $sts = $ro->STATUS; if($sts == 0 OR $sts == 3 ){ } else { $no=$no+1; ?>
            <tr>
                <td><?php echo $no; ?></td>
                <td><?php echo $ro->NM_BARANG; ?></td>
                <td><?php echo $ro->KD_BARANG; ?></td>
                <td><?php echo $ro->RQTY; ?></td>
				<?php
					$model=Unitbarang::find()->where('KD_UNIT="'.$ro->UNIT. '"')->one();
					if (count($model)!=0){
						$UnitNm=$model->NM_UNIT;
					}else{
						$UnitNm='Not Set';
					}
				?>
                <td><?php echo $UnitNm;//$ro->UNIT; ?></td>
                <td><?php echo $ro->NOTE; ?></td>
            </tr>
        <?php } } ?>
    </table>

</div>
<div>
	<br/><br/><br/>
	<?php 


		$tgl = explode(' ',$reqro->CREATED_AT);
		$awl = explode('-',$tgl[0]); 
		$blnAwl = date("F", mktime(0, 0, 0, $awl[1], 1));
	?>
	  <div style="width:300px; float:right; ">
		  <b>Tanggerang, <?php echo $awl[2].' - '.$blnAwl.' - '.$awl[0];  ?></b><br/>
		  yang mengajukan,
		  <br/>	 
	  
		<?php //echo $svgTest;?>	
		<?php echo "<img src=".$svgTest."/>";?>	
		<!--<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj48c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgdmVyc2lvbj0iMS4xIiB3aWR0aD0iMTg3IiBoZWlnaHQ9IjcxIj48cGF0aCBzdHJva2UtbGluZWpvaW49InJvdW5kIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlPSJyZ2IoNTEsIDUxLCA1MSkiIGZpbGw9Im5vbmUiIGQ9Ik0gMzAgNzAgYyAwLjA5IC0wLjE2IDMuMDMgLTYuMTggNSAtOSBjIDUuMDYgLTcuMjIgMTAuNCAtMTQuNyAxNiAtMjEgYyAyLjEyIC0yLjM5IDUuNzUgLTMuNzUgOCAtNiBjIDIuMjUgLTIuMjUgMy42OCAtNS44IDYgLTggYyAzLjgxIC0zLjYxIDkgLTYuMzYgMTMgLTEwIGMgMy4yOCAtMi45OCA1Ljc2IC03LjMgOSAtMTAgYyAyLjQ4IC0yLjA2IDYuMDUgLTQuMzMgOSAtNSBjIDMuNzIgLTAuODUgMTAuNDcgLTAuNzIgMTMgMCBjIDAuOCAwLjIzIDAuOTEgMi42NyAxIDQgYyAwLjI0IDMuNTQgMC4yNCA3LjQ2IDAgMTEgYyAtMC4wOSAxLjMzIC0wLjM5IDMuMDggLTEgNCBjIC0wLjU0IDAuOCAtMS45NiAxLjcyIC0zIDIgYyAtMi4zMiAwLjYzIC01LjU2IDAuMzkgLTggMSBjIC0xLjM1IDAuMzQgLTIuNjcgMS45NiAtNCAyIGMgLTE4Ljc5IDAuNTYgLTYzIDAgLTYzIDAiLz48cGF0aCBzdHJva2UtbGluZWpvaW49InJvdW5kIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS13aWR0aD0iMiIgc3Ryb2tlPSJyZ2IoNTEsIDUxLCA1MSkiIGZpbGw9Im5vbmUiIGQ9Ik0gMjMgMTIgYyAtMC4xMiAwIC01LjEyIC0wLjUxIC03IDAgYyAtMS4zNCAwLjM3IC0yLjU3IDIuMjggLTQgMyBjIC0zLjA5IDEuNTQgLTcuODcgMi40NSAtMTAgNCBjIC0wLjgyIDAuNTkgLTAuODcgMi42OCAtMSA0IGMgLTAuMTkgMS45MyAtMC40MyA0LjE4IDAgNiBjIDAuODMgMy41NSAyLjQ2IDcuNDggNCAxMSBjIDAuNzcgMS43NiAxLjc1IDMuNjUgMyA1IGMgMi41OCAyLjggNi4wNyA1Ljk3IDkgOCBjIDEgMC43IDIuNjcgMC45NiA0IDEgYyA5LjAzIDAuMjggMTkuMzUgMS4zNiAyOCAwIGMgNy41MiAtMS4xOCAxNS4zIC01LjYxIDIzIC04IGMgMS45MiAtMC42IDQuMjggLTAuMjUgNiAtMSBjIDMuMjkgLTEuNDQgNi42OSAtNC44NCAxMCAtNiBsIDEwIC0xIi8+PHBhdGggc3Ryb2tlLWxpbmVqb2luPSJyb3VuZCIgc3Ryb2tlLWxpbmVjYXA9InJvdW5kIiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZT0icmdiKDUxLCA1MSwgNTEpIiBmaWxsPSJub25lIiBkPSJNIDExMSAyNiBjIC0wLjE2IDAuMDMgLTcuMjcgMC41NCAtOSAyIGMgLTEuODUgMS41NiAtMy40NyA2LjA2IC00IDkgYyAtMC43MSAzLjg4IC0wLjg5IDkuNDYgMCAxMyBjIDAuNTkgMi4zNCAzLjAxIDYuMzQgNSA3IGMgMy43MSAxLjI0IDEwLjk4IDAuNjkgMTYgMCBjIDQuMjcgLTAuNTkgOC44OSAtMi4yMiAxMyAtNCBjIDUuODEgLTIuNTIgMTIuMjEgLTUuOTcgMTcgLTkgYyAwLjkgLTAuNTcgMS4xOCAtMi4yOSAyIC0zIGMgMS4zMyAtMS4xNCA0IC0xLjg0IDUgLTMgYyAwLjcgLTAuODIgMS4xOCAtNCAxIC00IGMgLTAuMjIgMCAtMi4yNCAyLjU2IC0zIDQgYyAtMi4xOSA0LjEzIC00LjYzIDguOSAtNiAxMyBjIC0wLjQ4IDEuNDMgLTAuMzkgNC42MSAwIDUgYyAwLjI4IDAuMjggMi4xOSAtMS4xOSAzIC0yIGMgMS43NiAtMS43NiAzLjYzIC0zLjg3IDUgLTYgYyAxLjU3IC0yLjQ0IDIuMzggLTUuODQgNCAtOCBjIDEuMTYgLTEuNTUgMy45MyAtMi41OCA1IC00IGMgMC42OSAtMC45MiAwLjM5IC0zLjA4IDEgLTQgYyAwLjU0IC0wLjggMi44NiAtMi4zNyAzIC0yIGMgMC4zOCAxLjAzIDAuMjMgNi43OCAwIDEwIGMgLTAuMDkgMS4zMyAtMC40MSAyLjk2IC0xIDQgYyAtMC42MSAxLjA3IC0xLjkgMi4zMSAtMyAzIGMgLTEuMzkgMC44NyAtMy41IDEuODMgLTUgMiBjIC0xLjE1IDAuMTMgLTMuODggLTAuNjQgLTQgLTEgYyAtMC4xMSAtMC4zMiAxLjk4IC0xLjkgMyAtMiBjIDQuODEgLTAuNDggMTEuNjQgLTAuNiAxNyAwIGwgMTAgMyIvPjwvc3ZnPg==">
		!-->
	  <div>
		

	  <?php 		
	  echo $employ->EMP_NM.' '.$employ->EMP_NM_BLK; ?></b><br/></b><br/></b><br/>
	  
  </div>



