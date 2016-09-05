<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\CustomercallTimevisit */

$this->title = 'Create Customercall Timevisit';
$this->params['breadcrumbs'][] = ['label' => 'Customercall Timevisits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customercall-timevisit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
