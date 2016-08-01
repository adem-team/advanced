<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftLayer */

$this->title = $model->LAYER_ID;
$this->params['breadcrumbs'][] = ['label' => 'Draft Layers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draft-layer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->LAYER_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->LAYER_ID], [
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
            'LAYER_ID',
            'LAYER_NM',
            'JEDA_PEKAN',
            'DCRIPT:ntext',
        ],
    ]) ?>

</div>
