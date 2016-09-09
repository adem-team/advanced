<?php

/* extensions*/
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\tabs\TabsX;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\web\View;
/* namespace models*/
use lukisongroup\hrd\models\Employe;
use lukisongroup\widget\models\Chatroom;

	/*
	 * Jangan di Hapus ...
	 * Chat Menu Select Dashboard
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.0
	*/
	$this->sideMenu = $ctrl_chat!=''? $ctrl_chat:'mdefault';
	/*GROUP CHART*/



	

?>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <!-- BOOTSTRAP CORE STYLE CSS -->
    <link href="http://lukisongroup.com/widget/bootstrap-chat/assets/css/bootstrap.css" rel="stylesheet" />
</head>

<div class="col-lg-12">
    <div class="box box-primary direct-chat direct-chat-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Simple Chat</h3>
        </div>
        <div class="box-body">
            <div class="direct-chat-messages" id="message-container">

            </div>
        </div>
        <div class="box-footer">
            <div class="input-group">
                <input type="text" id="inp-chat" placeholder="Type Message ..." class="form-control">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary btn-flat" id="btn-chat">Send</button>
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
    'messageUrl' => Url::to(['/widget/chat/message']),
    'chatUrl' => Url::to(['send-chat']),
    'templateYou' => $this->blocks['template_you'],
    'templateMe' => $this->blocks['template_me'],
    ]);

$this->registerJs("var chatOpts = $opts;");
$this->registerJs($this->render('chat.js'));

?>