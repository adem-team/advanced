
<?php
use yii\helpers\Html;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\overlays\InfoWindow;


$this->title = $model->ALAMAT;
$this->params['breadcrumbs'][] = ['label' => 'Customerskats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
  <h1><?= Html::encode($this->title) ?></h1>
<div class="col-sm-12">
<?php
if(!$model->MAP_LNG == NULL )
 {
    $coord = new LatLng(['lat' => $model->MAP_LAT, 'lng' => $model->MAP_LNG]);
    $map = new Map([
        'center' => $coord,
        'zoom' => 20,
        'width'=>1000,
        'height'=>500,
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
    echo $map->display();    
  } else {
    echo 'No location coordinates for this place could be found.';
  }
  ?>

</div> <!-- end second col -->
<?= Html::a('Back', ['index'], ['class' => 'btn btn-primary']) ?>

