<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model crm\salespromo\models\Stock_display */

$this->title = 'Create Stock Display';
$this->params['breadcrumbs'][] = ['label' => 'Stock Displays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-display-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
