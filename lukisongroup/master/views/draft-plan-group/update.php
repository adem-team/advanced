<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftPlanGroup */

$this->title = 'Update Draft Plan Group: ' . $model->SCDL_GROUP;
$this->params['breadcrumbs'][] = ['label' => 'Draft Plan Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SCDL_GROUP, 'url' => ['view', 'id' => $model->SCDL_GROUP]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="draft-plan-group-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
