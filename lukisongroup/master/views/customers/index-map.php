
<?php
use yii\helpers\Url;
use kartik\helpers\Html;
use kartik\grid\GridView;
use kartik\nav\NavX;
use yii\bootstrap\Modal;
use lukisongroup\assets\MapAsset;       /* CLASS ASSET CSS/JS/THEME Author: -wawan-*/
MapAsset::register($this);



$this->params['breadcrumbs'][] = $this->title;
$this->sideCorp = 'Customers';                 				 /* Title Select Company pada header pasa sidemenu/menu samping kiri */
$this->sideMenu = $sideMenu_control;//'umum_datamaster';   	 /* kd_menu untuk list menu pada sidemenu, get from table of database */
$this->title = Yii::t('app', 'Customers');   	 			 /* title pada header page */


function tombolCustomers(){
  $title1 = Yii::t('app', 'Customers');
  $options1 = [ 'id'=>'setting',
          //'data-toggle'=>"modal",
          // 'data-target'=>"#",
          //'class' => 'btn btn-default',
          'style' => 'text-align:left',
  ];
  $icon1 = '<span class="fa fa-cogs fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/master/customers/esm-index']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

/**
   * New|Change|Reset| Password Login
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
   */
function tombolKota(){
  $title1 = Yii::t('app', 'Kota');
  $options1 = [ 'id'=>'password',
          // 'data-toggle'=>"modal",
          // 'data-target'=>"#profile-passwrd",
          //'class' => 'btn btn-default',
         // 'style' => 'text-align:left',
  ];
  $icon1 = '<span class="fa fa-shield fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/master/customers/esm-index-city']);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

/**
   * Create Signature
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
   */
function tombolProvince(){
  $title1 = Yii::t('app', 'Province');
  $options1 = [ 'id'=>'signature',
          //'data-toggle'=>"modal",
          // 'data-target'=>"#profile-signature",
          //'class' => 'btn btn-default',
  ];
  $icon1 = '<span class="fa fa-pencil-square-o fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/master/customers/esm-index-provinsi']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

/**
   * Persinalia Employee
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
   */
function tombolKategori(){
  $title1 = Yii::t('app', 'Kategori Customers');
  $options1 = [ 'id'=>'personalia',
          //'data-toggle'=>"modal",
          // 'data-target'=>"#profile-personalia",
          // 'class' => 'btn btn-primary',
  ];
  $icon1 = '<span class="fa fa-group fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/master/customers/esm-index-kategori']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

/**
   * Performance Employee
 * @author ptrnov  <piter@lukison.com>
 * @since 1.1
   */
function tombolMap(){
  $title1 = Yii::t('app', 'Map');
  $options1 = [ 'id'=>'performance',
          //'data-toggle'=>"modal",
          // 'data-target'=>"#profile-performance",
          // 'class' => 'btn btn-danger',
  ];
  $icon1 = '<span class="fa fa-graduation-cap fa-md"></span>';
  $label1 = $icon1 . ' ' . $title1;
  $url1 = Url::toRoute(['/master/customers/esm-map']);//,'kd'=>$kd]);
  $content = Html::a($label1,$url1, $options1);
  return $content;
}

?>


<?php
	 $navmenu= NavX::widget([
		'options'=>['class'=>'nav nav-tabs'],
		'encodeLabels' => false,
		'items' => [
			['label' => 'MENU', 'active'=>true, 'items' => [
				['label' => '<span class="fa fa-user fa-md"></span>Customers', 'url' => '/master/customers/esm-index'],
				['label' => '<span class="fa fa-cogs fa-md"></span>Alias Customers', 'url' => '/master/customers/index-alias'],
				'<li class="divider"></li>',
				['label' => 'Properties', 'items' => [
					['label' => '<span class="fa fa-flag fa-md"></span>Kota', 'url' => '/master/kota-customers/esm-index-city'],
					['label' => '<span class="fa fa-flag-o fa-md"></span>Province', 'url' => '/master/customers/esm-index-provinsi'],
					['label' => '<span class="fa fa-table fa-md"></span>Category', 'url' => '/master/customers-kategori/esm-index-kategori'],
					['label' => '<span class="fa fa-table fa-md"></span>Geografis', 'url' => '/master/customers/esm-index-geo'],
					['label' => '<span class="fa fa-table fa-md"></span>Layers', 'url' => '/master/customers/esm-index-layer'],
					['label' => '<span class="fa fa-table fa-md"></span>Layers Mutasi', 'url' => '/master/customers/esm-index-layermutasi'],
					'<li class="divider"></li>',
					['label' => '<span class="fa fa-map-marker fa-md"></span>Customers Map', 'url' => '/master/customers/esm-map'],
				]],
			]],

		]
	]);
?>
<div class="content">
  <div  class="row" style="padding-left:3px">
		<div class="col-sm-12 col-md-12 col-lg-12" >
		  <!-- CUTI !-->
		  <?php
				echo $navmenu;
		  ?>
		  <!-- CUTI !-->
		</div>
		<div class="col-sm-12">
			<?php
				 echo $map = '<div id ="map" style="width:100%;height:650px; padding-bottom:50px"></div>';
			?>
		</div>
	</div>
</div>


 <?php
  /*js mapping */
 $this->registerJs("
     /*nampilin MAP*/
      var map = new google.maps.Map(document.getElementById('map'),
         {
         zoom: 9,
         center: new google.maps.LatLng(-6.229191531958687,106.65994325550469),
         mapTypeId: google.maps.MapTypeId.ROADMAP

       });

       var public_markers = [];
       var infowindow = new google.maps.InfoWindow();

   /*data json*/
  $.getJSON('http://api.lukisongroup.com/chart/esmsalesmdmaps', function(json) {

      var dataImgDefault=json.icon[0]['MAP_ICON'];
      var dataImgActive=json.icon[1]['MAP_ICON'];
     
       $.each(json.CustMap, function (i, point) {
          
             //set the icon
             //     if(point.CUST_NM == 'asep')
             //         {
             //             icon = 'http://labs.google.com/ridefinder/images/mm_20_red.png';
             //         }

                   var marker = new google.maps.Marker({
                   // icon: icon,
                   position: new google.maps.LatLng(point.MAP_LAT, point.MAP_LNG),
                   animation:google.maps.Animation.BOUNCE,
                   map: map,
                    icon : {
                  url:point.STT_ONLINE==0?dataImgDefault:dataImgActive
               }
           });

        public_markers[i] = marker;

        google.maps.event.addListener(public_markers[i], 'click', function () {
          infowindow.setContent('<h1>' + point.CUST_NM + '</h1>' + '<p>' + point.ALAMAT + '</p>');
          infowindow.open(map, public_markers[i]);
        });

         google.maps.event.addListener(public_markers[i], 'dblclick', function () {
            getmodal(point.CUST_KD)
        });


        function getmodal(cust_kd)
        {
          $.get('/master/customers/map-detail',{'cust_kd':cust_kd},function(data){
            $('#modal').modal('show')
            .find('#modalContent')
            .html(data);
          });
        }


     });


    });
   // console.trace();
    ",$this::POS_READY);


 Modal::begin([
  'headerOptions'=>[
        'style'=> 'border-radius:5px; background-color: rgba(74, 206, 231, 1)',
    ],
    'header' => '<div style="float:left;margin-right:10px" class="fa fa-user fa-2x"></div><div><h5 class="modal-title"><b>Update GPS CUSTOMERS</b></h5></div>',
    'size' => Modal::SIZE_LARGE,
  'id' => 'modal',
  //keeps from closing modal with esc key or by clicking out of the modal.
  // user must click cancel or X to close
  // 'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='modalContent'></div>";
Modal::end();

    ?>


