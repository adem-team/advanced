<?php

use yii\helpers\Html;

$this->sideCorp = 'Modul HRM';                                    /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_modul';                                    /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Entry - Sub Department');           /* title pada header page */

?>
<div class="deptsub-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
