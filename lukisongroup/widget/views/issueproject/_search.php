<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\widget\IssueprojectSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="issueproject-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'PARENT') ?>

    <?= $form->field($model, 'ISSUE_NM') ?>

    <?= $form->field($model, 'ISSUE_DESC') ?>

    <?= $form->field($model, 'PRIORITY') ?>

    <?php // echo $form->field($model, 'CLOSE_DATETIME') ?>

    <?php // echo $form->field($model, 'USER_CREATED') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'CORP_ID') ?>

    <?php // echo $form->field($model, 'DEP_ID') ?>

    <?php // echo $form->field($model, 'OPEN_DATETIME') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
