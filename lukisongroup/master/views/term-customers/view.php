<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Termcustomers */

$this->title = $model->ID_TERM;
$this->params['breadcrumbs'][] = ['label' => 'Termcustomers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="termcustomers-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ID_TERM], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID_TERM], [
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
            'ID_TERM',
            'NM_TERM',
            'CUST_KD',
            'CUST_NM',
            'CUST_SIGN',
            'PRINCIPAL_KD',
            'PRINCIPAL_NM',
            'PRINCIPAL_SIGN',
            'DIST_KD',
            'DIST_NM',
            'DIST_SIGN',
            'DCRP_SIGNARURE:ntext',
            'PERIOD_START',
            'PERIOD_END',
            'TARGET_TEXT:ntext',
            'TARGET_VALUE',
            'RABATE_CNDT:ntext',
            'GROWTH',
            'TOP:ntext',
            'STATUS',
            'CREATED_BY',
            'CREATED_AT',
            'UPDATE_BY',
            'UPDATE_AT',
        ],
    ]) ?>

</div>
