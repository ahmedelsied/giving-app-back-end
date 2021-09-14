<?=$this->get_message()?>
<section class="admin-logged admin-dashboard text-center">
    <div id="site-settings">
        <h3>اعدادات الصفحه الشخصيه</h3>
        <form class="text-right" id="edit-question-form" action="/admin/profile_settings/edit" method="POST">
            <?=$this->_token()?>
            <div class="form-group">
                <label for="main-page">اسم السمتخدم</label>
                <input type="text" id="main-page" name="user_name" class="form-control" required="required" placeholder="يرجى كتابة حروف انجليزيه" value="<?=$this->get_session("user_name")?>"/>
            </div>
            <div class="form-group">
                <label for="about-us">الاسم بالكامل</label>
                <input type="text" id="about-us" name="full_name" class="form-control" required="required" placeholder="أدخل الرقم السري القديم" value="<?=$this->get_session("full_name")?>"/>
            </div>
            <div class="form-group">
                <label for="about-us">الرقم السري القديم</label>
                <input type="password" id="about-us" name="old_password" class="form-control" placeholder="أدخل الرقم السري القديم (اتركه فارغ ان لم تريد تغييره)"/>
            </div>
            <div class="form-group">
                <label for="about-us">الرقم السري الجديد</label>
                <input type="password" id="about-us" name="new_password" class="form-control" placeholder="أدخل الرقم السري الجديد (اتركه فارغ ان لم تريد تغييره)"/>
            </div>
            <div class="form-group">
                <label for="about-us">تأكيد الرقم السري الجديد</label>
                <input type="password" id="about-us" name="cnfrm_new_password" class="form-control" placeholder="أدخل الرقم السري الجديد مره أخرى (اتركه فارغ ان لم تريد تغييره)"/>
            </div>
            <div class="form-group text-center">
                <button class="btn main-btn" type="submit">حفظ</button>
            </div>
        </form>
    </div>
</section>