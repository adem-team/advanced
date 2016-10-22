<?php
use softark\duallistbox\DualListbox;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use lukisongroup\widget\models\NotulenModul;

?>
<?php
// $this->registerJs($this->render('set_person.js'),$this::POS_READY);

// $this->registerJs($this->render('set_person.js'),$this::POS_READY);

 $form = ActiveForm::begin([
    'id' => 'person-form',
    'action'=>'/widget/notulen/set-person?id='.$id,
    'method'=>'post'
    // 'enableAjaxValidation' => true,
]);

echo Html::activeHiddenInput($person_form, 'NotulenId',['value'=>$id]) ;


$options = [
       'multiple' => true,
       'size' => 20,
       'id'=>'tes'

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

   echo $form->field($person_form, 'Person')->widget(DualListbox::className(),[
        'items' => $items,
        'options' => $options,
        // 'id'=>'tes',
        // 'selection' => $items,
        'clientOptions' => [
            'moveOnSelect' => false,
            'selectedListLabel' => 'Selected Items',
            'nonSelectedListLabel' => 'Available Items',
            // 'filterOnValues'=>true,
            // 'showFilterInputs'=>true,
            // 'bootstrap2Compatible'=>true,
            // 'infoText'=>false
            // 'helperSelectNamePostfix'=>'Sisca Sopiani'
        ],
    ]);
   ?>



   <div class="form-group">
       <?= Html::submitButton('Update', [
           'class' => 'btn btn-primary'
       ]) ?>

       <!-- <button type="button" id="btn-add">Click Me!</button> -->
   </div>

  <?php ActiveForm::end(); ?>

  <?php
// $this->registerJs("


//   var duallist2 = $('#bootstrap-duallistbox-selected-list_PostPerson[Person]').bootstrapDualListbox();

//   var dual =  $('select[name='PostPerson']').bootstrapDualListbox();

//   $('#btn-add').click(function() {
//   duallist2.append('ApplesOranges');
//   duallist2.bootstrapDualListbox('refresh');
// });



   // $('#person-notulen').on('show.bs.modal', function () {
   //      alert('tes');
   //       dual.append('Apples');
   //      dual.bootstrapDualListbox('refresh');   
   //          });


//  $('#mySelect').append($('<option>', {
//     value: 1,
//     text: 'My option'
// })); 
  // ",$this::POS_READY);

  ?>


  


