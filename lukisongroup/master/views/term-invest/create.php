<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Terminvest */

$this->title = 'Create Terminvest';
$this->params['breadcrumbs'][] = ['label' => 'Terminvests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="terminvest-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
