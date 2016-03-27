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
use ho96\extplorer\Extplorer;
//use scotthuangzl\googlechart\GoogleChart;

use lukisongroup\assets\AppAssetSig;  	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
AppAssetSig::register($this);
//use backend\assets\AppAsset; 	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
//AppAsset::register($this);		/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/

$this->sideCorp = 'PT.Sarana Sinar Surya';                          /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'itprogrammer';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'SSS - Sales Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/


?>
<div class="container" >
    <div class="row" style="padding-left: 5px; padding-right: 5px">
        <div class="col-sm-12 col-md-12 col-lg-12 ">
		LukisonGroup Cloud Arsif
			<?php
				echo Extplorer::widget();
								// echo Html::panel(
									// ['heading' => 'Employee Status', 'body' => $pertama],
									// Html::TYPE_SUCCESS
								// );
								/* echo \navatech\roxymce\widgets\RoxyMceWidget::widget([
					'name'        => 'content', //default name of textarea which will be auto generated, REQUIRED if not using 'model' section
					'value'       => isset($_POST['content']) ? $_POST['content'] : '', //default value of current textarea, NOT REQUIRED
					'action'      => Url::to(['roxymce/default']), //default roxymce action route, NOT REQUIRED
					'options'     => [//TinyMce options, NOT REQUIRED, see https://www.tinymce.com/docs/
						'title' => 'RoxyMCE',//title of roxymce dialog, NOT REQUIRED
					],
					'htmlOptions' => [],//html options of this widget, NOT REQUIRED
				]); */

			?>		
		
		</div>
	</div>
</div>