<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\DailyJobModul */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Daily Job Modul',
]) . $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Daily Job Moduls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="daily-job-modul-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
