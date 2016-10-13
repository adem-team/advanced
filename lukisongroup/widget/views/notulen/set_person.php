<?php
use softark\duallistbox\DualListbox;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

 $form = ActiveForm::begin([
    'id' => 'person-form',
    'enableAjaxValidation' => false,
]);

echo Html::activeHiddenInput($model, 'NotulenId',['value'=>$id]) ;

$options = [
       'multiple' => true,
       'size' => 20,
   ];
//    // echo Html::activeListBox($model, $attribute, $items, $options);
   echo DualListbox::widget([
       'model' => $model,
       'attribute' => 'Person',
       'items' => $items,
       'options' => $options,
       'clientOptions' => [
           'moveOnSelect' => false,
           'selectedListLabel' => 'Selected Items',
           'nonSelectedListLabel' => 'Available Items',
       ],
   ]);
   ?>

   <div class="form-group">
       <?= Html::submitButton('Update', [
           'class' => 'btn btn-primary'
       ]) ?>
   </div>

  <?php ActiveForm::end(); ?>

