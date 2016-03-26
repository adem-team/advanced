<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\sales\models\SecheduleHeader */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Sechedule Header',
]) . $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sechedule Headers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sechedule-header-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
