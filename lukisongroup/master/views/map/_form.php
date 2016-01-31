<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use lukisongroup\master\models\Customers;
use kartik\widgets\Select2;
use yii\helpers\BaseHtml;
use lukisongroup\assets\LocateAsset;
LocateAsset::register($this);

/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Map */
/* @var $form yii\widgets\ActiveForm */
$datacus = ArrayHelper::map(Customers::find()->all(), 'CUST_KD', 'CUST_NM');

?>

<div class="map-form">

    <?php $form = ActiveForm::begin([
            'id'=>$model->formName()

    ]); ?>

     <?= $form->field($model, 'CUST_ID')->widget(Select2::classname(), [
            'data' => $datacus,
            'options' => ['placeholder' => 'Pilih Nama Customers ...'],
            'pluginOptions' => [
                'allowClear' => true
                 ],
    ]);?>

    <div id="preSearch" class="center">
    <p><br /></p>  <?= Html::a('IN', ['lookup'], ['class' => 'btn btn-success', 'onclick' => "javascript:beginSearch();return false;"]) ?>
    </div>

    <?= BaseHtml::activeHiddenInput($model, 'LAT'); ?>

    <?= BaseHtml::activeHiddenInput($model, 'LAG'); ?>

    <?= BaseHtml::activeHiddenInput($model, 'RADIUS'); ?>

    <div id="searchArea" class="hidden">
    <div id="autolocateAlert">
    </div> <!-- end autolocateAlert -->
    <p> your location...<span id="status"></span></p>
    <article>
    </article>
    <div class="form-actions hidden" id="actionBar">
      </div> <!-- end action Bar-->
  </div>   <!-- end searchArea -->
  </div> <!-- end col 2 -->



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'SAVE' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','id'=>'btn']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
