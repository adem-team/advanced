<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Schedulegroup */

$this->title = $model->SCDL_GROUP_NM;
$this->params['breadcrumbs'][] = ['label' => 'Schedulegroups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$sts = $model->STATUS;
if($sts == 1){
  $stat = 'Aktif';
} else {
  $stat = 'Tidak Aktif';
}
?>
<div class="schedulegroup-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
         <!-- Html::a('Update', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?> -->
        <!-- Html::a('Delete', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'ID',
            'SCDL_GROUP_NM',
            'KETERANGAN:ntext',
            [
              'label' => 'Status',
              'value' => $stat,
            ],
        ],
    ]) ?>

</div>
