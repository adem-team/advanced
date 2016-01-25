    <?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use lukisongroup\master\models\Kategoricus;

/* @var $this yii\web\View */
/* @var $model lukisongroup\master\models\Kategoricus */
$data = Kategoricus::find()->where(['CUST_KTG'=>$model->CUST_KTG_PARENT])->one();
$hasil = $data['CUST_KTG_NM'];
  $this->title = $hasil;
$this->params['breadcrumbs'][] = ['label' => 'Kategoricuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kategoricus-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'CUST_KTG',
            // 'CUST_KTG_PARENT',
           
          'CUST_KTG_NM'
            // 'CREATED_BY',
            // 'CREATED_AT',
            // 'UPDATED_BY',
            // 'UPDATED_AT',
           // 'STATUS',
        ],
    ]) ?>
	
	<p>
      
       <!--   Html::a('Delete', ['delete', 'id' => $model->CUST_KTG], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?> -->
    </p>

</div>
