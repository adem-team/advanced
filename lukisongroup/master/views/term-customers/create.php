<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Termcustomers */

$this->title = 'Create Termcustomers';
$this->params['breadcrumbs'][] = ['label' => 'Termcustomers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="termcustomers-create">

    <!-- <h1><Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
