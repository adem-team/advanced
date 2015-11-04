<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\master\models\MasterAccountBankVendor */

$this->title = 'Create Master Account Bank Vendor';
//$this->params['breadcrumbs'][] = ['label' => 'Master Account Bank Vendors', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-account-bank-vendor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
