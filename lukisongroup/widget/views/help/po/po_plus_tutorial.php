<?php
use yii\helpers\Html;
	$imgPo1= Html::img('@web/widget/docHelp/img_po/PO1.PNG',  ['class' => 'pnjg', 'style'=>'width:300px;height:200px;']); 
	$imgPo2= Html::img('@web/widget/docHelp/img_po/PO2.PNG',  ['class' => 'pnjg', 'style'=>'width:400px;height:100px;']); 
	$imgPo3= Html::img('@web/widget/docHelp/img_po/PO3.PNG',  ['class' => 'pnjg', 'style'=>'width:200px;height:200px;']); 
	$imgPo= Html::img('@web/widget/docHelp/img_po/PO.PNG',  ['class' => 'pnjg', 'style'=>'width:1000px;height:600px;']);	
	$imgPo4= Html::img('@web/widget/docHelp/img_po/PO4.PNG',  ['class' => 'pnjg', 'style'=>'width:500px;height:400px;']); 
	$imgPo5= Html::img('@web/widget/docHelp/img_po/PO5.PNG',  ['class' => 'pnjg', 'style'=>'width:300px;height:300px;']); 
	$imgPo6= Html::img('@web/widget/docHelp/img_po/PO6.PNG',  ['class' => 'pnjg', 'style'=>'width:450px;height:300px;']);
	$imgPo7= Html::img('@web/widget/docHelp/img_po/PO7.PNG',  ['class' => 'pnjg', 'style'=>'width:350px;height:300px;']); 
	$imgPo8= Html::img('@web/widget/docHelp/img_po/PO8.PNG',  ['class' => 'pnjg', 'style'=>'width:350px;height:300px;']); 	
	$imgPo9= Html::img('@web/widget/docHelp/img_po/PO9.PNG',  ['class' => 'pnjg', 'style'=>'width:900px;height:500px;']); 	
	$imgPo10= Html::img('@web/widget/docHelp/img_po/PO10.PNG',  ['class' => 'pnjg', 'style'=>'width:900px;height:500px;']);
	$imgPo11= Html::img('@web/widget/docHelp/img_po/PO11.PNG',  ['class' => 'pnjg', 'style'=>'width:400px;height:150px;']); 
	$imgPo12= Html::img('@web/widget/docHelp/img_po/PO12.PNG',  ['class' => 'pnjg', 'style'=>'width:200px;height:200px;']);  
	$imgPo13= Html::img('@web/widget/docHelp/img_po/PO13.PNG',  ['class' => 'pnjg', 'style'=>'width:450px;height:150px;']); 	
?>	
<p>
Berikut Cara Pembuatan Purchase Order (PO) :</br>
<p>
1.	Klik <b>“Purchase Order”.</b></br>
<?php  echo $imgPo1;?><p></br>
2. Klik <b>“+New PO”.</b></br>
<?php  echo $imgPo2;?><p></br>
3. Pilih <b>“PO General”</b> (jika barang umum) dan Pilih <b>"PO Product"</b> (jika barang produk).</b></br>
<?php  echo $imgPo3;?><p></br>
Berikut tampilan PO awal yang akan di buat :</br>
<?php  echo $imgPo;?><p></br>
4. Selanjutnya Cari RO (Request Order) yang akan dibuatkan PO, klik <b>“Action”</b> lalu pilih <b>"SendPo"</b> selanjutnya centang pada bagian disamping Price, dan PO telah terbentuk.</br>
<?php  echo $imgPo4;?><p></br>
5. Masukan nama Supplier dengan Klik pada tanda anak panah berwarna orange, dan cari supplier pada <b>“Kd. Supplier”</b> lalu klik<b>"Simpan".</b></br>
<?php  echo $imgPo5;?><p></br>
6. Klik pada <b>"ETD dan ETA"</b> untuk menentukan  Estimasi Waktu Pengiriman Barang dan Estimasi Waktu Kedatangan Barang, lalu klik<b>"Simpan".</b></br>
<?php  echo $imgPo6;?><p></br>
7. Masukan Alamat Pengiriman dengan Klik pada tanda anak panah berwarna biru pada <b>"Shipping Address"</b> dan cari alamat pengiriman pada <b>“Shipping”</b> lalu klik<b>"Simpan".</b></br>
<?php  echo $imgPo7;?><p></br>
8. Masukan Alamat Penagihan pembayaran PO dengan Klik pada tanda anak panah berwarna biru pada <b>"Billing Address"</b> dan cari alamat penagihan pada <b>“Billing”</b> lalu klik<b>"Simpan".</b></br>
<?php  echo $imgPo8;?><p></br>
9. Masukan Jangka Waktu pembayaran PO dengan Klik pada tanda (+) berwarna biru pada <b>"Term Of Payment"</b> lalu pilih jenis pembayaran pada <b>“Type Of Payment”</b>dan durasi pembayaran pada <b>“Duration Of Payment”</b> lalu klik<b>"Save".</b></br>
<?php  echo $imgPo9;?><p></br>
10. Masukan Catatan untuk PO yang akan dikirim dengan Klik pada tanda (+) berwarna biru pada <b>"General Notes"</b> setelah memasukan catatan lalu klik<b>"Save".</b></br>
<?php  echo $imgPo10;?><p></br>
11.	Setelah PO selesai dibuat selanjutnya klik <b>“Sign Here”</b> di kolom Created untuk memasukan Signature untuk selanjutnya di cek oleh bagian terkait.</br>
<?php  echo $imgPo11;?><p></br>
12.	Pilih <b>“Employe Cc”</b> (User yang akan mengecek PO) serta masukan <b>"Password Signature”</b>, lalu klik <b>“login”</b></br>
<?php  echo $imgPo12;?><p></br>
13.	Setelah Signature di isi, PO yang kita buat telah selesai. Untuk selanjutnya tinggal menunggu <b>“Checked dan Approved PO”</b> oleh bagian terkait.</br>
<?php  echo $imgPo13;?><p></br>
_END_