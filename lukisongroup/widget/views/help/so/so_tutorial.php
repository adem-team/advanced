<?php
use yii\helpers\Html;
	$imgSo1= Html::img('@web/widget/docHelp/img_so/SO1.PNG',  ['class' => 'pnjg', 'style'=>'width:300px;height:200px;']); 
	$imgSo2= Html::img('@web/widget/docHelp/img_so/SO2.PNG',  ['class' => 'pnjg', 'style'=>'width:300px;height:100px;']); 
	$imgSo3= Html::img('@web/widget/docHelp/img_so/SO3.PNG',  ['class' => 'pnjg', 'style'=>'width:400px;height:400px;']); 
	$imgSo4= Html::img('@web/widget/docHelp/img_so/SO4.PNG',  ['class' => 'pnjg', 'style'=>'width:700px;height:180px;']); 
	$imgSo5= Html::img('@web/widget/docHelp/img_so/SO5.PNG',  ['class' => 'pnjg', 'style'=>'width:200px;height:200px;']); 
	$imgSo6= Html::img('@web/widget/docHelp/img_so/SO6.PNG',  ['class' => 'pnjg', 'style'=>'width:450px;height:150px;']); 
?>	
<p>
Berikut Cara Pembuatan Sales Order (SO) :</br>
<p>
1.	Klik <b>“Sales Order”</b></br>
<?php  echo $imgSo1;?><p></br>
2.	Klik <b>“+NEW”</b></br>
<?php  echo $imgSo2;?><p></br>
3.	Pilih <b>“ Perusahaan, Type, Kd Kategori, Kode Barang, Satuan Barang, Request Quantity, Informasi (jika diperlukan)”.</b> Lalu Klik <b>“Create”.</b></br>
<?php  echo $imgSo3;?><p></br>
4.	Setelah SO selesai dibuat selanjutnya klik <b>"Sign Here”</b> di kolom Created untuk memasukan Signature untuk selanjutnya di cek oleh bagian terkait.</br> 
<?php  echo $imgSo4;?><p></br>
5.	Pilih <b>“Employe Cc”</b> (User yang akan mengecek SO) serta ketikan <b>"Password Signature”</b>, lalu klik <b>“login”</b></br>
<?php  echo $imgSo5;?><p></br>
6.	Setelah Signature di isi SO yang kita buat telah selesai. Untuk selanjutnya tinggal menunggu <b>“Checked dan Approved SO”</b> oleh bagian terkait.</br>
<?php  echo $imgSo6;?><p></br>
_END_