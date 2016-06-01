<?php
use softark\duallistbox\DualListbox;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

 $form = ActiveForm::begin([
    'id' => 'favorite-form',
    'enableAjaxValidation' => false,
]);

echo Html::activeHiddenInput($model, 'term_id') ;

$options = [
       'multiple' => true,
       'size' => 20,
   ];
//    // echo Html::activeListBox($model, $attribute, $items, $options);
   echo DualListbox::widget([
       'model' => $model,
       'attribute' => 'INVES_ID',
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

<?php
  // $this->registerJs("
  //     $('#favorite-form').click(function() {
  //       alert('tes');
  //     return false;
  //   });
  // ",$this::POS_READY);

  ?>
