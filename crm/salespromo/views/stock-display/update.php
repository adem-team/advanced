<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model crm\salespromo\models\Stock_display */

$this->title = 'Update Stock Display: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Stock Displays', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stock-display-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
