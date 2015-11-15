<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterVendor */

$this->title = 'Update Master Vendor: ' . ' ' . $model->VendorID;
//$this->params['breadcrumbs'][] = ['label' => 'Master Vendors', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->VendorID, 'url' => ['view', 'id' => $model->VendorID]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-vendor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
