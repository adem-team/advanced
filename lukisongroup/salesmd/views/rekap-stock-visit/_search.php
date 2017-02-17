<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model lukisongroup\salesmd\models\RekapStockVisitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rekap-stock-visit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ID') ?>

    <?= $form->field($model, 'CUST_KD') ?>

    <?= $form->field($model, 'CUST_NM') ?>

    <?= $form->field($model, 'KD_BARANG') ?>

    <?= $form->field($model, 'NM_BARANG') ?>

    <?php // echo $form->field($model, 'TGL') ?>

    <?php // echo $form->field($model, 'POS') ?>

    <?php // echo $form->field($model, 'SO_TYPE') ?>

    <?php // echo $form->field($model, 'USER_ID') ?>

    <?php // echo $form->field($model, 'w0') ?>

    <?php // echo $form->field($model, 'w1') ?>

    <?php // echo $form->field($model, 'w2') ?>

    <?php // echo $form->field($model, 'w3') ?>

    <?php // echo $form->field($model, 'w4') ?>

    <?php // echo $form->field($model, 'w5') ?>

    <?php // echo $form->field($model, 'w6') ?>

    <?php // echo $form->field($model, 'w7') ?>

    <?php // echo $form->field($model, 'w8') ?>

    <?php // echo $form->field($model, 'w9') ?>

    <?php // echo $form->field($model, 'w10') ?>

    <?php // echo $form->field($model, 'w11') ?>

    <?php // echo $form->field($model, 'w12') ?>

    <?php // echo $form->field($model, 'w13') ?>

    <?php // echo $form->field($model, 'w14') ?>

    <?php // echo $form->field($model, 'w15') ?>

    <?php // echo $form->field($model, 'w16') ?>

    <?php // echo $form->field($model, 'w17') ?>

    <?php // echo $form->field($model, 'w18') ?>

    <?php // echo $form->field($model, 'w19') ?>

    <?php // echo $form->field($model, 'w20') ?>

    <?php // echo $form->field($model, 'w21') ?>

    <?php // echo $form->field($model, 'w22') ?>

    <?php // echo $form->field($model, 'w23') ?>

    <?php // echo $form->field($model, 'w24') ?>

    <?php // echo $form->field($model, 'w25') ?>

    <?php // echo $form->field($model, 'w26') ?>

    <?php // echo $form->field($model, 'w27') ?>

    <?php // echo $form->field($model, 'w28') ?>

    <?php // echo $form->field($model, 'w29') ?>

    <?php // echo $form->field($model, 'w30') ?>

    <?php // echo $form->field($model, 'w31') ?>

    <?php // echo $form->field($model, 'w32') ?>

    <?php // echo $form->field($model, 'w33') ?>

    <?php // echo $form->field($model, 'w34') ?>

    <?php // echo $form->field($model, 'w35') ?>

    <?php // echo $form->field($model, 'w36') ?>

    <?php // echo $form->field($model, 'w37') ?>

    <?php // echo $form->field($model, 'w38') ?>

    <?php // echo $form->field($model, 'w39') ?>

    <?php // echo $form->field($model, 'w40') ?>

    <?php // echo $form->field($model, 'w41') ?>

    <?php // echo $form->field($model, 'w42') ?>

    <?php // echo $form->field($model, 'w43') ?>

    <?php // echo $form->field($model, 'w44') ?>

    <?php // echo $form->field($model, 'w45') ?>

    <?php // echo $form->field($model, 'w46') ?>

    <?php // echo $form->field($model, 'w47') ?>

    <?php // echo $form->field($model, 'w48') ?>

    <?php // echo $form->field($model, 'w49') ?>

    <?php // echo $form->field($model, 'w50') ?>

    <?php // echo $form->field($model, 'w51') ?>

    <?php // echo $form->field($model, 'w52') ?>

    <?php // echo $form->field($model, 'w53') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
