<?php 
use Yii;
use yii\helpers\Url;
use kartik\helpers\Html;
use kartik\grid\GridView;
use kartik\nav\NavX;
use lukisongroup\assets\MapAsset;
use yii\bootstrap\Modal;       /* CLASS ASSET CSS/JS/THEME Author: -wawan-*/
MapAsset::register($this);
$mapTracking=$this->renderAjax('_viewDetailMap',[

]);
 
?>
<?=$mapTracking?>
