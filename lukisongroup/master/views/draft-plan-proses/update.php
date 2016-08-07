<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftPlanProses */

$this->title = 'Update Draft Plan Proses: ' . $model->PROSES_ID;
$this->params['breadcrumbs'][] = ['label' => 'Draft Plan Proses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PROSES_ID, 'url' => ['view', 'id' => $model->PROSES_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="draft-plan-proses-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
