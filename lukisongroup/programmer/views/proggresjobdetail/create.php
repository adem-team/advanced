<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Proggresjobdetail */

$this->title = 'Create Proggresjobdetail';
$this->params['breadcrumbs'][] = ['label' => 'Proggresjobdetails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proggresjobdetail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
