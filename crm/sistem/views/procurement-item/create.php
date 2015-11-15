<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\front\models\Procurement_item */

$this->title = 'Create Procurement Item';
$this->params['breadcrumbs'][] = ['label' => 'Procurement Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="procurement-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
