<?=$this->get_message();?>
<section class="admin-logged admin-dashboard text-center">
    <div id="site-settings">
        <h3>تعديل بيانات مشرف</h3>
        <form class="text-right" id="edit-question-form" action="/admin/supervisors/update" method="POST">
            <?=$this->_token();?>
            <input type="hidden" name="supervisor_id" value="<?=$this->supervisor_info['id']?>"/>
            <div class="form-group">
                <label for="main-page">الاسم بالكامل</label>
                <input title="full name" name="full_name" type="text" class="form-control" placeholder="يرجى كتابة حروف انجليزيه" required="required" value="<?=$this->supervisor_info['full_name']?>" />
            </div>
            <div class="form-group">
                <label for="main-page">اسم المستخدم</label>
                <input title="username" name="user_name" type="text" class="form-control" placeholder="يرجى كتابة حروف انجليزيه" value="<?=$this->supervisor_info['user_name']?>"/>
            </div>
            <div class="form-group">
                <label for="about-us">الرقم السري</label>
                <input title="password" name="password" type="password" class="form-control" placeholder="أدخل الرقم السري (اتركه فارغ في حالة عدم تغييره)"/>
            </div>
            <div class="form-group">
                <label for="about-us">تأكيد الرقم السري</label>
                <input title="confirm password" name="cnfrm-pass" type="password" class="form-control" placeholder="أدخل الرقم السري مره أخرى (اتركه فارغ في حالة عدم تغييره)"/>
            </div>
            <div class="form-group text-center">
                <button title="submit" class="btn main-btn" type="submit">حفظ</button>
            </div>
        </form>
    </div>
</section>