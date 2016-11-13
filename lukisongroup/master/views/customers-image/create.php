<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\CustomersImage */

$this->title = 'Create Customers Image';
$this->params['breadcrumbs'][] = ['label' => 'Customers Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customers-image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
