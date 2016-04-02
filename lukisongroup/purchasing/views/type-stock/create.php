<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\purchasing\models\stck\TipeStock */

$this->title = Yii::t('app', 'Create Tipe Stock');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tipe Stocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipe-stock-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
