<?php
// use yii\web\JsExpression;
// use yii\helpers\Html;
// use yii\bootstrap\Modal;

use lukisongroup\assets\MapAsset;       /* CLASS ASSET CSS/JS/THEME Author: -ptr.nov-*/
MapAsset::register($this);  

?>


                <!-- Html::textInput('PPN',false,['id'=>'tes','disabled'=>false, 'style'=> 'width:400px;']) ?> -->
      

<?php
   
    //  \pigolab\locationpicker\LocationPickerWidget::widget([
    //    // 'key' => 'http://maps.google.com/maps/api/js?sensor=false&libraries=places', // optional , Your can also put your google map api key
    //    'options' => [
    //         // 'id'=>'tesq',
    //     // 'enableSearchBox' => true,
    //         'style' => 'width: 100%; height: 400px',
    //         'enableSearchBox' => true, // Optional , default is true
    //     'searchBoxOptions' => [ // searchBox html attributes
    //         'style' => 'width: 300px;', // Optional , default width and height defined in css coordinates-picker.css
    //                 ], // map canvas width and height
    //     ] ,
          

    //     'clientOptions' => [
    //         'location' => [
    //             'latitude'  => -6.214620,
    //             'longitude' => 106.845130 ,
			
    //         ],
    //         'radius'    => 300,
    //         'inputBinding' => [
    //             'latitudeInput'     => new JsExpression("$('#customers-map_lat')"),
    //              'longitudeInput'    => new JsExpression("$('#customers-map_lng')"),
    //             // 'radiusInput'       => new JsExpression("$('#us2-radius')"),
    //             'locationNameInput' => new JsExpression("$('#tes')")
    //         ],
    //         'enableAutocomplete' => true,
    //     ]        
    // ]);

 $this->registerJs("

// nampilin MAP
 var map = new google.maps.Map(document.getElementById('map'),
      {
        zoom: 12,
        center: new google.maps.LatLng(-6.229191531958687,106.65994325550469),
        mapTypeId: google.maps.MapTypeId.ROADMAP

    });


        
    var public_markers = [];
    var infowindow = new google.maps.InfoWindow();

//data
 $.getJSON('/esm/customers/map', function(json) { 

    for (var i in public_markers)
    {
        public_markers[i].setMap(null);
    }

    $.each(json, function (i, point) {
        // alert(point.MAP_LAT);
 
// //set the icon 
//     if(point.CUST_NM == 'asep')
//         {
//             icon = 'http://labs.google.com/ridefinder/images/mm_20_red.png';
//         }

            var marker = new google.maps.Marker({
            // icon: icon,
            position: new google.maps.LatLng(point.MAP_LAT, point.MAP_LNG),
            animation:google.maps.Animation.BOUNCE,
            map: map,
             icon : 'http://labs.google.com/ridefinder/images/mm_20_red.png'
        });

         public_markers[i] = marker;

        google.maps.event.addListener(public_markers[i], 'mouseover', function () {
            infowindow.setContent('<h1>' + point.ALAMAT + '</h1>' + '<p>' + point.CUST_NM + '</p>');
            infowindow.open(map, public_markers[i]);
        });


    });

 
//  });
    
// //     // console.trace();

//      ",$this::POS_READY);
?>

