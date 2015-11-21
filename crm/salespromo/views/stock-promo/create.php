<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model crm\salespromo\models\Stock_promo */

$this->title = 'Create Stock Promo';
$this->params['breadcrumbs'][] = ['label' => 'Stock Promos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-promo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
