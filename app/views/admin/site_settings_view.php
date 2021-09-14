<?=$this->get_message()?>
<section class="admin-logged admin-dashboard text-center">
    <div id="site-settings">
        <h3>اعدادات الموقع</h3>
        <form class="text-right" id="edit-question-form" action="/admin/site_settings/update" method="POST" enctype="multipart/form-data">
            <?=$this->_token();?>
            <div class="form-group">
                <label for="logo">لوجو الموقع</label>
                <input type="file" name="logo" id="logo">
            </div>
            <div class="form-group">
                <label for="end-chat-text">رسالة انتهاء المحادثه</label>
                <textarea name="end_chat" id="end-chat-text" class="form-control" placeholder="رسالة انتهاء المحادثه"><?=$this->end_chat?></textarea>
            </div>
            <div class="form-group">
                <label for="main-page">نص الصفحه الرئيسيه</label>
                <textarea name="main_page" id="main-page" class="form-control" placeholder="نص الصفحه الرئيسيه"><?=$this->main_page?></textarea>
            </div>
            <div class="form-group">
                <label for="about-us">نص من نحن</label>
                <textarea name="about_us" id="about-us" class="form-control" placeholder="من نحن"><?=$this->about_us?></textarea>
            </div>
            <div class="form-group">
                <label for="terms">الشروط والأحكام</label>
                <textarea name="terms" id="terms" class="form-control" placeholder="الشروط والأحكام"><?=$this->terms?></textarea>
            </div>
            <div class="form-group text-center">
                <button class="btn main-btn" type="submit">حفظ</button>
            </div>
        </form>
    </div>
</section>