<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\sales\models\TempData */

$this->title = 'Create Temp Data';
$this->params['breadcrumbs'][] = ['label' => 'Temp Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="temp-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
