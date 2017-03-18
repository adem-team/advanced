<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\efenbi\rasasayang\models\TransaksiHeader */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Transaksi Header',
]) . $model->ID;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transaksi Headers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="transaksi-header-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
