<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\warehouse\models\TypeKtg */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Type Ktg',
]) . $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Type Ktgs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="type-ktg-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
