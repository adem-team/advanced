<?php

use kartik\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use kartik\tabs\TabsX;
use yii\helpers\Json;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use lukisongroup\assets\Profile;
Profile::register($this);
use ptrnov\fusionchart\ChartAsset;
ChartAsset::register($this);

//include("fusioncharts.php");
$this->sideCorp = 'PT. Efenbi Sukses Makmur';                      			/* Title Select Company pada header pasa sidemenu/menu samping kiri */	
$this->sideMenu = 'efenbi';                                    					/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Reporting - PT.  Efembi Sukses Makmur');		/* title pada header page */
$this->params['breadcrumbs'][] = $this->title;                      		/* belum di gunakan karena sudah ada list sidemenu, on plan next*/


echo "Progress Building ....";

?>