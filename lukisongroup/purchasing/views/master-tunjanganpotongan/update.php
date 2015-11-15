<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterTunjanganpotongan */

$this->title = 'Update Master Tunjanganpotongan: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Master Tunjanganpotongans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-tunjanganpotongan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
