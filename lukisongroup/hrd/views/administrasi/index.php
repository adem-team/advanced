<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use yii\helpers\Json;
use kartik\tabs\TabsX;
use lukisongroup\assets\AppAssetOrg1; 		
AppAssetOrg1::register($this);	


	/*ORG JSON INCRIPTION -ptr.nov-*/
	function encodeURIComponent($str) {
			$revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
			return strtr(rawurlencode($str), $revert);
	}
	/*ORG JSON DATA INCRIPTION -ptr.nov-*/	
	//print_r($dataProviderOrg->getModels());
	//echo  \yii\helpers\Json::encode($dataProvider->getModels());
	$orgJsonStr = encodeURIComponent(Json::encode($dataProviderOrg->getModels()));
	//$itemJsonStr2 = Json::encode($dataProviderOrg->getModels());
	
	$diagramOrg = '<div class="body-content" id="orgdiagram-administation" style="overflow: hidden;"></div>';
	//$diagramOrg = '<div class="content-wrapper" id="orgdiagram-administation" style="position: absolute; overflow: hidden; left: 0px; padding: 0px; margin: 0px; border-style: solid; border-color: navy; border-width: 1px;"></div>';
$items=[
	[
		'label'=>'<i class="glyphicon glyphicon-home"></i>VisiMisi','content'=>'asdsad',
		
	],
	[
		'label'=>'<i class="glyphicon glyphicon-home"></i>Struktur Organisasi','content'=>$diagramOrg,
		
	],
	[
		'label'=>'<i class="glyphicon glyphicon-home"></i>Regulations','content'=>'asdasdsadasd',             
	],
];

echo TabsX::widget([
	'id'=>'tab-org-administrator',
	'items'=>$items,
	'position'=>TabsX::POS_ABOVE,
	//'height'=>'tab-height-xs',
	'bordered'=>true,
	'encodeLabels'=>false,
	//'align'=>TabsX::ALIGN_LEFT,

]);

?>

<?php

	/*
	 * Primitive JS Structure Organization 
	 * @author ptrnov [ptr.nov@gmail.com]
	 * @since 1.1
	*/
	$this->registerJs('	
		$.noConflict();
		jQuery(document).ready(function($) {
			var m_timer = null;
			var datax=\'' . $orgJsonStr . '\';	
			$(document).ready(function () {
				$.ajaxSetup({
					cache: true
				});
				ResizePlaceholder();
				orgDiagram = $("#orgdiagram-administation").orgDiagram({
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
			});

			function ResizePlaceholder() {
				var bodyWidth = $(window).width() - 40
				var bodyHeight = $(window).height() - (-65) //height 
				var titleHeight = 93;
				
				$("#orgdiagram-administation").css(
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



