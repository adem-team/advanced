<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model crm\salespromo\models\Penjualan */

$this->title = 'Update Penjualan: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Penjualans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="penjualan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
