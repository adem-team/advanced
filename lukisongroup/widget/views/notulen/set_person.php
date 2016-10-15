<?php
use softark\duallistbox\DualListbox;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use lukisongroup\widget\models\NotulenModul;

?>
<?php

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

   //  echo DualListbox::widget([
   //     'model' => $model,
   //     'attribute' => 'Person',
   //    // 'name' => 'coy',
      
   //     'items' => $items,
   //     // 'selection' => $items1,
   //     'options' => $options,
   //     'clientOptions' => [
   //         'moveOnSelect' => false,

   //         'selectedListLabel' => 'Selected Items',
   //         'nonSelectedListLabel' => 'Available Items',
   //     ],
   // ]);

   echo $form->field($model, 'Person')->widget(DualListbox::className(),[
        'items' => $items,
        'options' => $options,
        // 'selection' => $items1,
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


