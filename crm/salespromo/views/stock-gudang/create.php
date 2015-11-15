<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model crm\salespromo\models\Stock_gudang */

$this->title = 'Create Stock Gudang';
$this->params['breadcrumbs'][] = ['label' => 'Stock Gudangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-gudang-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
