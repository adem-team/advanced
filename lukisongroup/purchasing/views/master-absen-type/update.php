<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterAbsenType */

$this->title = 'Update Master Absen Type: ' . ' ' . $model->ID;
//$this->params['breadcrumbs'][] = ['label' => 'Master Absen Types', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-absen-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
