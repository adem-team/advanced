<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\master\models\MasterBank */

$this->title = 'Insert Master Bank';
//$this->params['breadcrumbs'][] = ['label' => 'Master Banks', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-bank-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
