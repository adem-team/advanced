<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\widget\Pilotproject */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Pilotprojects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

        <?= Html::a('Update', ['update', 'id' => $model->ID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'ID',
            //'PARENT',
            //'PILOT_ID',
            'PILOT_NM',
            'PLAN_DATE1',
            'PLAN_DATE2',
            'ACTUAL_DATE1',
            'ACTUAL_DATE2',
            'STATUS',
            'CORP_ID',
            'DEP_ID',
            'CREATED_BY',
        ],
    ]) ?>


