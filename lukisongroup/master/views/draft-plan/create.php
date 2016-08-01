<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftPlan */

$this->title = 'Create Draft Plan';
$this->params['breadcrumbs'][] = ['label' => 'Draft Plans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draft-plan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
