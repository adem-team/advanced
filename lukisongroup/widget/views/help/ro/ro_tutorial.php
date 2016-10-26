<?php
use yii\helpers\Html;
	$imgRo1= Html::img('@web/widget/docHelp/img_ro/RO1.PNG',  ['class' => 'pnjg', 'style'=>'width:300px;height:200px;']); 
	$imgRo2= Html::img('@web/widget/docHelp/img_ro/RO2.PNG',  ['class' => 'pnjg', 'style'=>'width:300px;height:100px;']); 
	$imgRo3= Html::img('@web/widget/docHelp/img_ro/RO3.PNG',  ['class' => 'pnjg', 'style'=>'width:400px;height:400px;']);
	$imgRo4= Html::img('@web/widget/docHelp/img_ro/RO4.PNG',  ['class' => 'pnjg', 'style'=>'width:400px;height:400px;']);
	$imgRo5= Html::img('@web/widget/docHelp/img_ro/RO5.PNG',  ['class' => 'pnjg', 'style'=>'width:700px;height:180px;']);
	$imgRo6= Html::img('@web/widget/docHelp/img_ro/RO6.PNG',  ['class' => 'pnjg', 'style'=>'width:200px;height:200px;']);
	$imgRo7= Html::img('@web/widget/docHelp/img_ro/RO7.PNG',  ['class' => 'pnjg', 'style'=>'width:450px;height:150px;']);
?>	
<p>
Berikut Cara Pembuatan Request Order (RO) :</br>
<p>
1.	Klik <b>“Request Order”</b></br>
<?php  echo $imgRo1;?><p></br>
2. Klik <b>“+New”</b></br>
<?php  echo $imgRo2;?><p></br>
3. Checked <b>“New”</b>(Jika ingin membuat RO baru) dan isi <b>“New Item Barang, Harga, Request Quantity, Satuan Barang, Informasi (jika diperlukan)”.</b> Lalu Klik <b>“Create”.</b></br>
<?php  echo $imgRo3;?><p></br>
4.	Checked <b>“ Search”</b> (Jika ingin membuat RO yang sudah ada) dan Pilih <b>“Nama Barang, Request Quantity, Satuan Barang, Informasi (jika diperlukan)”.</b> Lalu Klik <b>“Create”.</b></br>
<?php  echo $imgRo4;?><p></br>
5.	Setelah RO selesai dibuat selanjutnya klik <b>“Sign Here”</b> di kolom Created untuk memasukan Signature untuk selanjutnya di cek oleh bagian terkait.</br>
<?php  echo $imgRo5;?><p></br>
6.	Pilih <b>“Employe Cc”</b> (User yang akan mengecek RO) serta masukan <b>"Password Signature”</b>, lalu klik <b>“login”</b></br>
<?php  echo $imgRo6;?><p></br>
7.	Setelah Signature di isi RO yang kita buat telah selesai. Untuk selanjutnya tinggal menunggu <b>“Checked dan Approved RO”</b> oleh bagian terkait.</br>
<?php  echo $imgRo7;?><p></br>
_END_