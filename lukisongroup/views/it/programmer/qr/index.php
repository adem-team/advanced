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

use lukisongroup\assets\AppAssetQr;  	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
AppAssetQr::register($this);
//use backend\assets\AppAsset; 	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
//AppAsset::register($this);		/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/

$this->sideCorp = 'PT.Sarana Sinar Surya';                          /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'itprogrammer';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'SSS - Sales Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


?>
<div class="container" >
	<div class="col-sm-3" ></div>
	<div class="col-sm-6" >
		<div data-ng-app="monospaced.qrcode" id="ng-app" data-ng-init="foo='LukisonGroup';bar='http://localhost/angular-qrcode-master/dist/angular-qrcode';v=4;e='M';s=274;"> 

			<h1>LukisonGroup QR Code</h1>

		  
		  <qrcode version="{{v}}" error-correction-level="{{e}}" size="{{s}}" data="{{foo}}"></qrcode>
		 <div style="padding-top:50px">
		  <form >
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
</div>

