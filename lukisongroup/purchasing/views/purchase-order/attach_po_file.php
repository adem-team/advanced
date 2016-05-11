<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\po\Purchaseorder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="purchaseorder-form">

     <?php echo \kato\DropZone::widget([
      'options' => [
          'maxFilesize' => '2',
          'acceptedFiles'=>'image/*,application/pdf',
          'url'=>'/purchasing/purchase-order/upload?kdpo='.$kdpo.''
      ],
      'clientEvents' => [
          'complete' => "function(file){console.log(file)}",
          'removedfile' => "function(file){alert(file.name + ' is removed')}"
      ],
  ]);
?>


    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>

</div>
