<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\master\models\Masterproduct */

$this->title = 'Update Masterproduct: ' . ' ' . $model->ProductID;
//$this->params['breadcrumbs'][] = ['label' => 'Masterproducts', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->productID, 'url' => ['view', 'id' => $model->productID]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="masterproduct-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
