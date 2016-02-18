<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Terminvest */

 // $model->INVES_TYPE
// $this->params['breadcrumbs'][] = ['label' => 'Terminvests', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="terminvest-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
