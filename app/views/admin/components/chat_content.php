<div class="chat_content_parent">
    <?php if(!empty($this->messages)):?>
    <div class="chat_content">
    <?php foreach($this->messages as $msg): ?>
        <?php if($this->is_same_side($msg)) : ?>
        <div class="pull-<?=$this->__("settings.align")." user_one"?>" style="padding-<?=$this->__("settings.align")?>:8vw;">
            <span class="avatar"><?=$msg['full_name']?></span>
            <p class="msg-content lead" style="padding-<?=$this->__("settings.align")?>:20px;border-top-<?=$this->__("settings.align")?>-radius:0">
                <?=nl2br($msg["message_content"])?>
            </p>
        </div>
        <?php else:?>
        <div class="pull-<?=$this->__("settings.reverse-align")?> user_two" style="padding-<?=$this->__("settings.reverse-align")?>:8vw;">
            <span class="avatar"><?=$msg['full_name']?></span>
            <p class="msg-content lead" style="border-top-<?=$this->__("settings.reverse-align")?>-radius:0">
                <?=nl2br($msg["message_content"])?>
            </p>
        </div>
        <?php endif;?>
    <?php endforeach;?>
    </div>
    <?php else:?>
    <div class="chat_content">
        <div class="text-center no_messages">
            <p class="lead">لا يوجد رسائل في هذه المحادثه</p>
        </div>
    </div>
    <?php endif;?>
</div>