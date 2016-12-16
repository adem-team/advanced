<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\roadsales\models\SalesRoadList */

$this->title = Yii::t('app', 'Create Sales Road List');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sales Road Lists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-road-list-create">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
