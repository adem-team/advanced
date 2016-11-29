<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\SopSalesHeader */


?>
<div class="sop-sales-header-create">

    <?= $this->render('_form', [
        'model' => $model,
        'data_type_sales'=>$data_type_sales,
        'data_parent_kategori'=>$data_parent_kategori
    ]) ?>

</div>
