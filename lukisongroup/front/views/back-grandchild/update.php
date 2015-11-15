<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\grandchild\models\Grandchild */

$this->title = 'Update Grandchild: ' . ' ' . $model->GRANDCHILD_ID;
$this->params['breadcrumbs'][] = ['label' => 'Grandchildren', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->GRANDCHILD_ID, 'url' => ['view', 'id' => $model->GRANDCHILD_ID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="grandchild-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
