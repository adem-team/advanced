<?php
use softark\duallistbox\DualListbox;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\widgets\Select2;

 $form = ActiveForm::begin([
    'id' => $model->formName(),
]);

echo $form->field($model, 'ID_INVEST')->widget(Select2::classname(), [
    'data' => $list_store,
    'options' => ['placeholder' => 'Select ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);

$options = [
       'multiple' => true,
       'size' => 20,
   ];

   echo DualListbox::widget([
       'model' => $model,
       'attribute' => 'LIST_ALL',
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


