<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\Berita */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Beritas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="berita-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'ID' => $model->ID, 'KD_BERITA' => $model->KD_BERITA], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'ID' => $model->ID, 'KD_BERITA' => $model->KD_BERITA], [
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
            'KD_BERITA',
            'JUDUL',
            'ISI:ntext',
            'KD_CORP',
            'KD_CAB',
            'KD_DEP',
            'DATA_PICT:ntext',
            'DATA_FILE:ntext',
            'STATUS',
            'CREATED_ATCREATED_BY',
            'CREATED_BY',
            'UPDATE_AT',
            'DATA_ALL:ntext',
        ],
    ]) ?>

</div>
