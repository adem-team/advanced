<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\master\models\MasterCalonProduct */

$this->title = 'Create Master Calon Product';
//$this->params['breadcrumbs'][] = ['label' => 'Master Calon Products', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-calon-product-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
