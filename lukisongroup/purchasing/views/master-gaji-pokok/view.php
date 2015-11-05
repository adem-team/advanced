<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterGajiPokok */

$this->title = $model->GapokID;
$this->params['breadcrumbs'][] = ['label' => 'Master Gaji Pokoks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-gaji-pokok-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'GapokID' => $model->GapokID, 'SeqID' => $model->SeqID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'GapokID' => $model->GapokID, 'SeqID' => $model->SeqID], [
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
            'GapokID',
            'SeqID',
            'IDJobDesc',
            'AreaID',
            'Amount',
            'IsActive',
            'usercrt',
            'datecrt',
        ],
    ]) ?>

</div>
