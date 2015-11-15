<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\master\models\MasterCalonProduct */

//$this->title = 'Update Master Calon Product: ' . ' ' . $model->calonproductID;
//$this->params['breadcrumbs'][] = ['label' => 'Master Calon Products', 'url' => ['index']];
////$this->params['breadcrumbs'][] = ['label' => $model->calonproductID, 'url' => ['view', 'id' => $model->calonproductID]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-calon-product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
