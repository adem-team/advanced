<?php
use yii\helpers\Html;
	$imgPopPermission1=Html::img('@web/widget/docHelp/img_pur/IlustrasiAlurPo.png',  ['class' => 'pnjg', 'style'=>'width:500px;height:200px;']);
?>
Hak akses hanya bisa di lakukan sebagai berikut: </br>
1. <b>Departmen Purchasing</b>, berwenang membuat PO Normal dan PO Plus.</br>
2. <b>Departmen F&A </b>, berwenang mengetahui/sign PO dan edit Quantity.</br>
3. <b>Director</b>, menyetujui, menolak atau menunda terbitnya PO .</br>
4. <b>Departmen Warehouse</b>, berwenng menerima barang berdasarkan kecocokan surat jalan dari supplier  dan PO yang diterbitkan. </br>
</br>
ilustrasi Alur Proces PO :</br>
<?=$imgPopPermission1?>	</br>
