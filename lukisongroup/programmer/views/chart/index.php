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

use lukisongroup\assets\AppAssetChart;  	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
AppAssetChart::register($this);
use lukisongroup\assets\AppAssetQr;  	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
AppAssetQr::register($this);
//use backend\assets\AppAsset; 	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
//AppAsset::register($this);		/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/

$this->sideCorp = 'PT.Sarana Sinar Surya';                          /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'itprogrammer';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'IT - Componen Chart');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


			?>
<!-- ANGULAR CHECK
<div ng-app="ft_chart" ng-controller="AppCtrl"> 

	{{2+7}}
</div>
!-->
<div ng-app="ChartAll" ng-controller="CtrlChart"> 
	<div class="container" >
		<!-- Chart Line !-->
		<div class="col-sm-5">	
			<fusioncharts
				width= 100%
				type="msline"
				chart="{{attrs}}"
				categories="{{categories}}"
				dataset="{{dataset}}"
			>
			</fusioncharts>					   
		</div>
		<!-- Chart Column3D !-->
		<div class="col-sm-5">
			<fusioncharts 
				wwidth= 100%
				type="column2d"
				datasource="{{myDataSource}}"
			>
			</fusioncharts>
		</div>
		<!-- Chart Pie3D !-->
		<div class="col-sm-5" style="padding-left:50px">
			<fusioncharts 
				width="400" 
				height="400"
				type="pie3d",
				datasource="{{myDataSourcePie}}"
			></fusioncharts>
		</div>
		<div class="col-sm-5">
			<div fusioncharts
				width="600" 
				height="400"
				type="mscombi2d",
				datasource="{{myDataSourceMarketing}}"
			></div>
		</div>
		
		<div class="col-sm-5"style="padding-left:50px">
			<fusioncharts 
				wwidth= 100%
				type="column2d"
				datasource="{{myDataSource}}"
			>
			</fusioncharts>
		</div>
	</div>
	
	
	<div ng-controller="CtrlCht"> 
		<div class="container" >
			<!-- Line Chart !-->
			<div class="col-sm-6"> TYPE line
				<canvas id="line" class="chart chart-line" chart-data="data1"
				  chart-labels="labels1" chart-legend="true" chart-series="series1"
				  chart-click="onClick" >
				</canvas>
			</div>
			
			<!-- Bar Chart !-->
			<div class="col-sm-5"> TYPE Bar
				<canvas id="bar" class="chart chart-bar"
				  chart-data="data2" chart-labels="labels2">
				</canvas>
			</div>	
			
			<!-- Doughnut Chart !-->
			<div class="col-sm-6"> TYPE Doughnut
				<canvas id="doughnut" class="chart chart-doughnut"
				  chart-data="data3" chart-labels="labels3">
				</canvas> 
			</div>
			
			<!-- Radar Chart !--> 
			<div class="col-sm-6"> TYPE Radar
				<canvas id="radar" class="chart chart-radar"
				  chart-data="data4" chart-labels="labels4">
				</canvas> 
			</div>
			
			<!-- Pie Chart !-->
			<div class="col-sm-6"> TYPE Pie
				<canvas id="pie" class="chart chart-pie"
				  chart-data="data5" chart-labels="labels5">
				</canvas> 
			</div>
			
			<!-- Polar Area Chart !-->
			<div class="col-sm-6"> TYPE Polar
				<canvas id="polar-area" class="chart chart-polar-area"
				  chart-data="data6" chart-labels="labels6">
				</canvas> 
			</div>
			
			<!-- Dynamic Chart !-->
			<div class="col-sm-6"> TYPE Dynamic
				<canvas id="base" class="chart-base" chart-type="type"
				  chart-data="data7" chart-labels="labels7" chart-legend="true">
				</canvas> 
			</div>
			

<canvas id="radar" class="chart chart-radar"
  chart-data="data" chart-labels="labels">
</canvas> 			
		</div>
	</div>



<div class="container" >
<div class="col-sm-6" >
<qrcode version="{{v}}" error-correction-level="{{e}}" size="{{s}}" data="{{foo}}"></qrcode>
	
  <form>
    <p>
      <label for="data">Data</label>
      <textarea id="data" data-ng-model="foo" maxlength="2953"></textarea>
    </p>
    <p>
      <label for="size">Size</label>
      <input id="size" type="number" data-ng-model="s">
    </p>
    <p>
      <label for="version">Version</label>
      <input id="version" type="number" data-ng-model="v" min="1" max="40">
    </p>
    <p>
      <label for="level" title="Error Correction Level">Level</label>
      <select id="level" data-ng-model="e" data-ng-options="option.version as option.name for option in [{name:'Low', version:'L'},{name:'Medium', version:'M'},{name:'Quartile', version:'Q'},{name:'High', version:'H'}]"></select>
    </p>
  </form>
</div>
</div>
</div>

