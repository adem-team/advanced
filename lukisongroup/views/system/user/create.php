<?php

use yii\helpers\Html;
$this->sideCorp = 'PT.Lukisongroup';                        /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = 'admin';                                  /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'LG - Administrator');         /* title pada header page */

//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employe'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default" style="margin-top: 0px">
     <div class="panel-body">
		<h1><?= Html::encode($this->title) ?></h1>

		<?= $this->render('_form', [
			'model' => $model,
		]) ?>
	</div>
</div>
