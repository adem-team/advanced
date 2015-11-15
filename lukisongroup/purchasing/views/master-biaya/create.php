<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\master\models\MasterTunjanganpotongan */
if (Yii::$app->controller->action->id === 'tuncreate' ) {
   
   $this->title = 'Master Biaya Tunjangan';
        
    
}
else{
   
     $this->title = 'Master Biaya Potongan';
  
}

//$this->params['breadcrumbs'][] = ['label' => 'Master Tunjanganpotongans', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;

?>
<div class="master-tunjanganpotongan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
