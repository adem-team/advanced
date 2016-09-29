<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="alert alert-info">
  <strong>Info!</strong> Anda Yakin Tambah Row?
</div>

<?= Html::a('Tambah Row', ['/widget/pilotproject/tambah-row'], ['class'=>'btn btn-primary']) ?>