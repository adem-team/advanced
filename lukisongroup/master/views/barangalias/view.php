<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Barangalias */

$this->title = $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Barangaliases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="barangalias-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->ID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

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
            'KD_ALIAS',
            'KD_DISTRIBUTOR',
            'KD_PARENT',
            [
              'label'=>'Jenis',
              'attributes'=> $data
            ]
        ],
    ]) ?>

</div>
