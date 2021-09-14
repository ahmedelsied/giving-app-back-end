<form id="message_sender" method="POST" action="/admin/problems/send_message">
    <?=$this->_token();?>
    <input type="hidden" value="<?=$this->get_session("prob_id")?>"/>
    <div class="form-group">
        <textarea class="border-main-color form-control" name="msg" id="msg-inpt" placeholder="<?=$this->__("user.chat_component.send-ms-ph")?>" required="required"  oninvalid='this.setCustomValidity('<?=$this->__("user.chat_component.type_your_msg")?>')' style="border-<?=$this->__("settings.reverse-align")?>: none;"></textarea>
        <div class="sender_btn_parent">
            <button title="Send Message" class="border-main-color tranparent-btn" style="<?=$this->__("settings.reverse-align")?>:0;border-<?=$this->__("settings.align")?>: none;">
                <i class="fas fa-paper-plane fa-2x main-color"></i>
            </button>
        </div>
    </div>
</form>