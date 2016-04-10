<?php
use kartik\helpers\Html;
use kartik\detail\DetailView;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveField;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\FileInput;
use kartik\builder\FormGrid;
use kartik\tabs\TabsX;

$this->sideCorp = 'PT. ESM';                       /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'effenbi_dboard';                                      /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ESM - Sales Dashboard');              /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      /* belum di gunakan karena sudah ada list sidemenu, on plan next*/

?>

<div class="container-fluid" style="padding-left: 20px; padding-right: 20px" >
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-dm-12  col-lg-12">
					<?php
					 echo Html::panel(
						[
							'heading' => '<div>DASHBOARD - Saleman Visit</div>',
							'body'=>'',//$prof,
						],
						Html::TYPE_INFO
					);
					?>
			</div>
		</div>
       <div class="row" >
			
		</div>
 </div>