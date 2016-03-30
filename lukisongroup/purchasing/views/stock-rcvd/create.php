<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\purchasing\models\stck\StockRcvd */

$this->title = Yii::t('app', 'Create Stock Rcvd');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Stock Rcvds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-rcvd-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
