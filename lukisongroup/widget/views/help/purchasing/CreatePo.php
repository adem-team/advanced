<?php
use yii\helpers\Html;
	$imgPo1= Html::img('@web/widget/docHelp/img_pur/IlustrasiCreatePO.png',  ['class' => 'pnjg', 'style'=>'width:400px;height:200px;']); 
?>
<p>
Dalam program ini, untuk proses pembuatan PO atau Purchase Order, diperlukan komponen pendukung sebagai berikut:</br>
1. <b>Master Barang</b>, terdiri dari unit barang dan kategori barang.</br>
2. <b>Master Supplier</b>, terdiri dari data supplier yang sudah di input.</br>
3. <b>Request Order</b>, Permintaan barang operational setiap department</br>
4. <b>Sales Order</b>, Permintaan barang penjualan territory 1, bisanya dilakukan oleh Sales Analize</br>
</br>
Dan dalam pembuatan Purchase order itu sendiri terdapat dua kategori:</br>
1. <b>PO Normal</b>, Pembuatan PO berdasarkan data dari RO atau SO,Po ini meliputi PO-General dan PO-Product,biasanya dalam quantity besar dan price yang juga besar.</br>
2. <b>PO Plus</b>, Pembuatan PO berdasarkan kebutuhan cepat dan masuk dalam budget harian.</br></br>
ilustrasi Create PO :
</br>
	<?=$imgPo1?>
</br>
