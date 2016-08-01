<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftLayerMutasi */

$this->title = 'Update Draft Layer Mutasi: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Draft Layer Mutasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="draft-layer-mutasi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
