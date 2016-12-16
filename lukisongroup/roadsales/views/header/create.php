<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\roadsales\models\SalesRoadHeader */

$this->title = Yii::t('app', 'Create Sales Road Header');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sales Road Headers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-road-header-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
