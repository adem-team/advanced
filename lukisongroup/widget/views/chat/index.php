<?php

/* extensions*/
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\tabs\TabsX;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\View;
use lukisongroup\widget\models\ChatTest;


	/*
	 * Jangan di Hapus ...
	 * Chat Menu Select Dashboard
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.0
	*/
	$this->sideMenu = $ctrl_chat!=''? $ctrl_chat:'mdefault';
	/*GROUP CHART*/
	
// componen user
    // $profile = Yii::$app->getUserOpt->profile_user()->emp;
    // $emp_nm = $profile->EMP_NM.' '.$profile->EMP_NM_BLK;

    // $customer = ChatTest::find()->asArray()->all(); // find all by query (using the `active` scope)

    //print_r($customer);

?>

<div class="col-lg-12">
    <div class="box box-primary direct-chat direct-chat-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Simple Chat</h3>
        </div>
        <div class="box-body">
            <div class="direct-chat-messages" id="message-container">
					<!-- <div id="notification" ></div> -->
            </div>
        </div>
        <div class="box-footer">
            <?= Html::beginForm(['/widget/chat/send-chat'], 'POST', [
                    'id' => 'chat-form'
                ]) ?>
            <div class="input-group">
               <?= Html::textInput('message', null, [
                                'id' => 'message-field',
                                'class' => 'form-control',
                                'placeholder' => 'Message'
                            ]) ?>
                <span class="input-group-btn">
                    <?= Html::submitButton('Send', [
                                'class' => 'btn btn-primary btn-flat'
                            ]) ?>
                </span>
            </div>
        </div>
    </div>
</div>


<?php $this->beginBlock('template_you') ?>
<div class="direct-chat-msg">
    <div class="direct-chat-info clearfix">
        <span  class="direct-chat-name pull-left" data-attr="name"></span>
        <span class="direct-chat-timestamp pull-right" data-attr="time"></span>
    </div>
    <?= Html::img($mainUrl . '/img/user-you.jpg', ['class' => 'direct-chat-img']) ?>
    <div  class="direct-chat-text" data-attr="text"></div>
</div>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('template_me') ?>
<div class="direct-chat-msg right">
    <div class="direct-chat-info clearfix">
        <span class="direct-chat-name pull-right" data-attr="name">Me</span>
        <span class="direct-chat-timestamp pull-left" data-attr="time"></span>
    </div>
    <?= Html::img($mainUrl . '/img/user-me.jpg', ['class' => 'direct-chat-img']) ?>
    <div  class="direct-chat-text" data-attr="text"></div>
</div>
<?php $this->endBlock(); ?>

<?php

$opts = json_encode([
    'messageUrl' => Url::to(['/widget/chat/send-chat']),
    'emp_nm'=>$emp_nm,
    'templateYou' => $this->blocks['template_you'],
    'templateMe' => $this->blocks['template_me'],
    ]);

$this->registerJs("var chatOpts = $opts;");
$this->registerJs($this->render('chataja.js'));

?>