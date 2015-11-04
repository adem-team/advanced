<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterBiaya */

$this->title = $model->BiayaID;
$this->params['breadcrumbs'][] = ['label' => 'Master Biayas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-biaya-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->BiayaID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->BiayaID], [
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
            'BiayaID',
            'Description',
            'IsActive',
            'UserCrt',
            'DateCrt',
        ],
    ]) ?>

</div>
