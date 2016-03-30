<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\purchasing\models\stck\StockInventaris */

$this->title = Yii::t('app', 'Create Stock Inventaris');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Stock Inventaris'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-inventaris-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
