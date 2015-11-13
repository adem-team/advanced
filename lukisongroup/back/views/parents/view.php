<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\back\models\Parents */

$this->title = $model->parent_id;
$this->params['breadcrumbs'][] = ['label' => 'Parents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parents-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'parent_id',
            'parent',
        ],
    ]) ?>

</div>
