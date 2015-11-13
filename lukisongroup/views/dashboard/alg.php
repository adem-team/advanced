<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\tabs\TabsX;
/*use kartik\nav\NavX;
use yii\bootstrap\NavBar;
use kartik\icons\Icon;
*/
/* @var $this yii\web\View */
/* @var $model app\models\system\Dashboard */
    /*
     * ptr.nov
     * Sub Menu Access Applikasi
     */


AppAsset::register($this);
?>



        <div class="dashboard-view">
            <?php
            $tabContent= 'string the position of the tabs with respect to the tab content Should be
            string the position of the tabs with respect to the tab content Should be
            string the position of the tabs with respect to the tab content Should be
            string the position of the tabs with respect to the tab content Should be
            string the position of the tabs with respect to the tab content Should be
               ';

            echo TabsX::widget([
                'position' => TabsX::POS_ABOVE,
                'align' => TabsX::ALIGN_LEFT,
                'items' => [
                    [
                        'options' => ['id' => 'myveryownID1'],
                        'label' => 'asd',
                        'content' => $tabContent,
                        'active' => true
                    ],
                    [
                        'label' => 'SOP',
                        'content' => 'Anim pariatur cliche2...',
                        'headerOptions' => [],
                        'options' => ['id' => 'myveryownID2'],
                    ],
                    [
                        'label' => 'sd',
                        'content' => 'Anim pariatur cliche2...',
                        'headerOptions' => [],
                        'options' => ['id' => 'myveryownID2'],
                    ],
                    [
                        'label' => 'Jobdesk',
                        'content' => 'Anim pariatur cliche2...',
                        'headerOptions' => [],
                        'options' => ['id' => 'myveryownID2'],
                    ],

                ],
                'options' => ['id' => 'myveryownIDx'],
            ]);
            ?>


                <h1><?= Html::encode($this->title) ?></h1>

                <p>
                    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->CORP_ID], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->CORP_ID], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </p>

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'CORP_ID',
                        'CORP_NM',
                    ],
                ]);
                ?>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'CORP_ID',
                    'CORP_NM',
                ],
            ]);

            ?>


        </div>

</div>
