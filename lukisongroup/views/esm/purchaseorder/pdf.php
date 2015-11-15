<?php 
use yii\helpers\Html;
use yii\widgets\DetailView;

use lukisongroup\models\master\Suplier;
use lukisongroup\models\master\Barangumum;
use lukisongroup\models\master\Nmperusahaan;
use lukisongroup\models\esm\po\Purchasedetail;
use lukisongroup\models\esm\Barang;
/* @var $this yii\web\View */
/* @var $model lukisongroup\models\esm\po\Purchaseorder */

$this->title = 'Detail PO';
$this->params['breadcrumbs'][] = ['label' => 'Purchaseorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
@media print {
	body { font-family: verdana, arial, sans-serif ; font-size: 8pt; }
	.pnjg{ width:120px; }
	.ttl{ text-align:center; }
	
	
	table{
		width:100%;
		border-collapse: collapse;
	}
	 th,td {
            padding: 4px 4px 4px 4px ;
			margin: 0px;
			vertical-align: top;
            }
	th {
		border-bottom: 2px solid #B2B2B2 ;
		}
	tfoot td {
		border-top: 2px solid #B2B2B2 ;
		padding-top: 20px ;
		}
	.tbl {
		border:1px solid #B2B2B2 !important;
	}
}
</style>

<div class="ttl">
	<center>
		<?php echo Html::img('@web/upload/lukison.png',  ['class' => 'pnjg']);?>
	</center>
<br/>

    <?php 
        $sup = Suplier::find()->where(['KD_SUPPLIER'=>$model->KD_SUPPLIER])->one(); 
        $pod = Purchasedetail::find()->where(['KD_PO'=>$model->KD_PO])->all(); 
    ?>

    <div style="font-size:12pt;">
        <center>
            <h3 style="margin:0px;"><u>Purchase Order</u></h3>
            <h4 style="margin:0px;">No. <?= $model->KD_PO; ?></h4>
        </center>
    </div>
    <br/><br/><br/>
</div>

<div class="purchaseorder-view" style="margin:0px 20px;">
    <table>
    <tr>
        <td style="width:50%;">

            <b><?= $sup->NM_SUPPLIER; ?></b><br/>
            <?= $sup->ALAMAT; ?><br/>
            <?= $sup->KOTA; ?><br/>
            <table>
                <tr>
                    <td>Telp / Fax</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td>&nbsp;<?= $sup->TLP; ?> / <?= $sup->FAX; ?></td>
                </tr>

                <tr>
                    <td>Email</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td>&nbsp;<?= $sup->EMAIL; ?></td>
                </tr>
            </table>
        </td>

        <td>
            <table>
                <tr>
                    <td>Date</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td>&nbsp;<?php $tgl = explode(' ', $model->CREATE_AT); echo $tgl[0]; ?></td>
                </tr>

                <tr>
                    <td>No. Order</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td>&nbsp;<?= $model->KD_PO; ?></td>
                </tr>

                <tr>
                    <td>Order By</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td>&nbsp;<?= Yii::$app->user->identity->username; ?></td>
                </tr>

                <tr>
                    <td title="Estimasi Pengiriman Barang">ETD</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td>&nbsp;<?= $model->ETD; ?></td>
                </tr>
                   
                <tr>
                    <td title="Estimasi Kedatangan Barang">ETA</td>
                    <td>&nbsp;:&nbsp;</td>
                    <td>&nbsp;<?= $model->ETA; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    </table>
    <br/><br/>


<style type="text/css">
    .tbl {width:100%; }    
    .tbl tr td{ padding: 5px; border:1px solid #B2B2B2; border-top: 1px solid #E6E6E6;  border-bottom: 0px;}
    .tbl tr .head{ padding:5px; background-color:#f2f2f2; font-weight:bold; border-bottom: 1px solid #B2B2B2; border-top: 1px solid #B2B2B2;}
</style>

    <table class="tbl">
        <tr>
            <td class="head">No.</td>
            <td class="head">Kode Barang</td>
            <td class="head">Nama Barang</td>
            <td class="head">Quantity</td>
            <td class="head">Satuan Barang</td>
            <td class="head">Harga</td>
            <td class="head">Total Harga</td>
        </tr>


        <tbody>
        <?php 
            $total = 0;
            $a=0; foreach ($pod as $key => $val) { $a=$a+1;

            $ckBrg = explode('.', $val->KD_BARANG);
            if($ckBrg[0] == 'BRG'){
                $nmBrg = Barang::find('NM_BARANG')->where(['KD_BARANG'=>$val->KD_BARANG])->one();
            } else if($ckBrg[0] == 'BRGU') {
                $nmBrg = Barangumum::find('NM_BARANG')->where(['KD_BARANG'=>$val->KD_BARANG])->one();
            }

            $ckUnit = preg_replace("/[^A-Z\']/", '', $val->UNIT);
            if($ckUnit == 'U'){
                $brg = lukisongroup\models\master\Unitbarang::find('NM_UNIT')->where(['KD_UNIT'=>$val->UNIT])->one();
            } else {
                $brg = lukisongroup\models\esm\Unitbarang::find('NM_UNIT')->where(['KD_UNIT'=>$val->UNIT])->one();
            }
        ?>

            <tr>
                <td><?= $a ?></td>
                <td><?= $val->KD_BARANG ?></td>
                <td><?= $nmBrg->NM_BARANG ?></td>
                <td><?= $val->QTY ?></td>
                <td><?= $brg->NM_UNIT ?></td>
                <td><?= Yii::$app->mastercode->Rupiah($val->HARGA) ?></td>

                <?php $ttl = $val->HARGA * $val->QTY; ?>
                <td><?= Yii::$app->mastercode->Rupiah($ttl) ?></td>
            </tr>
            <?php   
                $total = $total + $ttl; }

                $pjk = $model->PAJAK;
                $disc = $model->DISC;
                $devCost = $model->DELIVERY_COST;
                $hslPjk = ($pjk / 100) * ($total - $disc);

                $hsl = $total - $disc + $devCost + $hslPjk ;
            ?>


            <tr>
                <td colspan="5" rowspan="5" style="border:1px solid #B2B2B2; font-size:11pt; color:#666666;">Terbilang : <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i><b>
                    <?php 
                        $kd = Yii::$app->mastercode->Terbilang($hsl); 
                        echo $kd;
                    ?> Rupiah</b></i>
                </td>
                <td style="text-align:right; border:1px solid #B2B2B2; background-color:#f2f2f2;"><b>Sub Total</b></td>
                <td style="border:1px solid #B2B2B2; background-color:#f2f2f2;"><b><?= Yii::$app->mastercode->Rupiah($total) ?></b></td>
            </tr>


            <tr>
                <td style="text-align:right; background-color:#f2f2f2; border:1px solid #B2B2B2;"><b>Disc.</b></td>
                <td style="border:1px solid #B2B2B2; background-color:#f2f2f2;"><b><?= Yii::$app->mastercode->Rupiah($disc) ?></b></td>
            </tr>
            <tr>
                <td style="text-align:right; background-color:#f2f2f2; border:1px solid #B2B2B2;"><b>PPN <?= $pjk; ?> %</b></td>
                <td style="border:1px solid #B2B2B2; background-color:#f2f2f2;"><b><?= Yii::$app->mastercode->Rupiah($hslPjk) ?></b></td>
            </tr>
            <tr>
                <td style="text-align:right; background-color:#f2f2f2; border:1px solid #B2B2B2;"><b>Delv. Cost</b></td>
                <td style="border:1px solid #B2B2B2; background-color:#f2f2f2;"><b><?= Yii::$app->mastercode->Rupiah($devCost) ?></b></td>
            </tr>

			
            <tr>
                <td style="text-align:right; background-color:#f2f2f2; border:1px solid #B2B2B2;"><b>Grand Total</b></td>
                <td style="border:1px solid #B2B2B2; background-color:#f2f2f2;"><b><?= Yii::$app->mastercode->Rupiah($hsl) ?></b></td>
            </tr>

        </tbody>
    </table>

    <br/><br/>
    <?php 
        $ship = Nmperusahaan::find()->where(['ID' => $model->SHIPPING])->one(); 
        $bill = Nmperusahaan::find()->where(['ID' => $model->BILLING])->one(); 
    ?>
        <table style="padding: 5px; ">
            <tr>
                <td>
                    <h3><u>Shipping Address :</u></h3>
                    <?php echo '<b>'.$ship->NM_ALAMAT.'</b>'; ?><br/>
                    <?php echo $ship->ALAMAT_LENGKAP; ?><br/><br/>
                    <?php echo 'Tlp : '.$ship->TLP; ?><br/>
                    <?php echo 'Fax : '.$ship->FAX; ?><br/>
                    <?php echo 'CP&nbsp; : '.$ship->CP; ?><br/>
                </td>

                <td>
                    <h3><u>Billing Address :</u></h3>
                    <?php echo '<b>'.$bill->NM_ALAMAT.'</b>';?><br/>
                    <?php echo $bill->ALAMAT_LENGKAP;?><br/><br/>
                    <?php echo 'Tlp : '.$bill->TLP;?><br/>
                    <?php echo 'Fax : '.$bill->FAX;?><br/>
                    <?php echo 'CP&nbsp; : '.$bill->CP; ?><br/>
                </td>
            </tr>

            <tr><td colspan="2"><br/><br/></td></tr>

            <tr>
                <td colspan="2"  style="border-bottom:1px solid #333; border-top:1px solid #333;"> 
                    <b>Note :</b><br/><?= $model->NOTE; ?>
                    <br/><br/><br/><br/>
                </td>
            </tr>
        </table>
</div>


