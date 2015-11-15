<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\backs\models\Posting */

$this->title = 'Update Posting: ' . ' ' . $model->ID;
$this->params['breadcrumbs'][] = ['label' => 'Postings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID, 'url' => ['view', 'id' => $model->ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="posting-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
