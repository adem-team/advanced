<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\NotulenModul */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Notulen Modul',
]) . $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Notulen Moduls'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="notulen-modul-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
