<?php

use yii\helpers\Html;
use app\master\models\MasterBank;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterBank */

$this->title = 'Update Master Bank: ' . ' ' . $model->ID;
//$this->params['breadcrumbs'][] = ['label' => 'Master Banks', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-bank-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
