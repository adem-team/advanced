<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\purchasing\models\stck\StockReture */

$this->title = Yii::t('app', 'Create Stock Reture');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Stock Retures'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-reture-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
