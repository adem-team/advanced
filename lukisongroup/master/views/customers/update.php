<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Kategoricus */

$this->title = $model->CUST_KTG_NM;
// $this->params['breadcrumbs'][] = ['label' => 'Kategoricuses', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->CUST_KTG, 'url' => ['view', 'id' => $model->CUST_KTG]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="kategoricus-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
