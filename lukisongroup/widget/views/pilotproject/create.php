<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\models\widget\Pilotproject */

$this->title = 'Create Header Pilot Project';
$this->params['breadcrumbs'][] = ['label' => 'Pilotprojects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilotproject-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
