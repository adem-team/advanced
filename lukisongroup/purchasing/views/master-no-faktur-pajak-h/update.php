<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterNoFakturPajakH */

$this->title = 'Update Master No Faktur Pajak H: ' . ' ' . $model->IDFakturPajakH;
$this->params['breadcrumbs'][] = ['label' => 'Master No Faktur Pajak Hs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->IDFakturPajakH, 'url' => ['view', 'id' => $model->IDFakturPajakH]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-no-faktur-pajak-h-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
