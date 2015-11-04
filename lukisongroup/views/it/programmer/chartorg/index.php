<?php
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;
use app\models\hrd\Dept;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use kartik\builder\Form;
//use scotthuangzl\googlechart\GoogleChart;

use lukisongroup\assets\AppAssetOrg;  	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
AppAssetOrg::register($this);
//use backend\assets\AppAsset; 	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
//AppAsset::register($this);		/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/

$this->sideCorp = 'PT.Sarana Sinar Surya';                          /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'itprogrammer';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'SSS - Sales Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


?>
<div ng-app="AppChartOrg"  data-ng-controller="CtrlChartOrg">
	<div class="container" >
		<div  class="col-sm-12" > LukisonGroup Organization Chart
			{{6+6}}		  
			<div id="westpanel" style="width: 400px; padding: 10px; margin: 0px; border-style: dotted; font-size: 12px; border-color: grey; float: left; border-width: 1px; overflow: scroll; -webkit-overflow-scrolling: touch;">
				<p>Here is example of syncronized content between ngRepeat directive and bpOrgDiagram directive. 
				<p>Cursor: {{myOptions.cursorItem}}
				<p>Highlight: {{myOptions.highlightItem}}
				<p>Message: {{Message}}
				<p><ul>
					<li ng-repeat="item in myOptions.items">
					<p>Index: {{$index}}, Id: {{item.id}}, Parent: {{item.parent}}
					<p>{{contact.title}}<input type="text" ng-model="item.title" ng-required/>
					<p>{{contact.description}}<input type="text" ng-model="item.description" ng-required/>  
					<p><button ng-click="$parent.setCursorItem(item.id)">Cursor</button>  
					<button ng-click="$parent.setHighlightItem(item.id)">Highlight</button>
					<button ng-click="$parent.deleteItem($index)">Delete</button>
					<button ng-click="$parent.addItem($index + 1, item.id)">Add Child</button>
					</li>
				</ul>
				<button ng-click="addItem(0, null)">New</button>
					   
			</div>
			<div id="centerpanel"  style="overflow: hidden; padding: 0px; margin: 0px; border: 0px;">
				<div bp-org-diagram data-options="myOptions" data-on-highlight-changed="onMyHighlightChanged()"  data-on-cursor-changed="onMyCursorChanged()" style="width: 800px; height: 600px; border-style: dotted; border-width: 1px;"></div>
			</div>
		</div>
	</div>
</div>

