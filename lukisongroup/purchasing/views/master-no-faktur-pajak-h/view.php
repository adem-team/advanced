<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterNoFakturPajakH */

$this->title = $model->IDFakturPajakH;
$this->params['breadcrumbs'][] = ['label' => 'Master No Faktur Pajak Hs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-no-faktur-pajak-h-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->IDFakturPajakH], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->IDFakturPajakH], [
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
            'IDFakturPajakH',
            'PeriodFrom',
            'PeriodTo',
            'IsActive',
            'NumberFrom',
            'NumberTo',
            'DateCrt',
            'UserCrt',
        ],
    ]) ?>

</div>
