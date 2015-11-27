<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Customerskat */

$this->title = 'Update Customerskat: ' . ' ' . $model->CUST_KD;
$this->params['breadcrumbs'][] = ['label' => 'Customerskats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CUST_KD, 'url' => ['view', 'id' => $model->CUST_KD]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="customerskat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
