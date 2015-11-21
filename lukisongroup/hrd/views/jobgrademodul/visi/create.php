<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\hrd\models\Visi */

$this->title = 'Create Visi';
$this->params['breadcrumbs'][] = ['label' => 'Visis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
