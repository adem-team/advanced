<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\master\models\MasterNoFakturPajakH */

$this->title = 'Input Master No Faktur Pajak ';
//$this->params['breadcrumbs'][] = ['label' => 'Master No Faktur Pajak Hs', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-no-faktur-pajak-h-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
