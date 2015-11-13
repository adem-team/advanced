<?php

use yii\helpers\Html;

$this->sideCorp = 'HRM - Data Employee';                   	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_personalia';                           /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Personalia - Input Data Employee');  /* title pada header page */

?>
<div class="container">
	<div class="col-sm-2"></div>
	<div class="col-sm-7">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
	</div>
</div>