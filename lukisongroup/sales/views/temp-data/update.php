<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\sales\models\TempData */

$this->title = 'Update Temp Data: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Temp Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="temp-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
