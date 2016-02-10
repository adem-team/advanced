<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Termbudget */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Termbudgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="termbudget-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ID',
            'CUST_KD',
            'INVES_TYPE',
            'BUDGET_SOURCE',
            'BUDGET_VALUE',
            'PERIODE_START',
            'PERIODE_END',
            'STATUS',
            'CREATE_BY',
            'CREATE_AT',
            'UPDATE_BY',
            'UPDATE_AT',
        ],
    ]) ?>

</div>
