<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftGeo */

$this->title = $model->GEO_ID;
$this->params['breadcrumbs'][] = ['label' => 'Draft Geos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draft-geo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->GEO_ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->GEO_ID], [
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
            'GEO_ID',
            'GEO_NM',
            'GEO_DCRIP:ntext',
            'CUST_MAX_NORMAL',
            'CUST_MAX_LAYER',
            'START_LAT',
            'START_LONG',
            'STATUS',
            'CREATE_BY',
            'CREATE_AT',
            'UPDATE_BY',
            'UPDATE_AT',
        ],
    ]) ?>

</div>
