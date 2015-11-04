<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\master\models\Masterproduct */

$this->title = $model->productID;
$this->params['breadcrumbs'][] = ['label' => 'Masterproducts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="masterproduct-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->productID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->productID], [
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
            'productID',
            'NIK',
            'Nama',
            'IDJobDesc',
            'gender',
            'KTP',
            'KTPExpireddate',
            'SIM',
            'SIMExpiredDate',
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
            'status',
            'ClassID',
            'usercrt',
            'datecrt',
            'userUpdate',
            'dateUpdate',
        ],
    ]) ?>

</div>
