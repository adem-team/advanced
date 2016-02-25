<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Machine */

$this->title = $model->TerminalID;
$this->params['breadcrumbs'][] = ['label' => 'Machines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="machine-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->TerminalID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->TerminalID], [
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
            'TerminalID',
            'MESIN_NM',
            'MESIN_SN',
            'CAB_ID',
        ],
    ]) ?>

</div>
