<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\back\models\Parents */

$this->title = 'Update Parents: ' . ' ' . $model->parent_id;
$this->params['breadcrumbs'][] = ['label' => 'Parents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->parent_id, 'url' => ['view', 'id' => $model->parent_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="parents-update">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
