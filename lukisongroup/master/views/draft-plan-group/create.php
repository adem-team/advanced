<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftPlanGroup */

$this->title = 'Create Draft Plan Group';
$this->params['breadcrumbs'][] = ['label' => 'Draft Plan Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draft-plan-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
