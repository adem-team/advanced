<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Scheduledetail */

$this->title = 'Create Scheduledetail';
$this->params['breadcrumbs'][] = ['label' => 'Scheduledetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scheduledetail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
