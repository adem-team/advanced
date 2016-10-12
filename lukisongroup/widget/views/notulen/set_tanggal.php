<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;


/* @var $this yii\web\View */
/* @var $model lukisongroup\widget\models\Notulen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notulen-form">

    <?php $form = ActiveForm::begin([
        'id'=>$model->formName(),
        // 'enableClientValidation' => true,
    ]); ?>

   <?php echo $form->field($model, 'start')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => '...'],
                        'pluginOptions' => [
                            'todayHighlight' => true,
                            'autoclose'=>true
                        ],
                        'pluginEvents'=>[
                            'show' => "function(e) {show}",
                        ],
                    ]);
        ?>

        <?php echo $form->field($model, 'end')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => '...'],
                        'pluginOptions' => [
                            'todayHighlight' => true,
                            'autoclose'=>true
                        ],
                        'pluginEvents'=>[
                            'show' => "function(e) {show}",
                        ],
                    ]);
        ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
