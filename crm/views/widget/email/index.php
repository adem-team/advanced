<?php
use kartik\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\Breadcrumbs;

/* TABLE CLASS DEVELOPE -> |DROPDOWN,PRIMARYKEY-> ATTRIBUTE */
use app\models\hrd\Dept;
/*	KARTIK WIDGET -> Penambahan componen dari yii2 dan nampak lebih cantik*/
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use kartik\builder\Form;

//use backend\assets\AppAsset; 	/* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
//AppAsset::register($this);		/* INDEPENDENT CSS/JS/THEME FOR PAGE  Author: -ptr.nov-*/

$this->sideCorp = 'LG Widget';                                   /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'mdefault';                           /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Email');     /* title pada header page */
$this->params['breadcrumbs'][] = $this->title;          /* belum di gunakan karena sudah ada list sidemenu, on plan next*/
?>
<div class="body-content">
    <div class="row" style="padding-left: 5px; padding-right: 5px">
		<div class="col-sm-3"></div>
        <div class="col-sm-4 col-md-4 col-lg-4 ">
           <img src="<?php echo Yii::$app->urlManager->baseUrl.'/upload/image/underc1.jpg'; ?>"  height="200" width="300">           
        </div>
    </div>
</div>