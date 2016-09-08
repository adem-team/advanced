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

?>

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

<?php
$opts = json_encode([
    'messageUrl' => Url::to(['/widget/chat/message']),
    'chatUrl' => Url::to(['send-chat']),
    'templateYou' => $this->blocks['template_you'],
    'templateMe' => $this->blocks['template_me'],
    ]);

$this->registerJs("var chatOpts = $opts;");
$this->registerJs($this->render('chat2.js'));

?>