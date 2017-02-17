<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\salesmd\models\RekapStockVisit */

$this->title = Yii::t('app', 'Create Rekap Stock Visit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Rekap Stock Visits'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rekap-stock-visit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
