<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */

?>



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


<?php
  echo  $tabview =  DetailView::widget([
        'model' => $model,
        'attributes' => [
            'CUST_KD',
            'CUST_KD_ALIAS',
            'CUST_NM',
            // 'CUST_GRP',
            'cus.CUST_KTG_NM',


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
           [
                'label' => 'Status',
                'value' => $stat,
            ],
            'custprov.PROVINCE',
            'custkota.CITY_NAME'

        ],
    ]) ?>
