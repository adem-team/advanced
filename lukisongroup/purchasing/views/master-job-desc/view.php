<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterJobDesc */

$this->title = $model->IDJobDesc;
//$this->params['breadcrumbs'][] = ['label' => 'Master Job Descs', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-job-desc-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->IDJobDesc], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->IDJobDesc], [
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
            'IDJobDesc',
            'Description',
            'IsActive',
            'usercrt',
            'datecrt',
        ],
    ]) ?>

</div>
