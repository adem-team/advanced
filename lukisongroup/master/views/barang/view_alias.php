<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Barangalias */


?>
<div class="barangalias-view">

    <?php
    $parent = $model->KD_PARENT;
    $data = '';

    if($parent == 1)
    {
      $data = "PRODUCT";
    }
    else{
      $data = "UMUM";
    }

     ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          [
            'label'=>'Jenis',
            'value'=> $data
          ],
          [
            'label'=>'Kode Barang',
            'attribute'=>'KD_BARANG',
          ],

          [
            'attribute'=>'brgnm',
            'label'=>'Nama Barang',

          ],
            'KD_ALIAS',
            // 'KD_DISTRIBUTOR',
            [
              'attribute'=>'disnm',
              'label'=>'Nama Distributor',

            ]

        ],
    ]) ?>

</div>
