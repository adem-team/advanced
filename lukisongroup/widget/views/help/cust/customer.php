<?php
use yii\helpers\Html;
	$imgCust= Html::img('@web/widget/docHelp/img_cust/CUST.PNG',  ['class' => 'pnjg', 'style'=>'width:1000px;height:300px;']); 
	$imgCust1= Html::img('@web/widget/docHelp/img_cust/CUST1.PNG',  ['class' => 'pnjg', 'style'=>'width:400px;height:120px;']); 
	$imgCust2= Html::img('@web/widget/docHelp/img_cust/CUST2.PNG',  ['class' => 'pnjg', 'style'=>'width:220px;height:500px;']); 	
	$imgCust3= Html::img('@web/widget/docHelp/img_cust/CUST3.PNG',  ['class' => 'pnjg', 'style'=>'width:500px;height:50px;']); 
	$imgCust4= Html::img('@web/widget/docHelp/img_cust/CUST4.PNG',  ['class' => 'pnjg', 'style'=>'width:500px;height:400px;']); 
	$imgCust5= Html::img('@web/widget/docHelp/img_cust/CUST5.PNG',  ['class' => 'pnjg', 'style'=>'width:500px;height:300px;']); 	
?>	
<p>
Tampilan awal Menu Customer :</br>
<?php  echo $imgCust;?><p></br>
Fungsi - fungsi Tombol (Button) :</br>
1. <b>Create,</b> Membuat data customer baru.</br> 
2. <b>Refresh,</b> Menyegarkan data customer.</br> 
3. <b>Export All,</b> Mengcopy / Memindahkan data customer ke Excell secara keseluruhan.</br> 
4. <b>Export Selected,</b> Mengcopy / Memindahkan data customer ke Excell secara pilihan.</br>
5. <b>Pilih Export,</b> Mengcopy / Memindahkan data customer ke Excell berdasarkan kategori.</br>
6. <b>Pilih Deleted,</b> Menghapus data customer.</br> 
<p>
Berikut cara pembuatan Data Customer :</br>
1. Setelah Login, Klik <b>Company</b> lalu klik <b>Master Data.</b></br>
<?php  echo $imgCust1;?><p></br>
2. Pilih <b>Customer.</b></br>
<?php  echo $imgCust2;?><p></br>
3. Pilih <b>Create.</b></br>
<?php  echo $imgCust3;?><p></br>
4. Jika Customer sudah ada <b>"Parent"</b> dalam customer group maka checkbox pada <b>Is Parent</b> tidak perlu dicentang, lalu masukan pada box<b> Nama Customer, Alamat, Customer Group, Nomor Telepon, PIC Customer dan Tanggal Gabung</b> lalu klik <b>Create.</b></br>
<?php  echo $imgCust4;?><p></br>   
5. dan Jika Customer belum ada <b>"Parent"</b> dalam customer group maka checkbox pada <b>Is Parent</b> dicentang, lalu masukan pada box<b> Nama Customer, Alamat, Nomor Telepon, PIC Customer dan Tanggal Gabung</b> lalu klik <b>Create.</b></br>
<?php  echo $imgCust5;?><p></br>
_END_