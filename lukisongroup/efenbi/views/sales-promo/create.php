<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\marketing\models\SalesPromo */

$this->title = Yii::t('app', 'Create Sales Promo');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sales Promos'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-promo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
