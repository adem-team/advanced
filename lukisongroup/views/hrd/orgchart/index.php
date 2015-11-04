<?php
//use kartik\helpers\Html;
//use yii\helpers\ArrayHelper;
//use yii\widgets\Breadcrumbs;
//use app\models\hrd\Dept;
//use kartik\grid\GridView;
//use kartik\widgets\ActiveForm;
//use kartik\tabs\TabsX;
//use kartik\date\DatePicker;
//use kartik\builder\Form;
use yii\helpers\Json;

use lukisongroup\assets\AppAssetOrg1; 		/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
AppAssetOrg1::register($this);			/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/

$this->sideCorp = 'Modul HRM';                                   		/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_modul';                                      	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'HRM - Organization');           /* title pada header page */
//$this->params['breadcrumbs'][] = $this->title;                          /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

function encodeURIComponent($str) {
        $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
        return strtr(rawurlencode($str), $revert);
}
	
//print_r($dataProvider->getModels());
//echo  \yii\helpers\Json::encode($dataProvider->getModels());
$itemJsonStr = encodeURIComponent(Json::encode($dataProvider->getModels()));
$itemJsonStr2 = Json::encode($dataProvider->getModels());
//$this->registerJs('Print("var data=\"" . $itemJsonStr . "\";");');
//echo $itemJsonStr2;
//echo $itemJsonStr;

$this->registerJs('
		jQuery.noConflict();
		(function($) {
			var m_timer = null;
			var datax=\'' . $itemJsonStr . '\';	
			$(document).ready(function () {
				$.ajaxSetup({
					cache: false
				});
				ResizePlaceholder();
				orgDiagram = $("#orgdiagram").orgDiagram({
					//graphicsType: primitives.common.GraphicsType.SVG,
					pageFitMode: primitives.common.PageFitMode.FitToPage,
					verticalAlignment: primitives.common.VerticalAlignmentType.Middle,
					connectorType: primitives.common.ConnectorType.Angular,
					minimalVisibility: primitives.common.Visibility.Dot,
					selectionPathMode: primitives.common.SelectionPathMode.FullStack,
					leavesPlacementType: primitives.common.ChildrenPlacementType.Horizontal,
					hasButtons: primitives.common.Enabled.False,
					hasSelectorCheckbox: primitives.common.Enabled.False,				
					itemTitleFirstFontColor: primitives.common.Colors.White,
					itemTitleSecondFontColor: primitives.common.Colors.White
				});

				
				//Mengunakan Data Yii dataProvider Author -ptr.nov-
				var items = JSON.parse(decodeURIComponent(datax));
				items[0].templateName = "contactTemplate";
				orgDiagram.orgDiagram({
							items: items,
							cursorItem: 2
						});
				orgDiagram.orgDiagram("update");
				
				
				/* 
				//Mengunakan data Ajax Author -ptr.nov-
				$.ajax({
					url: \'http://localhost/orgchart1/phpservice.php\',
					dataType: \'text\',
					success: function(text) {
						var items = JSON.parse(decodeURIComponent(text));
						//var items = JSON.parse(\'data1\');
						items[0].templateName = "contactTemplate";
						orgDiagram.orgDiagram({
							items: items,
							cursorItem: 2
						});
						orgDiagram.orgDiagram("update");
					}
				});
				*/
			});


			function ResizePlaceholder() {
				var bodyWidth = $(window).width() - 40
				var bodyHeight = $(window).height() - (-65) //height 
				var titleHeight = 93;
				
				$("#orgdiagram").css(
				{
					"left": "230px",
					"width": (bodyWidth - 193) + "px",
					"height": (bodyHeight - titleHeight) + "px",
					"top": titleHeight + "px"
				});
			}
		})(jQuery);
',$this::POS_HEAD);

?>

<div class="content-wrapper">
<div style="padding: 0; margin: 0; font-size:12px">	
	<div class="content-wrapper" id="orgdiagram" style="position: absolute; overflow: hidden; left: 0px; padding: 0px; margin: 0px; border-style: solid; border-color: navy; border-width: 1px;"></div>
</div>
</div>	