<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\roadsales\models\SalesRoadImage */

$this->title = Yii::t('app', 'Create Sales Road Image');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sales Road Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-road-image-create">


    <?= $this->render('_form', [
        'model' => $model,
        'data_road'=>$data_road
    ]) ?>

</div>
