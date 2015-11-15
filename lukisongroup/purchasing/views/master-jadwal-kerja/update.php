<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\master\models\Masterjadwalkerja */

$this->title = 'Update Masterjadwalkerja: ' . ' ' . $model->CustomerID;
$this->params['breadcrumbs'][] = ['label' => 'Masterjadwalkerjas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->CustomerID, 'url' => ['view', 'CustomerID' => $model->CustomerID, 'ProductID' => $model->ProductID, 'tgl' => $model->tgl]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="masterjadwalkerja-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
