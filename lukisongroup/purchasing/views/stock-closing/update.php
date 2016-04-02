<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\purchasing\models\stck\StockClosing */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Stock Closing',
]) . $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Stock Closings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="stock-closing-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
