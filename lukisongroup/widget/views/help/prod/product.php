<?php
use yii\helpers\Html;
	$imgProd= Html::img('@web/widget/docHelp/img_prod/PROD.PNG',  ['class' => 'pnjg', 'style'=>'width:1000px;height:300px;']); 
	$imgProd1= Html::img('@web/widget/docHelp/img_prod/PROD1.PNG',  ['class' => 'pnjg', 'style'=>'width:400px;height:120px;']); 
	$imgProd2= Html::img('@web/widget/docHelp/img_prod/PROD2.PNG',  ['class' => 'pnjg', 'style'=>'width:220px;height:500px;']); 	
	$imgProd3= Html::img('@web/widget/docHelp/img_prod/PROD3.PNG',  ['class' => 'pnjg', 'style'=>'width:200px;height:100px;']);
	$imgProd4= Html::img('@web/widget/docHelp/img_prod/PROD4.PNG',  ['class' => 'pnjg', 'style'=>'width:500px;height:600px;']); 	
	$imgProd5= Html::img('@web/widget/docHelp/img_prod/PROD5.PNG',  ['class' => 'pnjg', 'style'=>'width:170px;height:120px;']);
	$imgUmum1= Html::img('@web/widget/docHelp/img_prod/UMUM1.PNG',  ['class' => 'pnjg', 'style'=>'width:220px;height:500px;']);	
	$imgUmum2= Html::img('@web/widget/docHelp/img_prod/UMUM2.PNG',  ['class' => 'pnjg', 'style'=>'width:150px;height:100px;']);
	$imgUmum3= Html::img('@web/widget/docHelp/img_prod/UMUM3.PNG',  ['class' => 'pnjg', 'style'=>'width:500px;height:600px;']);
	$imgUmum4= Html::img('@web/widget/docHelp/img_prod/UMUM4.PNG',  ['class' => 'pnjg', 'style'=>'width:170px;height:120px;']);	
	$imgType1= Html::img('@web/widget/docHelp/img_prod/TYPE1.PNG',  ['class' => 'pnjg', 'style'=>'width:220px;height:500px;']);	
	$imgType2= Html::img('@web/widget/docHelp/img_prod/TYPE2.PNG',  ['class' => 'pnjg', 'style'=>'width:150px;height:100px;']);
?>	
<p>
<h4>Barang Produk</h4></br>
<p>
Berikut cara pembuatan Barang Produk :</br>
1. Setelah Login, Klik <b>Company</b> lalu klik <b>Master Data.</b></br>
<?php  echo $imgProd1;?><p></br>
2. Pilih <b>Barang Produk.</b></br>
<?php  echo $imgProd2;?><p></br>
3. Pilih <b>Add Items.</b></br>
<?php  echo $imgProd3;?><p></br>
4. Masukan pada form seperti <b>Nama Perusahaan, Type, Category, Nama Barang, Unit, Nama Supplier, Note, Status dan Upload Gambar Produk tersebut,</b> lalu klik <b>Tambah Barang.</b></br>
<?php  echo $imgProd4;?><p></br>  
Berikut tampilan form Barang Produk yang telah dibuat :
 <?php  echo $imgProd;?><p></br>
kita juga bisa melihat Item Barang Produk, menghapus, merubah, serta membuat kode alias produk tersebut dengan cara klik <b>Actions.</b></br>
  <?php  echo $imgProd5;?><p></br>

_END_

<p></br></br>
<h4>Barang Umum</h4></br>
<p>
Berikut cara pembuatan Barang Umum :</br>
1. Setelah Login, Klik <b>Company</b> lalu klik <b>Master Data.</b></br>
<?php  echo $imgProd1;?><p></br>
2. Pilih <b>Barang Umum.</b></br>
<?php  echo $imgUmum1;?><p></br>
3. Pilih <b>Add Items.</b></br>
<?php  echo $imgUmum2;?><p></br>
4. Masukan pada form seperti <b>Nama Perusahaan, Type, Category, Nama Barang, Unit, Nama Supplier, Harga Suplier, Note, Status dan Upload Gambar Produk tersebut,</b> lalu klik <b>Tambah Barang.</b></br>
<?php  echo $imgUmum3;?><p></br>  
kita juga bisa melihat Item Barang Umum, menghapus, dan merubah barang umum tersebut dengan cara klik <b>Actions.</b></br>
  <?php  echo $imgUmum4;?><p></br>

_END_

<p></br></br>
<h4>Barang Type</h4></br>
<p>
Berikut cara penambahan Type untuk Barang Produk / Umum :</br>
1. Setelah Login, Klik <b>Company</b> lalu klik <b>Master Data.</b></br>
<?php  echo $imgProd1;?><p></br>
2. Pilih <b>Barang Tipe.</b></br>
<?php  echo $imgType1;?><p></br>
3. Pilih <b>Add Type.</b></br>
<?php  echo $imgType2;?><p></br>
4. Masukan pada form seperti <b>Nama Perusahaan, Type, Category, Nama Barang, Unit, Nama Supplier, Harga Suplier, Note, Status dan Upload Gambar Produk tersebut,</b> lalu klik <b>Tambah Barang.</b></br>
<?php  echo $imgUmum3;?><p></br>  
kita juga bisa melihat Item Barang Umum, menghapus, dan merubah barang umum tersebut dengan cara klik <b>Actions.</b></br>
  <?php  echo $imgUmum4;?><p></br>

_END_

