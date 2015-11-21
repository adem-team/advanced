<?php

use yii\helpers\Html;

$this->sideCorp = 'Modul HRM';                            	/* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'hrd_modul';                            	/* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Create -Modul JobGrade');     /* title pada header page */
?>
<div class="container">
	<div class="col-sm-2"></div>
	<div class="col-sm-7">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
	</div>
</div>