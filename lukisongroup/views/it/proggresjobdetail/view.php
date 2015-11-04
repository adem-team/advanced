<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->proggresjobdetail_id;
$this->params['breadcrumbs'][] = ['label' => 'Proggresjobdetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proggresjobdetail-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->proggresjobdetail_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->proggresjobdetail_id], [
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
            'proggresjobdetail_id',
            'progress_id',
            'created_date',
            'keterangan',
            'pic',
        ],
    ]) ?>

</div>
