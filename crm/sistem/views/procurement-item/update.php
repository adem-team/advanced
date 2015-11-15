<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\front\models\Procurement_item */

$this->title = 'Update Procurement Item: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Procurement Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="procurement-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
