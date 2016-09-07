<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\CustomercallExpired */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Customercall Expireds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customercall-expired-view">

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
            'ID_PRIORITASED',
            'ID_DETAIL',
            'CUST_ID',
            'BRG_ID',
            'USER_ID',
            'TGL_KJG',
            'QTY',
            'DATE_EXPIRED',
            'STATUS',
            'CREATE_AT',
            'UPDATE_AT',
            'CREATE_BY',
            'UPDATE_BY',
        ],
    ]) ?>

</div>
