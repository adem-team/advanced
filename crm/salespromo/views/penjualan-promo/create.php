<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model crm\salespromo\models\Penjualanpromo */

$this->title = 'Create Penjualanpromo';
$this->params['breadcrumbs'][] = ['label' => 'Penjualanpromos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penjualanpromo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
