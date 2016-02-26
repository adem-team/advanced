<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Kar_finger */

$this->title = 'Update Kar Finger: ' . ' ' . $model->NO_URUT;
$this->params['breadcrumbs'][] = ['label' => 'Kar Fingers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->NO_URUT, 'url' => ['view', 'id' => $model->NO_URUT]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kar-finger-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
