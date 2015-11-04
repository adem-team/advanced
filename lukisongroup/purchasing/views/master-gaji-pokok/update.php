<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterGajiPokok */

$this->title = 'Update Master Gaji Pokok';
//$this->params['breadcrumbs'][] = ['label' => 'Master Gaji Pokoks', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'ID' => $model->ID, 'seqID' => $model->seqID]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-gaji-pokok-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
