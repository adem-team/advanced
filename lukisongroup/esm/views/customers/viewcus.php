<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\overlays\InfoWindow;
use kartik\tabs\TabsX;


/* @var $this yii\web\View */
/* @var $model lukisongroup\esm\models\Customerskat */

$this->title = $model->CUST_NM;
$this->params['breadcrumbs'][] = ['label' => 'Customerskats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <!-- <h1> Html::encode($this->title) ?></h1> -->
    
<p>
       <?= Html::a('BACK', ['index'], ['class' => 'btn btn-primary']) ?>
  
        
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

    <?php
if(!$model->MAP_LNG == NULL )
 {
    $coord = new LatLng(['lat' => $model->MAP_LAT, 'lng' => $model->MAP_LNG]);
    $map = new Map([
        'center' => $coord,
        'zoom' => 22,
        'width'=>1000,
        'height'=>580,
    ]);    
    $marker = new Marker([
        'position' => $coord,
        'title' => $model->CUST_NM,
    ]);
    // Add marker to the map

    $marker->attachInfoWindow(
    new InfoWindow([
        'content' => $model->CUST_NM,
    ])
);
    $map->addOverlay($marker);
    $maping =  $map->display();    
  } else {
    $maping = 'No location coordinates for this place could be found.';
  }
  ?>

<div class="col-sm-12">
<?php
    $tabview =  DetailView::widget([
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

    
    </div>

    

	
	
	
<?php
     $items2=[
        [
            'label'=>'<i class="glyphicon glyphicon-user"></i> View Customers ','content'=> $tabview, //   $tabcustomers,
           

        ],
        
        [
            'label'=>'<i class="glyphicon glyphicon-map-marker"></i> Lokasi Customer','content'=>  $maping, //$tab_profile,
             'active'=>true,
        ],
       
    ];

    

echo TabsX::widget([
        'id'=>'tab2',
        'items'=>$items2,
        'position'=>TabsX::POS_LEFT,
        //'height'=>'tab-height-xs',
        'bordered'=>true,
        'encodeLabels'=>false,
        //'align'=>TabsX::ALIGN_LEFT,

    ]);

    
 




