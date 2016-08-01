<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftPlanHeader */

$this->title = 'Update Draft Plan Header: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Draft Plan Headers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="draft-plan-header-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
