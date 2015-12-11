<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Customerskat */

$this->title = $model->CUST_NM;
$this->params['breadcrumbs'][] = ['label' => 'Customerskats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customerskat-view">

    <h1><?= Html::encode($this->title) ?></h1>
<p>
        <?= Html::a('Lihat Lokasi', ['viewlokasi', 'id' => $model->CUST_KD], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Update', ['updatecus', 'id' => $model->CUST_KD], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['deletecus', 'id' => $model->CUST_KD], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        
    </p>
    <?php
   $sts = $model->STATUS;
    if($sts == 1){
        $stat = 'Aktif';
    } else {
        $stat = 'Tidak Aktif';
    }
    
    $ststoko = $model->STT_TOKO;
    if($ststoko == 0)
    {
        $ststoko = 'Sewa';
    }
    else{
        $ststoko = 'Hak Milik';
    }


    ?>
   

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'CUST_KD',
            // 'CUST_KD_ALIAS',
            'CUST_NM',
            // 'CUST_GRP',
            'CUST_KTG',
            'JOIN_DATE',
            // 'MAP_LAT',
            // 'MAP_LNG',
            'PIC',
            'ALAMAT:ntext',
            'TLP1',
            'TLP2',
            'FAX',
            'EMAIL:email',
            'WEBSITE',
            'NOTE:ntext',
            'NPWP',
           [
                'label' => 'Status Toko',
                'value' => $ststoko,
            ],
            'DATA_ALL',
            // 'CAB_ID',
            // 'CORP_ID',
            // 'CREATED_BY',
            // 'CREATED_AT',
            // 'UPDATED_BY',
            // 'UPDATED_AT',
           [
                'label' => 'Status',
                'value' => $stat,
            ],
        ],
    ]) ?>
	
	<?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>
	
 
</div>



