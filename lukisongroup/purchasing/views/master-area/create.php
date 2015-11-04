<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\master\models\MasterArea */

$this->title = 'Input Master Area';
//$this->params['breadcrumbs'][] = ['label' => 'Master Areas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-area-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
