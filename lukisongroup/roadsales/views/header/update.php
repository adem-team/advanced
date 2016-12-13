<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\roadsales\models\SalesRoadHeader */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Sales Road Header',
]) . $model->ROAD_D;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sales Road Headers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ROAD_D, 'url' => ['view', 'id' => $model->ROAD_D]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sales-road-header-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
