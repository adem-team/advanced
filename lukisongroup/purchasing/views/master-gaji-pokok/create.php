<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\master\models\MasterGajiPokok */

$this->title = 'Input Master Gaji Pokok';
//$this->params['breadcrumbs'][] = ['label' => 'Master Gaji Pokoks', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-gaji-pokok-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
