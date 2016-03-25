<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\sistem\models\Absensi */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Absensi',
]) . $model->idno;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Absensis'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idno, 'url' => ['view', 'id' => $model->idno]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="absensi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
