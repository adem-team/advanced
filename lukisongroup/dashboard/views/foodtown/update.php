<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\dashboard\models\Foodtown */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Foodtown',
]) . $model->Id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Foodtowns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Id, 'url' => ['view', 'id' => $model->Id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="foodtown-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
