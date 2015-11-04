<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\master\models\MasterBankgroup */

$this->title = 'Insert Master Bankgroup';
//$this->params['breadcrumbs'][] = ['label' => 'Master Bankgroups', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-bankgroup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
