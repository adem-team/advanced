<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\master\models\MasterAbsenType */

$this->title = 'Insert Master Absen Type';
//$this->params['breadcrumbs'][] = ['label' => 'Master Absen Types', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-absen-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
