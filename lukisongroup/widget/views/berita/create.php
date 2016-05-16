<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\Berita */
?>
<div class="berita-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'datadep'=> $datadep,
        'emp_img'=>$emp_img,
        'foto_profile'=>$foto_profile,
        'dataemploye'=>$dataemploye,
         'beritaimage'=>$beritaimage
    ]) ?>

</div>
