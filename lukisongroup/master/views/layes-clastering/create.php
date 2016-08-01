<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\LayesClastering */

$this->title = 'Create Layes Clastering';
$this->params['breadcrumbs'][] = ['label' => 'Layes Clasterings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="layes-clastering-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
