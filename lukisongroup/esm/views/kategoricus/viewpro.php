<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Province */

$this->title = $model->PROVINCE;
$this->params['breadcrumbs'][] = ['label' => 'Provinces', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="province-view">

    <h1><?= Html::encode($this->title) ?></h1>

   

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'PROVINCE',
        ],
    ]) ?>

	 <p>
        
      
    </p>
</div>
