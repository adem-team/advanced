<?php
use lukisongroup\assets\AppAsset_front; 	
AppAsset_front::register($this);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <style>
  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
      width: 50%;
      margin: auto;
  }
  p,h3,h1
 
  </style>
</head>
<body>

<div class="container">
  <br>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">

      <div class="item active">
        <img src="http://crm.lukisongroup.com/upload/help/1.png" alt="Chania">
        <div class="carousel-caption">
          <h3>Step 1</h3>
          <p><h1>Buka <a href="http://www.lukisongroup.com">http://www.lukisongroup.com</a></h1></p>
        </div>
      </div>

      <div class="item">
        <img src="http://crm.lukisongroup.com/upload/help//2.png" alt="Chania" width="50%" height="345">
        <div class="carousel-caption">
          <h3>Step 2</h3>
          <p><h1>Cari Link Download Dan Mulai Melakukan Download</h1></p>
        </div>
      </div>
    
      <div class="item">
        <img src="http://crm.lukisongroup.com/upload/help/3.png" alt="Flower" width="460" height="345">
        <div class="carousel-caption">
          <h3>Step 3</h3>
          <p><h1>Cari File Yang Telah Didownload Dan Lakukan Penginstalan</h1></p>
        </div>
      </div>

      <div class="item">
        <img src="http://crm.lukisongroup.com/upload/help/4.png" alt="Flower" width="460" height="345">
        <div class="carousel-caption">
          <h3>Step 4</h3>
          <p><h1>Lakukan Setting Jika Smartphone Anda Tidak Memperbolehkan Install App Dari File Luar</h1></p>
        </div>
      </div>
      <div class="item">
        <img src="http://crm.lukisongroup.com/upload/help/5.png" alt="Flower" width="460" height="345">
        <div class="carousel-caption">
          <h3>Step 5</h3>
          <p><h1>Tunggu Sampai Instalasi Selesai</h1></p>
        </div>
      </div>
      <div class="item">
        <img src="http://crm.lukisongroup.com/upload/help/6.png" alt="Flower" width="460" height="345">
        <div class="carousel-caption">
          <h3>Step 6</h3>
          <p><h1>Tekan Button Get Crosswalk</h1></p>
        </div>
      </div>
      <div class="item">
        <img src="http://crm.lukisongroup.com/upload/help/7.png" alt="Flower" width="460" height="345">
        <div class="carousel-caption">
          <h3>Step 7</h3>
          <p><h1>Lakukan Penginstalan Dari PlayStore Seperti Biasanya</h1></p>
        </div>
      </div>
      <div class="item">
        <img src="http://crm.lukisongroup.com/upload/help/8.png" alt="Flower" width="460" height="345">
        <div class="carousel-caption">
        </div>
      </div>
      <div class="item">
        <img src="http://crm.lukisongroup.com/upload/help/9.png" alt="Flower" width="460" height="345">
        <div class="carousel-caption">
        </div>
      </div>
      <div class="item">
        <img src="http://crm.lukisongroup.com/upload/help/9.png" alt="Flower" width="460" height="345">
        <div class="carousel-caption">
          <h3>Step 10 </h3>
          <p><h1>Setelah Proses Instalasi Selesai Cari App Lukison Group Dan Jalankan</h1></p>
        </div>
      </div>
  
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>

</body>
</html>

