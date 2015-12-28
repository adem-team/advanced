<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\po\Purchaseorder */

$this->title = 'Permintaan Pembelian';
$this->params['breadcrumbs'][] = ['label' => 'Purchaseorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="purchaseorder-create" style="padding:10px;">

    <h1><?= Html::encode($this->title) ?></h1> <hr/>

    <?php // $this->render('_form', [
	 echo $this->render('_buat', [
        'model' => $model,
        'que' => $que,
        'quer' => $quer,
		'podet' => $podet,
		'searchModel' => $searchModel,
		'dataProvider' => $dataProvider,
    ]) ?>

</div>
