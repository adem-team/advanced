<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model crm\salespromo\models\Stock_promo */

$this->title = 'Update Stock Promo: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Stock Promos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stock-promo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
