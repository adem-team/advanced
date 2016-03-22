<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\sales\models\UserFile */

$this->title = 'Update User File: ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'User Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-file-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
