<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\master\models\MasterVendor */

$this->title = 'input Master Vendor';
//$this->params['breadcrumbs'][] = ['label' => 'Master Vendors', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-vendor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
