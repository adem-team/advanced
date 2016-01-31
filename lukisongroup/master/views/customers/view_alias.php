<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Barangalias */


?>
<div class="barangalias-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          [
            'label'=>'Kode Customers',
            'attribute'=>'KD_CUSTOMERS',
          ],

          [
            'attribute'=>'custnm',
            'label'=>'Nama Customers',

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
