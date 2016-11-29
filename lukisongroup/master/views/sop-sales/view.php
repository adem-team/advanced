<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\SopSalesHeader */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Sop Sales Headers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sop-sales-header-view">

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
            'TGL',
            'STT_DEFAULT',
            'SOP_TYPE',
            'KATEGORI',
            'BOBOT_PERCENT',
            'TARGET_MONTH',
            'TARGET_DAY',
            'TTL_DAYS',
            'TARGET_UNIT',
            'CREATE_BY',
            'CREATE_AT',
        ],
    ]) ?>

</div>
