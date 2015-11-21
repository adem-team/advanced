<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\maxi\Maxiprodak */

//$this->title = Yii::t('app', 'Create Maxiprodak');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employe'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1>

<?= $this->render('_form', [
	'model' => $model,
]) ?>
