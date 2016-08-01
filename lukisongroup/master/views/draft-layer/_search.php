<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\DraftLayerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="draft-layer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'LAYER_ID') ?>

    <?= $form->field($model, 'LAYER_NM') ?>

    <?= $form->field($model, 'JEDA_PEKAN') ?>

    <?= $form->field($model, 'DCRIPT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
