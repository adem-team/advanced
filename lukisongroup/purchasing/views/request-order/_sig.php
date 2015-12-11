<?php

use yii\helpers\Html;
//use yii\widgets\DetailView;
use yii\helpers\Json;
use lukisongroup\assets\AppAssetJquerySignature_1_1_2;
AppAssetJquerySignature_1_1_2::register($this); 
/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\ro\Requestorder */

$this->sideCorp = 'ESM Request Order';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'esm_esm';                                 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Data Master');         /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

	$this->registerJs("
			var  jsonData= $.ajax({
			  url: 'http://api.lukisongroup.com/login/signatures?id=2',
			  type: 'GET',
			  dataType:'json',			
			  async: false
			  }).responseText;		  
			  var myData = jsonData;
			  sig = myData;
			  //alert(sig);
	",$this::POS_BEGIN) ; 

?>

<?php
	 $this->registerJs('
		$(document).ready(function($) {	 
				$("#SVGSignature").signature();
				$("#redrawSignature").signature();
				$("#redrawSignature").signature({disabled: true});				
				$("#SVGSignature").signature({
					change: function(event, ui) { 
						$("#redrawSignature").signature("draw", sig);
						var coba=$("#redrawSignature").signature("toSVG");	
						 document.getElementById("ptrSvg").innerHTML = coba;							
					}
				});
				
				
		});					   
	',$this::POS_BEGIN); 
	?>

	  <div  id="redrawSignature"></div> 
	  <div  id="SVGSignature"></div>
	  <div  id="ptrSvg"></div> 

</div>

