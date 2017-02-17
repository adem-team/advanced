<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\salesmd\models\RekapStockVisit */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Rekap Stock Visit',
]) . $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rekap Stock Visits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="rekap-stock-visit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
