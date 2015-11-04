<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterBiaya */

$this->title = 'Update Master Biaya: ' . ' ' . $model->BiayaID;
$this->params['breadcrumbs'][] = ['label' => 'Master Biayas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->BiayaID, 'url' => ['view', 'id' => $model->BiayaID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-biaya-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
