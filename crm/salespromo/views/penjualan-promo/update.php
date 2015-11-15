<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model crm\salespromo\models\Penjualanpromo */

$this->title = 'Update Penjualanpromo: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Penjualanpromos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="penjualanpromo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
