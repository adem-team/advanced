<?php
use yii\helpers\Html;

$this->sideCorp = 'PT.Lukisongroup';                        /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'admin';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'ERP - Administrator');        /* title pada header page */
?>
<div class="mdlpermission-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
