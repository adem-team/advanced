<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\dashboard\models\Foodtown */

$this->title = Yii::t('app', 'Create Foodtown');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Foodtowns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="foodtown-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
