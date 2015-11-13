<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterCalonProduct */

$this->title = $model->calonproductID;
$this->params['breadcrumbs'][] = ['label' => 'Master Calon Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-calon-product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->calonproductID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->calonproductID], [
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
            'calonproductID',
            'Nama',
            'IDJobDesc',
            'gender',
            'KTP',
            'KTPExpireddate',
            'sim',
            'simexpiredate',
            'IDstatusnikah',
            'address',
            'refferensidesc',
            'city',
            'zip',
            'phone',
            'mobile1',
            'mobile2',
            'BankID',
            'BankAccNumber',
            'NPWP',
            'IsActive',
            'status',
            'usercrt',
            'datecrt',
            'userupdate',
            'dateupdate',
        ],
    ]) ?>

</div>
