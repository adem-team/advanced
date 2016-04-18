<?php
use kartik\helpers\Html;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\data\ArrayDataProvider;

use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveField;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\FileInput;
use kartik\builder\FormGrid;
use kartik\tabs\TabsX;
use lukisongroup\assets\MapAsset;       /* CLASS ASSET CSS/JS/THEME Author: -wawan-*/
MapAsset::register($this);

$this->sideCorp = 'PT. ESM';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'effenbi_dboard';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Sales Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

?>

<?php
	 $map = '<div id ="map" style="width:100%;height:820px"></div>';
?>


<div class="container-fluid" style="padding-left: 20px; padding-right: 20px" >
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12">
					<?php
					 echo Html::panel(
						[
							'heading' => '<div>DASHBOARD - Saleman Visit</div>',
							'body'=> $map,
						],
						Html::TYPE_INFO
					);
					?>
			</div>
		</div>
       <div class="row" >
			
		</div>
 </div>
 
 <?php
 $this->registerJs("
		/*nampilin MAP*/
		 var map = new google.maps.Map(document.getElementById('map'),
			  {
				zoom: 12,
				center: new google.maps.LatLng(-6.229191531958687,106.65994325550469),
				mapTypeId: google.maps.MapTypeId.ROADMAP

			});
			
			var public_markers = [];
			
		/*data json*/
		$.getJSON('http://dashboard.lukisongroup.com/efenbi/report/map', function(json) {
			for (var i in public_markers){
				public_markers[i].setMap(null);
			}

			$.each(json, function (i, point) {
					var marker = new google.maps.Marker({
					// icon: icon,
					position: new google.maps.LatLng(point.MAP_LAT, point.MAP_LNG),
					animation:google.maps.Animation.BOUNCE,
					map: map,
					 icon : 'http://labs.google.com/ridefinder/images/mm_20_red.png'
				});
				 public_markers[i] = marker;
			});
		});	
			
			
",$this::POS_READY);
 ?>
 
 
 
 
 
 
 
 