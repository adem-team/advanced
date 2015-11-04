<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterAccountBankVendor */

$this->title = 'Update Master Account Bank Vendor: ' . ' ' . $model->AccountNo;
$this->params['breadcrumbs'][] = ['label' => 'Master Account Bank Vendors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->AccountNo, 'url' => ['view', 'id' => $model->AccountNo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-account-bank-vendor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
