<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterCustomer */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Master Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-customer-view">

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
            'ParentID',
            'nama',
            'address',
            'city',
            'zip',
            'phone',
            'fax',
            'Contact_name',
            'Contact_phone',
            'Contact_email:email',
            'IDAbsenType',
            'IsActive',
            'usercrt',
            'datecrt',
            'userUpdate',
            'dateUpdate',
        ],
    ]) ?>

</div>
