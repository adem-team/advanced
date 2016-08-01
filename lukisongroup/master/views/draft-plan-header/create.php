<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftPlanHeader */

$this->title = 'Create Draft Plan Header';
$this->params['breadcrumbs'][] = ['label' => 'Draft Plan Headers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draft-plan-header-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
