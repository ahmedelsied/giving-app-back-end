<?=$this->get_message();?>
<section class="admin-logged admin-dashboard text-center">
    <div id="site-settings">
        <h3>إضافة مشرف</h3>
        <form class="text-right" id="edit-question-form" action="/admin/supervisors/create" method="POST" enctype="multipart/form-data">
            <?=$this->_token();?>
            <div class="form-group">
                <label for="main-page">الاسم بالكامل</label>
                <input name="full_name" type="text" id="main-page" class="form-control" placeholder="يرجى كتابة حروف انجليزيه" required="required"/>
            </div>
            <div class="form-group">
                <label for="main-page">اسم المستخدم</label>
                <input name="user_name" type="text" id="main-page" class="form-control" placeholder="يرجى كتابة حروف انجليزيه" required="required"/>
            </div>
            <div class="form-group">
                <label for="about-us">الرقم السري</label>
                <input name="password" type="password" id="about-us" class="form-control" placeholder="أدخل الرقم السري" required="required"/>
            </div>
            <div class="form-group">
                <label for="about-us">تأكيد الرقم السري</label>
                <input name="cnfrm-pass" type="password" id="about-us" class="form-control" placeholder="أدخل الرقم السري مره أخرى" required="required"/>
            </div>
            <div class="form-group text-center">
                <button class="btn main-btn" type="submit">اضافه</button>
            </div>
        </form>
    </div>
</section>