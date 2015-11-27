<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Customerskat */

$this->title = $model->CUST_NM;
$this->params['breadcrumbs'][] = ['label' => 'Customerskats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customerskat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->CUST_KD], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->CUST_KD], [
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
            'CUST_KD',
            'CUST_KD_ALIAS',
            'CUST_NM',
            'CUST_GRP',
            'CUST_KTG',
            'JOIN_DATE',
            'MAP_LAT',
            'MAP_LNG',
            'PIC',
            'ALAMAT:ntext',
            'TLP1',
            'TLP2',
            'FAX',
            'EMAIL:email',
            'WEBSITE',
            'NOTE:ntext',
            'NPWP',
            'STT_TOKO',
            'DATA_ALL',
            'CAB_ID',
            'CORP_ID',
            'CREATED_BY',
            'CREATED_AT',
            'UPDATED_BY',
            'UPDATED_AT',
            'STATUS',
        ],
    ]) ?>

</div>
