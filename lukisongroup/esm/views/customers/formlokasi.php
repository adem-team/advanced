<?php
use yii\web\JsExpression;
use yii\helpers\Html;
use yii\bootstrap\Modal;

?>


                <?= Html::textInput('PPN',false,['id'=>'tes','disabled'=>false, 'style'=> 'width:400px;']) ?>
      

<?php
   
    echo \pigolab\locationpicker\LocationPickerWidget::widget([
       // 'key' => 'http://maps.google.com/maps/api/js?sensor=false&libraries=places', // optional , Your can also put your google map api key
       'options' => [
            // 'id'=>'tesq',
        // 'enableSearchBox' => true,
            'style' => 'width: 100%; height: 400px',
            'enableSearchBox' => true, // Optional , default is true
        'searchBoxOptions' => [ // searchBox html attributes
            'style' => 'width: 300px;', // Optional , default width and height defined in css coordinates-picker.css
                    ], // map canvas width and height
        ] ,
          

        'clientOptions' => [
            'location' => [
                'latitude'  => -6.214620,
                'longitude' => 106.845130 ,
			
            ],
            'radius'    => 300,
            'inputBinding' => [
                'latitudeInput'     => new JsExpression("$('#customers-map_lat')"),
                 'longitudeInput'    => new JsExpression("$('#customers-map_lng')"),
                // 'radiusInput'       => new JsExpression("$('#us2-radius')"),
                'locationNameInput' => new JsExpression("$('#tes')")
            ],
            'enableAutocomplete' => true,
        ]        
    ]);
?>

