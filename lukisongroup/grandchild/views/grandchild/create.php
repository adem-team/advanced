<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\grandchild\models\Grandchild */

$this->title = 'Create Grandchild';
$this->params['breadcrumbs'][] = ['label' => 'Grandchildren', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grandchild-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
