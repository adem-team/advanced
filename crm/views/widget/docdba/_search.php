<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\widget\doc\DocdbaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="docdba-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'PARENT') ?>

    <?= $form->field($model, 'MDL_ID') ?>

    <?= $form->field($model, 'MDL_NM') ?>

    <?= $form->field($model, 'MDL_DB') ?>

    <?php // echo $form->field($model, 'MDL_DB_ALIAS') ?>

    <?php // echo $form->field($model, 'MDL_TBL') ?>

    <?php // echo $form->field($model, 'MDL_KEY') ?>

    <?php // echo $form->field($model, 'MDL_FLD') ?>

    <?php // echo $form->field($model, 'MDL_CLS') ?>

    <?php // echo $form->field($model, 'MDL_LINK') ?>

    <?php // echo $form->field($model, 'DSCRP') ?>

    <?php // echo $form->field($model, 'CREATED_DATE') ?>

    <?php // echo $form->field($model, 'STATUS') ?>

    <?php // echo $form->field($model, 'CORP_ID') ?>

    <?php // echo $form->field($model, 'DEP_ID') ?>

    <?php // echo $form->field($model, 'USER_CREATED') ?>

    <?php // echo $form->field($model, 'SORT') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
