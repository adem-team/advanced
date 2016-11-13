<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\CustomersImage */

$this->title = 'Update Customers Image: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Customers Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="customers-image-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
