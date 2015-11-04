<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\master\models\Masterjadwalkerja */

$this->title = $model->CustomerID;
$this->params['breadcrumbs'][] = ['label' => 'Masterjadwalkerjas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masterjadwalkerja-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'CustomerID' => $model->CustomerID, 'ProductID' => $model->ProductID, 'tgl' => $model->tgl], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'CustomerID' => $model->CustomerID, 'ProductID' => $model->ProductID, 'tgl' => $model->tgl], [
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
            'CustomerID',
            'AreaID',
            'ProductID',
            'tgl',
            'Status',
            'JadwalMasuk',
            'JadwalKeluar',
            'usercrt',
            'datecrt',
        ],
    ]) ?>

</div>
