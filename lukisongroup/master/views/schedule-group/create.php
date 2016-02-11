<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Schedulegroup */

$this->title = 'Create Schedulegroup';
$this->params['breadcrumbs'][] = ['label' => 'Schedulegroups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedulegroup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
