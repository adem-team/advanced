<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterPegawai */

$this->title = $model->NIK;
//$this->params['breadcrumbs'][] = ['label' => 'Master Pegawais', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-pegawai-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->NIK], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->NIK], [
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
            'NIK',
            'Nama',
            'IDJobDesc',
            'gender',
            'IDStatusNikah',
            'address',
            'city',
            'zip',
            'phone',
            'mobile1',
            'mobile2',
            'BankID',
            'BankAccNumber',
            'NPWP',
            'IsActive',
            'usercrt',
            'datecrt',
            'userUpdate',
            'dateUpdate',
        ],
    ]) ?>

</div>
