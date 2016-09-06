<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\CustomercallExpired */

$this->title = 'Create Customercall Expired';
$this->params['breadcrumbs'][] = ['label' => 'Customercall Expireds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customercall-expired-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
