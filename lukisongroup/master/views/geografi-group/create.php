<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\GeografiGroup */

$this->title = 'Create Geografi Group';
$this->params['breadcrumbs'][] = ['label' => 'Geografi Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="geografi-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
