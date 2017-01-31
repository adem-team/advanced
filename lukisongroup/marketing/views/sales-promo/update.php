<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\marketing\models\SalesPromo */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Sales Promo',
]) . $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sales Promos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sales-promo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
