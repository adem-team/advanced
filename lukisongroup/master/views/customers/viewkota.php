<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Kota */

$this->title = $model->CITY_NAME;
$this->params['breadcrumbs'][] = ['label' => 'Kotas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kota-view">

    <h1><?= Html::encode($this->title) ?></h1>

  

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'PROVINCE',
            'TYPE',
            'CITY_NAME',
            'POSTAL_CODE',
        ],
    ]) ?>
	
	  <p>
    
     
    </p>

</div>
