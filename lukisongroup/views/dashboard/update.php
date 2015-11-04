<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\system\Dashboard */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Dashboard',
]) . ' ' . $model->CORP_ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dashboards'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CORP_ID, 'url' => ['view', 'id' => $model->CORP_ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="dashboard-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
