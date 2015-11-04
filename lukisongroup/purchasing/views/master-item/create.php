<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\master\models\MasterItem */

$this->title = 'Input Master Item';
//$this->params['breadcrumbs'][] = ['label' => 'Master Items', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
