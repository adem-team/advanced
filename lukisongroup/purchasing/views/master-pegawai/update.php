<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterPegawai */

$this->title = 'Update Master Pegawai: ' . ' ' . $model->NIK;
//$this->params['breadcrumbs'][] = ['label' => 'Master Pegawais', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->NIK, 'url' => ['view', 'id' => $model->NIK]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-pegawai-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
