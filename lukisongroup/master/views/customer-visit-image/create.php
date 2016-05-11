<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\CustomerVisitImage */

$this->title = Yii::t('app', 'Create Customer Visit Image');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customer Visit Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-visit-image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
