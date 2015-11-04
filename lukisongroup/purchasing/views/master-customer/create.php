<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\master\models\MasterCustomer */

$this->title = 'Input Master Customer';
//$this->params['breadcrumbs'][] = ['label' => 'Master Customers', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-customer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
       // 'model' => $model,
    ]) ?>

</div>
