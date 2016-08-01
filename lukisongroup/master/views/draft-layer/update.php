<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftLayer */

$this->title = 'Update Draft Layer: ' . $model->LAYER_ID;
$this->params['breadcrumbs'][] = ['label' => 'Draft Layers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->LAYER_ID, 'url' => ['view', 'id' => $model->LAYER_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="draft-layer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
